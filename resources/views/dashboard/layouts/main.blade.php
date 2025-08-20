<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}" data-theme="light" class="scroll-smooth"
    :class="{ 'theme-dark': dark }" x-data="data()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BPNT Cirebon | @yield('title', 'Dashboard')</title>

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset("img/logo.jpg") }}" />
    <link rel="icon" type="image/png" href="{{ asset("img/logo.jpg") }}" />

    @include("dashboard.layouts.link")
    @yield("css")
    @vite(["resources/css/app.css", "resources/js/app.js"])

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #6366f1, #8b5cf6);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #4f46e5, #7c3aed);
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        /* Glass effect - Softer and more subtle */
        .glass-effect {
            backdrop-filter: blur(12px) saturate(150%);
            -webkit-backdrop-filter: blur(12px) saturate(150%);
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(226, 232, 240, 0.4);
        }

        .glass-effect-dark {
            backdrop-filter: blur(12px) saturate(150%);
            -webkit-backdrop-filter: blur(12px) saturate(150%);
            background-color: rgba(30, 41, 59, 0.95);
            border: 1px solid rgba(100, 116, 139, 0.2);
        }

        /* Soft neutral backgrounds */
        .bg-elegant-gradient-light {
            background: linear-gradient(135deg, #fefefe 0%, #f8fafc 50%, #f1f5f9 100%);
        }

        .bg-elegant-gradient-dark {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
        }

        /* Gentle button styles - More professional colors */
        .btn-elegant {
            @apply px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transform hover:scale-102 transition-all duration-200 focus:ring-3 focus:ring-blue-200 focus:outline-none;
        }

        .btn-elegant-secondary {
            @apply px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg shadow-md hover:shadow-lg transform hover:scale-102 transition-all duration-200 border border-gray-300 focus:ring-3 focus:ring-gray-100 focus:outline-none;
        }

        .btn-elegant-danger {
            @apply px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transform hover:scale-102 transition-all duration-200 focus:ring-3 focus:ring-red-200 focus:outline-none;
        }

        .btn-elegant-success {
            @apply px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transform hover:scale-102 transition-all duration-200 focus:ring-3 focus:ring-green-200 focus:outline-none;
        }

        /* Form styles - Softer and cleaner */
        .form-elegant {
            @apply w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500;
        }

        /* Card styles - Cleaner look */
        .card-elegant {
            @apply bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden;
        }

        /* Floating animation - Gentler */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-4px);
            }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        /* Pulse animation - More subtle */
        @keyframes pulse-elegant {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .pulse-elegant {
            animation: pulse-elegant 4s infinite;
        }

        /* Background patterns - Much more subtle */
        .bg-pattern {
            background-image:
                radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(59, 130, 246, 0.06) 0%, transparent 50%);
        }

        /* Enhanced notification styles */
        .notification-elegant {
            @apply fixed top-6 right-6 max-w-md p-4 rounded-2xl shadow-2xl z-50 transform transition-all duration-300 border;
        }

        .notification-success {
            @apply bg-gradient-to-r from-emerald-50 to-teal-50 border-emerald-200 text-emerald-800;
        }

        .notification-error {
            @apply bg-gradient-to-r from-red-50 to-rose-50 border-red-200 text-red-800;
        }

        .notification-warning {
            @apply bg-gradient-to-r from-amber-50 to-yellow-50 border-amber-200 text-amber-800;
        }

        .notification-info {
            @apply bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 text-blue-800;
        }
    </style>
</head>

