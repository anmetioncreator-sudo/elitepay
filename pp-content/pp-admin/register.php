<?php
if (!defined('PipraPay_INIT')) {
    http_response_code(403);
    exit('Direct access not allowed');
}

if ($global_user_login == true) {
    ?>
    <script>location.href = "<?php echo $site_url.$path_admin ?>/dashboard";</script>
    <?php
    exit();
}

// Handle Registration POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    header('Content-Type: application/json');

    $submitted_token = $_POST['csrf_token'] ?? '';
    if (empty($submitted_token) || $submitted_token !== ($csrf_token ?? '')) {
        echo json_encode([
            'status'  => 'false',
            'title'   => 'Security Check Failed',
            'message' => 'Invalid or expired session token. Please reload the page.',
            'csrf_token' => $csrf_token
        ]);
        exit();
    }

    $fullname      = trim(escape_string($_POST['full_name'] ?? ''));
    $business_name = trim(escape_string($_POST['business_name'] ?? ''));
    $username      = trim(escape_string($_POST['username'] ?? ''));
    $email         = trim(escape_string($_POST['email'] ?? ''));
    $password      = $_POST['password'] ?? '';
    $confirm_pass  = $_POST['confirm_password'] ?? '';

    if ($fullname === '' || $business_name === '' || $username === '' || $email === '' || $password === '') {
        echo json_encode([
            'status'  => 'false',
            'title'   => 'Missing Information',
            'message' => 'Please fill in all required fields to create your account.',
            'csrf_token' => $csrf_token
        ]);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status'  => 'false',
            'title'   => 'Invalid Email',
            'message' => 'Please provide a valid email address.',
            'csrf_token' => $csrf_token
        ]);
        exit();
    }

    if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $username)) {
        echo json_encode([
            'status'  => 'false',
            'title'   => 'Invalid Username',
            'message' => 'Username must be 3-20 characters long and contain only letters, numbers, hyphens, or underscores.',
            'csrf_token' => $csrf_token
        ]);
        exit();
    }

    if (strlen($password) < 6) {
        echo json_encode([
            'status'  => 'false',
            'title'   => 'Weak Password',
            'message' => 'Password must be at least 6 characters long.',
            'csrf_token' => $csrf_token
        ]);
        exit();
    }

    if ($password !== $confirm_pass) {
        echo json_encode([
            'status'  => 'false',
            'title'   => 'Password Mismatch',
            'message' => 'Passwords do not match. Please recheck and try again.',
            'csrf_token' => $csrf_token
        ]);
        exit();
    }

    // Check if Username already exists
    $params = [':username' => $username];
    $check_user = json_decode(getData($db_prefix . 'admin', 'WHERE username = :username', '* FROM', $params), true);
    if ($check_user['status'] == true && !empty($check_user['response'])) {
        echo json_encode([
            'status'  => 'false',
            'title'   => 'Username Taken',
            'message' => 'This username is already registered. Please choose another one.',
            'csrf_token' => $csrf_token
        ]);
        exit();
    }

    // Check if Email already exists
    $params = [':email' => $email];
    $check_email = json_decode(getData($db_prefix . 'admin', 'WHERE email = :email', '* FROM', $params), true);
    if ($check_email['status'] == true && !empty($check_email['response'])) {
        echo json_encode([
            'status'  => 'false',
            'title'   => 'Email Already Registered',
            'message' => 'An account with this email address already exists. Please log in instead.',
            'csrf_token' => $csrf_token
        ]);
        exit();
    }

    try {
        $a_id = generateItemID();
        $brand_id = generateItemID();

        $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
        $temp_pass   = password_hash(generateStrongPassword(8), PASSWORD_BCRYPT);
        $current_time = getCurrentDatetime('Y-m-d H:i:s');

        // 1. Insert into pp_admin
        $cols = ['a_id', 'full_name', 'username', 'email', 'password', 'temp_password', 'role', 'status', 'created_date', 'updated_date'];
        $vals = [$a_id, $fullname, $username, $email, $hashed_pass, $temp_pass, 'admin', 'active', $current_time, $current_time];
        insertData($db_prefix . 'admin', $cols, $vals);

        // 2. Insert into pp_brands
        $cols = ['brand_id', 'name', 'identify_name', 'created_date', 'updated_date'];
        $vals = [$brand_id, $business_name, $business_name, $current_time, $current_time];
        insertData($db_prefix . 'brands', $cols, $vals);

        // 3. Insert into pp_permission
        $cols = ['brand_id', 'a_id', 'permission', 'status', 'created_date', 'updated_date'];
        $vals = [$brand_id, $a_id, json_encode(permissionSchema()), 'active', $current_time, $current_time];
        insertData($db_prefix . 'permission', $cols, $vals);

        // 4. Insert default currency (BDT)
        $cols = ['brand_id', 'code', 'symbol', 'created_date', 'updated_date'];
        $vals = [$brand_id, 'BDT', '৳', $current_time, $current_time];
        insertData($db_prefix . 'currency', $cols, $vals);

        // 5. Automatic Session Login
        $cookie = bin2hex(random_bytes(16));
        $userInfo = getUserDeviceInfo();

        setsCookie('pp_brand', $brand_id);
        setsCookie('pp_admin', $cookie);

        // Generate 2FA secret
        if (class_exists('PHPGangsta_GoogleAuthenticator')) {
            $ga = new PHPGangsta_GoogleAuthenticator();
            $secret = $ga->createSecret();
            $cols = ['2fa_secret'];
            $vals = [$secret];
            $cond = "a_id = '" . $a_id . "'";
            updateData($db_prefix . 'admin', $cols, $vals, $cond);
        }

        // Log session
        $cols = ['a_id', 'cookie', 'browser', 'device', 'ip', 'created_date', 'updated_date'];
        $vals = [$a_id, $cookie, $userInfo['browser'] ?? 'Browser', $userInfo['device'] ?? 'Device', $userInfo['ip_address'] ?? '127.0.0.1', $current_time, $current_time];
        insertData($db_prefix . 'browser_log', $cols, $vals);

        echo json_encode([
            'status'  => 'true',
            'title'   => 'Account Created Successfully!',
            'message' => 'Welcome to ElitePay! Launching your merchant dashboard...',
            'target'  => $site_url . $path_admin . '/dashboard',
            'csrf_token' => $csrf_token
        ]);
        exit();

    } catch (Throwable $e) {
        echo json_encode([
            'status'  => 'false',
            'title'   => 'Registration Error',
            'message' => 'Could not complete registration: ' . $e->getMessage(),
            'csrf_token' => $csrf_token
        ]);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="ElitePay">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Merchant Account — ElitePay</title>
    <link rel="shortcut icon" href="<?= $piprapay_favicon ?? $site_url.'assets/images/elitepay-favicon.svg' ?>">
    <link rel="stylesheet" href="<?php echo $site_url ?>assets/css/tabler.min.css?v=1.5" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-vendors.min.css" />

    <style>
      @import url("<?php echo $site_url ?>assets/css/inter.css");
    </style>
    <style>
        :root{
            --tblr-font-monospace: Monaco, Consolas, Liberation Mono, Courier New, monospace;
            --tblr-font-sans-serif: Inter Var, Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            --tblr-font-serif: Georgia, Times New Roman, times, serif;
            --tblr-font-comic: Comic Sans MS, Comic Sans, Chalkboard SE, Comic Neue, sans-serif, cursive;
        }
    </style>
</head>
<body cz-shortcut-listen="true">
    <div class="page page-center py-4">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="<?= $site_url ?>"><img src="<?= $piprapay_logo_light ?? $site_url.'assets/images/elitepay-logo-dark.svg' ?>" alt="ElitePay" style="height: 42px;"></a>
            </div>
            
            <div class="card card-md shadow-sm">
                <div class="card-body">
                    <h2 class="h2 text-center mb-1">Create Merchant Account</h2>
                    <p class="text-center text-secondary mb-4">Start automating payments with ElitePay in minutes</p>

                    <form action="register" method="POST" class="form-register">
                        <input type="hidden" name="action" value="register">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">

                        <div class="mb-3">
                            <label class="form-label required">Full Name</label>
                            <input type="text" class="form-control" name="full_name" placeholder="John Doe" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Business or Store Name</label>
                            <input type="text" class="form-control" name="business_name" placeholder="e.g. Acme Tech, ShopZone" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="johndoe" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Email Address</label>
                                <input type="email" class="form-control" name="email" placeholder="john@example.com" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="At least 6 characters" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Re-type password" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" required checked>
                                <span class="form-check-label text-secondary small">
                                    I agree to the <a href="javascript:void(0)" tabindex="-1">Terms of Service</a> and <a href="javascript:void(0)" tabindex="-1">Privacy Policy</a>.
                                </span>
                            </label>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100 btn-submit">
                                Create Account & Access Dashboard
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center text-secondary mt-3">
                Already have a merchant account? <a href="<?php echo $site_url ?>login" class="text-primary font-weight-bold">Sign in here</a>
            </div>
        </div>
    </div>

    <script src="<?php echo $site_url ?>assets/js/tabler.min.js"></script>
    <script src="<?php echo $site_url ?>assets/js/jquery-3.6.4.min.js"></script>
    <script src="<?php echo $site_url ?>assets/js/custom-toast.js?v=1.2"></script>

    <script data-cfasync="false">
        $('.form-register').submit(function (e) {
            e.preventDefault();

            var btn = document.querySelector(".btn-submit");
            var originalBtnHtml = btn.innerHTML;
            btn.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"></div> Creating your account...';
            btn.disabled = true;

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'register',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    btn.innerHTML = originalBtnHtml;
                    btn.disabled = false;

                    if (response.csrf_token) {
                        $('input[name="csrf_token"]').val(response.csrf_token);
                    }

                    if (response.status === 'true') {
                        createToast({
                            title: response.title,
                            description: response.message,
                            svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5f38f9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>`,
                            timeout: 3000
                        });

                        setTimeout(function () {
                            location.href = response.target;
                        }, 1200);
                    } else {
                        createToast({
                            title: response.title,
                            description: response.message,
                            svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d63939" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>`,
                            timeout: 5000
                        });
                    }
                },
                error: function (xhr, status, error) {
                    btn.innerHTML = originalBtnHtml;
                    btn.disabled = false;

                    createToast({
                        title: 'Registration Error',
                        description: 'Something went wrong. Please check your connection and try again.',
                        svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d63939" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>`,
                        timeout: 5000
                    });
                }
            });
        });
    </script>
</body>
</html>
