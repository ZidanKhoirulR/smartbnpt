<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}" data-theme="light" class="scroll-smooth"
    :class="{ 'theme-dark': dark }" x-data="data()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel SMART | @yield('title', 'Dashboard')</title>

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
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #2563eb, #7c3aed);
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        /* Glass effect */
        .glass-effect {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(209, 213, 219, 0.3);
        }

        .glass-effect-dark {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(17, 24, 39, 0.75);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Pulse animation */
        @keyframes pulse-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .pulse-soft {
            animation: pulse-soft 2s infinite;
        }
    </style>
</head>

<body class="leading-default m-0 h-full bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 font-plusJakartaSans text-base font-normal text-gray-800 dark:text-gray-200 antialiased min-h-screen">
    
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Animated gradient orbs -->
        <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-purple-600/20 rounded-full blur-xl floating" style="animation-delay: 0s;"></div>
        <div class="absolute top-40 right-32 w-24 h-24 bg-gradient-to-br from-green-400/20 to-blue-600/20 rounded-full blur-xl floating" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-32 left-32 w-28 h-28 bg-gradient-to-br from-purple-400/20 to-pink-600/20 rounded-full blur-xl floating" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 right-20 w-20 h-20 bg-gradient-to-br from-yellow-400/20 to-orange-600/20 rounded-full blur-xl floating" style="animation-delay: 0.5s;"></div>
        
        <!-- Grid pattern overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.02)_1px,transparent_1px)] bg-[size:32px_32px] dark:bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)]"></div>
    </div>

    <!-- Enhanced header background -->
    <div class="min-h-75 bg-y-50 min-h-75 absolute top-0 w-full bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 opacity-90">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
    </div>

    @include("dashboard.layouts.sidebar")

    <main class="xl:ml-68 relative h-full max-h-screen rounded-xl transition-all duration-300 ease-in-out">
        @include("dashboard.layouts.navbar")

        <!-- Enhanced content area -->
        <div class="mx-auto w-full px-6 py-6 relative z-10">
            <!-- Content wrapper with glass effect -->
            <div class="glass-effect dark:glass-effect-dark rounded-2xl p-6 shadow-xl border border-white/20 dark:border-gray-700/20 min-h-[calc(100vh-180px)]">
                @yield("container")
            </div>
            
            @include("dashboard.layouts.footer")
        </div>
    </main>

    <!-- Enhanced loading indicator -->
    <div id="loading-overlay" class="fixed inset-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="text-center">
            <div class="relative">
                <div class="w-16 h-16 border-4 border-blue-200 dark:border-blue-800 rounded-full animate-spin border-t-blue-600 dark:border-t-blue-400"></div>
                <div class="absolute inset-0 w-16 h-16 border-4 border-transparent rounded-full animate-ping border-t-blue-400/50"></div>
            </div>
            <p class="mt-4 text-gray-600 dark:text-gray-400 font-medium">Loading...</p>
        </div>
    </div>

    @include("dashboard.layouts.script")
    @yield("js")
    @vite("resources/js/app.js")

    <script>
        // Enhanced page load animation
        document.addEventListener('DOMContentLoaded', function() {
            // Fade in animation for content
            const content = document.querySelector('main');
            content.style.opacity = '0';
            content.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                content.style.transition = 'all 0.6s ease-out';
                content.style.opacity = '1';
                content.style.transform = 'translateY(0)';
            }, 100);

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

            // Add loading states for forms
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        `;
                    }
                });
            });
        });

        // Enhanced notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg z-50 transform translate-x-full transition-transform duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                type === 'warning' ? 'bg-yellow-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white/80 hover:text-white">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
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
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(full)';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }
    </script>
</body>

</html>