<body
    class="leading-default m-0 h-full bg-elegant-gradient-light dark:bg-elegant-gradient-dark font-sans text-base font-normal text-slate-700 dark:text-slate-200 antialiased min-h-screen">

    <!-- Background Elements - Much more subtle -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Very subtle gradient orbs -->
        <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-br from-blue-100/20 to-blue-200/20 dark:from-blue-500/10 dark:to-blue-600/10 rounded-full blur-3xl floating"
            style="animation-delay: 0s;"></div>
        <div class="absolute top-40 right-32 w-24 h-24 bg-gradient-to-br from-gray-100/20 to-gray-200/20 dark:from-gray-500/10 dark:to-gray-600/10 rounded-full blur-3xl floating"
            style="animation-delay: 2s;"></div>
        <div class="absolute bottom-32 left-32 w-28 h-28 bg-gradient-to-br from-blue-100/20 to-gray-200/20 dark:from-blue-500/10 dark:to-gray-600/10 rounded-full blur-3xl floating"
            style="animation-delay: 4s;"></div>

        <!-- Very subtle grid overlay -->
        <div
            class="absolute inset-0 bg-[linear-gradient(rgba(100,116,139,0.015)_1px,transparent_1px),linear-gradient(90deg,rgba(100,116,139,0.015)_1px,transparent_1px)] bg-[size:60px_60px] dark:bg-[linear-gradient(rgba(148,163,184,0.01)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.01)_1px,transparent_1px)]">
        </div>
    </div>

    <!-- Enhanced header background - Much softer -->
    <div
        class="min-h-75 absolute top-0 w-full bg-gradient-to-br from-gray-50 via-blue-50/50 to-gray-100 dark:from-gray-900 dark:via-blue-900/30 dark:to-gray-800 opacity-40">
        <div class="absolute inset-0 bg-pattern"></div>
    </div>

    @include("dashboard.layouts.sidebar")

    <main class="xl:ml-68 relative h-full max-h-screen rounded-xl transition-all duration-300 ease-in-out">
        @include("dashboard.layouts.navbar")

        <!-- Enhanced content area -->
        <div class="mx-auto w-full px-6 py-6 relative z-10">
            <!-- Content wrapper with elegant styling -->
            <div
                class="glass-effect dark:glass-effect-dark rounded-2xl p-8 shadow-lg min-h-[calc(100vh-180px)] border-gray-200/50 dark:border-gray-700/30">
                @yield("container")
            </div>

            @include("dashboard.layouts.footer")
        </div>
    </main>

    <!-- Enhanced loading indicator -->
    <div id="loading-overlay"
        class="fixed inset-0 bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="text-center">
            <div class="relative">
                <div
                    class="w-20 h-20 border-4 border-indigo-200 dark:border-indigo-800 rounded-full animate-spin border-t-indigo-600 dark:border-t-indigo-400">
                </div>
                <div
                    class="absolute inset-0 w-20 h-20 border-4 border-transparent rounded-full animate-ping border-t-indigo-400/50">
                </div>
            </div>
            <p class="mt-6 text-slate-600 dark:text-slate-400 font-medium text-lg">Loading...</p>
        </div>
    </div>

    @include("dashboard.layouts.script")
    @yield("js")
    @vite("resources/js/app.js")

    <script>
        // Enhanced page load animation
        document.addEventListener('DOMContentLoaded', function () {
            // Fade in animation for content
            const content = document.querySelector('main');
            content.style.opacity = '0';
            content.style.transform = 'translateY(30px)';

            setTimeout(() => {
                content.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                content.style.opacity = '1';
                content.style.transform = 'translateY(0)';
            }, 150);

            // Add smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Enhanced form handling
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function () {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        const originalContent = submitBtn.innerHTML;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        `;

                        // Reset button after 10 seconds as fallback
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalContent;
                        }, 10000);
                    }
                });
            });

            // Auto-apply elegant classes to buttons
            document.querySelectorAll('button[type="submit"]:not(.btn-elegant):not(.btn-elegant-secondary):not(.btn-elegant-danger):not(.btn-elegant-success)').forEach(btn => {
                if (!btn.classList.contains('btn-elegant') && !btn.classList.contains('btn-elegant-secondary') && !btn.classList.contains('btn-elegant-danger') && !btn.classList.contains('btn-elegant-success')) {
                    btn.classList.add('btn-elegant');
                }
            });

            // Auto-apply elegant classes to form inputs
            document.querySelectorAll('input:not(.form-elegant), select:not(.form-elegant), textarea:not(.form-elegant)').forEach(input => {
                if (input.type !== 'hidden' && input.type !== 'checkbox' && input.type !== 'radio' && !input.classList.contains('form-elegant')) {
                    input.classList.add('form-elegant');
                }
            });
        });

        // Enhanced notification system
        function showNotification(message, type = 'info', duration = 5000) {
            const notification = document.createElement('div');
            const typeClasses = {
                'success': 'notification-success',
                'error': 'notification-error',
                'warning': 'notification-warning',
                'info': 'notification-info'
            };

            const icons = {
                'success': '<svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                'error': '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
                'warning': '<svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
                'info': '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            };

            notification.className = `notification-elegant ${typeClasses[type] || typeClasses.info} translate-x-full`;
            notification.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        ${icons[type] || icons.info}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-current opacity-70 hover:opacity-100 transition-opacity">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                        </svg>
                    </button>
                </div>
            `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            // Auto remove
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, duration);
        }

        // Expose notification function globally
        window.showNotification = showNotification;
    </script>
</body>

</html>