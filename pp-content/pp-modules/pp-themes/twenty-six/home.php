<?php
    if (!defined('PipraPay_INIT')) {
        http_response_code(403);
        exit('Direct access not allowed');
    }

    $brand_name = "ZiniPay";
    $brand_tagline = "Best Online Payment Automation in Bangladesh 2026";
    $login_url = (!empty($site_url)) ? rtrim($site_url, '/') . '/pp-content/pp-admin/login.php' : 'login.html';
    $register_url = (!empty($site_url)) ? rtrim($site_url, '/') . '/pp-content/pp-admin/register.php' : 'register.html';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?= htmlspecialchars($brand_name) ?> — <?= htmlspecialchars($brand_tagline) ?></title>
    <meta name="description" content="ZiniPay helps Bangladesh businesses accept and verify bKash, Nagad, Rocket, and Upay payments automatically with API and plugin support."/>
    <meta name="keywords" content="payment automation Bangladesh, best online payment automation in Bangladesh, bKash payment automation, Nagad payment verification, Rocket payment automation, payment without merchant account, personal number payment automation, WooCommerce payment gateway Bangladesh, SMM panel payment gateway Bangladesh, multi user payment dashboard, team management payment dashboard, payment automation for entrepreneurs, payment gateway for business owners Bangladesh, payment automation for online sellers, ZiniPay API"/>
    <link rel="shortcut icon" href="<?= htmlspecialchars($elitepay_favicon ?? $piprapay_favicon ?? 'assets/images/elitepay-favicon.svg') ?>" type="image/svg+xml"/>

    <!-- Google Fonts: Poppins & Plus Jakarta Sans & Fira Code -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        sky: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        ziniblue: {
                            400: '#5bc0ff',
                            500: '#007aff',
                            600: '#0062cc',
                        },
                        slate: {
                            950: '#071426',
                            900: '#0b1324',
                            850: '#0f1a32',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', '"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"Fira Code"', 'monospace'],
                    },
                    animation: {
                        'brand-slide': 'brandSlide 55s linear infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        brandSlide: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-50%)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .text-gradient-sky {
            background: linear-gradient(90deg, #38bdf8 0%, #0284c7 50%, #38bdf8 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-zini-gradient {
            background: linear-gradient(90deg, #007aff 0%, #5bc0ff 50%, #007aff 100%);
            background-size: 200% auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(0, 122, 255, 0.3);
        }
        .btn-zini-gradient:hover {
            background-position: right center;
            box-shadow: 0 12px 30px rgba(0, 122, 255, 0.45);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100 antialiased selection:bg-sky-500 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-sky-700 via-sky-600 to-cyan-500 text-white text-xs sm:text-sm py-2 px-4 text-center font-medium shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-2">
            <span class="bg-white/20 px-2.5 py-0.5 rounded-full text-[11px] uppercase tracking-wider font-bold">New</span>
            <span>⚡ ZiniPay 3.1 is live — Instant Personal Number Verification & Multi-Device SMS Sync.</span>
            <a href="#demo-sandbox" onclick="openSandboxModal()" class="underline underline-offset-2 hover:text-cyan-100 transition font-semibold cursor-pointer">Try Live Demo &rarr;</a>
        </div>
    </div>

    <!-- Sticky Navigation Header -->
    <header class="relative">
        <nav class="fixed left-0 z-50 w-full px-4 py-3 transition-all duration-300 sm:px-6 lg:px-8 top-0 border-b border-slate-100/80 bg-white/80 backdrop-blur-xl dark:border-slate-800/80 dark:bg-slate-950/70 shadow-sm">
            <div class="mx-auto flex h-14 w-full max-w-7xl items-center justify-between gap-4">
                
                <!-- Brand Logo -->
                <a class="flex shrink-0 items-center gap-3" aria-label="ZiniPay Home" href="./">
                    <span class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full border border-sky-100 bg-sky-50 shadow-sm dark:border-sky-500/20 dark:bg-slate-900">
                        <svg class="h-6 w-6 text-sky-600 dark:text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                        </svg>
                    </span>
                    <span class="leading-none">
                        <span class="block text-xl font-extrabold tracking-tight text-sky-600 dark:text-white"><?= htmlspecialchars($brand_name) ?></span>
                        <span class="hidden text-[10px] font-bold uppercase tracking-[0.18em] text-sky-900 dark:text-sky-300 sm:block">Payment Automation</span>
                    </span>
                </a>

                <!-- Desktop Navigation Menu Pills -->
                <div class="hidden items-center gap-1 rounded-full border border-slate-200/80 bg-white/80 px-2 py-1 shadow-sm dark:border-slate-800 dark:bg-slate-900/80 lg:flex">
                    <a class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white" href="./">Home</a>
                    <a class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white" href="#pricing">Pricing</a>
                    
                    <button onclick="openSandboxModal()" class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white cursor-pointer">
                        <span>Demo Sandbox</span>
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" class="h-3 w-3 text-sky-500" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M432,320H400a16,16,0,0,0-16,16V448H64V128H208a16,16,0,0,0,16-16V80a16,16,0,0,0-16-16H48A48,48,0,0,0,0,112V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V336A16,16,0,0,0,432,320ZM488,0h-128c-21.37,0-32.05,25.91-17,41l35.73,35.73L135,320.37a24,24,0,0,0,0,34L157.67,377a24,24,0,0,0,34,0L435.28,133.32,471,169c15,15,41,4.5,41-17V24A24,24,0,0,0,488,0Z"></path></svg>
                    </button>

                    <a class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white" href="#how-it-works">How It Works</a>
                    <a class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white" href="#gateways">Gateways</a>
                    <a class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white" href="#integrations">Plugins</a>
                    <a class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-950 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white" href="#faq">FAQ</a>
                </div>

                <!-- Right Action Buttons -->
                <div class="hidden items-center gap-3 lg:flex">
                    <a target="_blank" rel="noreferrer" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-sky-600 transition-colors hover:border-sky-300 hover:bg-sky-50 dark:border-slate-800 dark:bg-slate-900 dark:text-sky-300" aria-label="Telegram updates" href="https://t.me/s/zinipay">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 496 512" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm121.8 169.9l-40.7 191.8c-3 13.6-11.1 16.9-22.4 10.5l-62-45.7-29.9 28.8c-3.3 3.3-6.1 6.1-12.5 6.1l4.4-63.1 114.9-103.8c5-4.4-1.1-6.9-7.7-2.5l-142 89.4-61.2-19.1c-13.3-4.2-13.6-13.3 2.8-19.7l239.1-92.2c11.1-4 20.8 2.7 17.2 19.5z"></path></svg>
                    </a>

                    <a class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-sky-600 to-cyan-500 px-5 py-2.5 text-sm font-bold text-white shadow-sm shadow-sky-500/25 transition-all hover:from-sky-700 hover:to-cyan-600 hover:shadow-md hover:shadow-sky-500/30" href="<?= htmlspecialchars($login_url) ?>">
                        <span>Login</span>
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path></svg>
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <button id="mobileMenuBtn" aria-label="Toggle menu" class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-900 shadow-sm transition-colors hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-white lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </nav>
    </header>

    <main class="pt-16 sm:pt-20">

        <!-- ==================== HERO SECTION ==================== -->
        <section class="relative overflow-hidden bg-gradient-to-b from-white via-sky-50/40 to-[#f5f9ff] py-20 md:py-32 px-6 md:px-10 text-gray-900 dark:from-slate-950 dark:via-[#071426] dark:to-[#071426] dark:text-slate-100">
            <div class="pointer-events-none absolute -top-32 -left-24 h-80 w-80 rounded-full bg-[#58b4ff]/20 blur-3xl"></div>
            <div class="pointer-events-none absolute top-1/3 -right-28 h-96 w-96 rounded-full bg-[#8dcfff]/25 blur-3xl"></div>
            <div class="pointer-events-none absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-white via-transparent dark:from-slate-950"></div>

            <div class="relative z-10 mx-auto flex w-full max-w-7xl flex-col items-center gap-16 lg:flex-row lg:justify-between">
                
                <div class="w-full max-w-2xl space-y-8 text-left">
                    <div class="inline-flex items-center gap-2 rounded-full border border-sky-400/50 bg-sky-100/60 px-4 py-1.5 text-xs font-bold tracking-[0.16em] text-sky-600 shadow-sm backdrop-blur dark:border-sky-400/40 dark:bg-sky-400/10 dark:text-sky-200">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-sky-500 animate-ping"></span>
                        <span class="inline-flex h-2.5 w-2.5 -ml-4 rounded-full bg-sky-500"></span>
                        <span>TRUSTED BY 500+ BUSINESSES</span>
                    </div>

                    <div class="space-y-3">
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.15] tracking-tight">
                            Smart Payment Automation
                            <span class="block bg-gradient-to-r from-sky-400 via-sky-600 to-sky-400 bg-[length:200%] bg-clip-text text-transparent">
                                For Your Business
                            </span>
                        </h1>
                    </div>

                    <p class="text-gray-600 leading-relaxed text-base sm:text-lg dark:text-slate-300 max-w-xl">
                        ZiniPay is a simple and secure online payment automation in Bangladesh that helps businesses receive money through bKash, Nagad, Rocket, and Upay. It offers an easy API and plugins so any website can set up payments quickly.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="#pricing" class="btn-zini-gradient rounded-full px-8 py-3.5 font-bold text-white shadow-lg shadow-sky-500/30 flex items-center gap-2 hover:scale-[1.02] transition">
                            <span>Get Started</span>
                            <span class="text-lg">&rarr;</span>
                        </a>
                        <a href="<?= htmlspecialchars($login_url) ?>" class="rounded-full border border-gray-300 bg-white/80 px-8 py-3.5 font-bold text-gray-700 backdrop-blur transition-all hover:border-[#007aff]/60 hover:text-[#007aff] hover:bg-white dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-100 dark:hover:border-sky-400">
                            Login
                        </a>
                    </div>
                </div>

                <!-- Right Phone Visual -->
                <div class="relative flex w-full max-w-md items-center justify-center lg:w-auto">
                    <div class="relative z-20 w-full max-w-[320px] rounded-[36px] border-[6px] border-slate-900 bg-slate-900 p-3 shadow-2xl shadow-sky-500/20">
                        <div class="relative w-full rounded-[28px] bg-slate-950 overflow-hidden border border-slate-800 text-white p-4">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></div>
                                    <span class="text-[11px] font-mono font-bold tracking-wider text-emerald-400">ZINIPAY DAEMON</span>
                                </div>
                                <span class="text-[10px] font-mono text-slate-400">LIVE SYNC</span>
                            </div>

                            <div class="mt-4 rounded-2xl border border-sky-500/40 bg-gradient-to-b from-sky-900/30 to-slate-900/90 p-3.5 shadow-lg">
                                <div class="text-[11px] leading-relaxed text-slate-300 font-mono bg-slate-950/70 p-2 rounded-lg border border-slate-800">
                                    "You have received Tk <span class="text-emerald-400 font-bold">1,250.00</span> from 01712***901. TrxID: <span class="text-sky-300 font-bold">BK902KA1X</span>"
                                </div>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                                        &check; Order #4092 Verified
                                    </span>
                                    <span class="text-[9px] rounded-full bg-emerald-500/20 px-2 py-0.5 font-mono text-emerald-300">0.4s</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- ==================== STATS COUNTER ==================== -->
        <section class="relative z-20 -mt-10 sm:-mt-14 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-slate-100 border border-slate-200/80 rounded-2xl overflow-hidden bg-white shadow-xl dark:bg-slate-900 dark:border-slate-800 dark:divide-slate-800">
                <div class="relative px-8 py-8">
                    <p class="text-[11px] font-mono text-slate-400 tracking-wide mb-2 uppercase">payments.verified</p>
                    <p class="font-mono text-3xl font-extrabold text-slate-900 dark:text-white">1,500,000<span class="text-sky-500 ml-0.5">+</span></p>
                </div>
                <div class="relative px-8 py-8">
                    <p class="text-[11px] font-mono text-slate-400 tracking-wide mb-2 uppercase">volume.total</p>
                    <p class="font-mono text-3xl font-extrabold text-slate-900 dark:text-white">৳ 250M<span class="text-sky-500 ml-0.5">+</span></p>
                </div>
                <div class="relative px-8 py-8">
                    <p class="text-[11px] font-mono text-slate-400 tracking-wide mb-2 uppercase">businesses.active</p>
                    <p class="font-mono text-3xl font-extrabold text-slate-900 dark:text-white">500<span class="text-sky-500 ml-0.5">+</span></p>
                </div>
            </div>
        </section>


        <!-- ==================== BRAND MARQUEE ==================== -->
        <section class="border-y border-slate-200 bg-white py-6 text-slate-900 dark:border-slate-800 dark:bg-slate-950 dark:text-white overflow-hidden mt-16">
            <div class="relative w-full overflow-hidden flex items-center">
                <div class="flex w-max animate-brand-slide items-center gap-14 whitespace-nowrap py-2">
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">The Elyn</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">Think Anticlockwise</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">Unico Hospitals PLC</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">TryZoneX</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">ABC Proxy</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">SMM PRO BD</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">Digital Product BD</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">HeeSay Shop</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">Fityah Quran Academy</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">Sohel Math Care</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">EASYSEBA</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">IPDokan</span>
                    <span class="text-base font-semibold text-slate-600 dark:text-slate-300">SMM NEXT</span>
                </div>
            </div>
        </section>


        <!-- ==================== PRICING ==================== -->
        <section id="pricing" class="py-24 bg-white dark:bg-slate-950 text-slate-900 dark:text-white">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Simple Pricing — 0% Commission</h2>
                </div>

                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Monthly</span>
                        <div class="mt-4 text-4xl font-extrabold">৳ 100 <span class="text-sm font-normal text-slate-500">/ mo</span></div>
                        <a href="<?= htmlspecialchars($register_url) ?>" class="mt-8 block text-center rounded-xl border border-slate-300 py-3 text-xs font-bold">Get Started</a>
                    </div>

                    <div class="rounded-3xl border-2 border-sky-500 bg-gradient-to-b from-sky-50/50 to-white p-8 shadow-xl dark:from-slate-900 dark:to-slate-900 dark:border-sky-500">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-600">Yearly (50% OFF)</span>
                        <div class="mt-4 text-4xl font-extrabold">৳ 600 <span class="text-sm font-normal text-slate-500">/ yr</span></div>
                        <a href="<?= htmlspecialchars($register_url) ?>" class="mt-8 block text-center rounded-xl btn-zini-gradient py-3 text-xs font-bold text-white shadow-md">Choose Yearly &rarr;</a>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Lifetime</span>
                        <div class="mt-4 text-4xl font-extrabold">৳ 2,500 <span class="text-sm font-normal text-slate-500">/ life</span></div>
                        <a href="<?= htmlspecialchars($register_url) ?>" class="mt-8 block text-center rounded-xl border border-slate-300 py-3 text-xs font-bold">Get Lifetime</a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-[#0D0D10] text-white py-12 border-t border-slate-800 text-center text-xs text-gray-500">
        <p>&copy; 2026 ZiNiPay. All rights reserved.</p>
    </footer>
</body>
</html>
