<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Penerimaan BPNT</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-bg {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            position: relative;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
        }

        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.4);
        }

        .icon-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .input-focus:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .error-notification {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-close:hover {
            background-color: rgba(239, 68, 68, 0.2);
        }

        .mobile-menu {
            display: none;
        }

        .mobile-menu.active {
            display: block;
        }
    </style>
</head>

<body class="hero-bg min-h-screen">
    <!-- Navigation -->
    <nav class="navbar fixed w-full z-50 px-6 py-4" id="navbar">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-xl text-gray-900">SPK BPNT</div>
                    <div class="text-sm text-gray-600">Metode SMARTER</div>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Beranda</a>
                <a href="/login" class="text-blue-600 font-semibold">Login</a>
                <button onclick="checkResult()"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Cek Hasil</button>
                <a href="/#tentang" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Tentang
                    Kami</a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-gray-700" onclick="toggleMobileMenu()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="mobile-menu md:hidden mt-4 px-6 py-4 bg-white rounded-lg mx-6">
            <div class="space-y-3">
                <a href="/" class="block text-gray-700 hover:text-blue-600 font-medium">Beranda</a>
                <a href="/login" class="block text-blue-600 font-semibold">Login</a>
                <button onclick="checkResult()"
                    class="block text-gray-700 hover:text-blue-600 font-medium text-left w-full">Cek Hasil</button>
                <a href="/#tentang" class="block text-gray-700 hover:text-blue-600 font-medium">Tentang Kami</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-24 flex items-center justify-center min-h-screen">
        <!-- Background Pattern -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="icon-float absolute top-20 left-10">
                <div class="w-16 h-16 bg-white bg-opacity-10 rounded-full"></div>
            </div>
            <div class="icon-float absolute top-40 right-20" style="animation-delay: 1s;">
                <div class="w-12 h-12 bg-white bg-opacity-10 rounded-full"></div>
            </div>
            <div class="icon-float absolute bottom-32 left-20" style="animation-delay: 2s;">
                <div class="w-20 h-20 bg-white bg-opacity-10 rounded-full"></div>
            </div>
            <div class="icon-float absolute bottom-20 right-10" style="animation-delay: 0.5s;">
                <div class="w-14 h-14 bg-white bg-opacity-10 rounded-full"></div>
            </div>
        </div>

        <div class="relative z-10 w-full max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side - Welcome Content -->
                <div class="text-white space-y-6">
                    <!-- Logo and Title -->
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-xl">SPK BPNT</div>
                            <div class="text-sm text-blue-100">Kabupaten Cirebon</div>
                        </div>
                    </div>

                    <div>
                        <h1 class="text-4xl font-bold mb-4">
                            Sistem Pendukung Keputusan
                        </h1>
                        <h2 class="text-2xl font-semibold text-yellow-300 mb-6">
                            Penerimaan BPNT
                        </h2>
                        <p class="text-lg text-blue-100 leading-relaxed">
                            Menggunakan metode SMARTER (Simple Multi-Attribute Rating Technique Extended to Ranking)
                            untuk memberikan transparansi dan akurasi dalam proses seleksi
                            penerima Bantuan Pangan Non Tunai.
                        </p>
                    </div>

                    <!-- Features List -->
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-blue-100">Proses seleksi objektif dan transparan</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-blue-100">Perhitungan otomatis dan akurat</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-blue-100">Interface yang mudah digunakan</span>
                        </div>
                    </div>

                    <!-- Character Illustrations -->
                    <div class="flex justify-center space-x-6 mt-8">
                        <div class="icon-float">
                            <div
                                class="w-16 h-20 bg-gradient-to-b from-purple-400 to-purple-600 rounded-t-full rounded-b-lg relative">
                                <div
                                    class="absolute top-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-yellow-200 rounded-full">
                                </div>
                                <div
                                    class="absolute bottom-4 left-1/2 transform -translate-x-1/2 w-10 h-10 bg-white rounded-lg">
                                </div>
                            </div>
                        </div>
                        <div class="icon-float" style="animation-delay: 0.5s;">
                            <div
                                class="w-16 h-20 bg-gradient-to-b from-red-400 to-red-600 rounded-t-full rounded-b-lg relative">
                                <div
                                    class="absolute top-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-yellow-200 rounded-full">
                                </div>
                                <div
                                    class="absolute bottom-4 left-1/2 transform -translate-x-1/2 w-10 h-10 bg-white rounded-lg">
                                </div>
                            </div>
                        </div>
                        <div class="icon-float" style="animation-delay: 1s;">
                            <div
                                class="w-16 h-20 bg-gradient-to-b from-blue-400 to-blue-600 rounded-t-full rounded-b-lg relative">
                                <div
                                    class="absolute top-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-yellow-200 rounded-full">
                                </div>
                                <div
                                    class="absolute bottom-4 left-1/2 transform -translate-x-1/2 w-10 h-10 bg-white rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="login-card rounded-3xl p-8 lg:p-10">
                    <div class="mb-4">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Login Member</h2>
                        <p class="text-gray-600">Masuk untuk mengakses sistem SPK BPNT</p>
                    </div>

                    <!-- Demo Credentials Info -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mt-0.5">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800 mb-1">Akun Demo</h4>
                                <div class="text-xs text-blue-700 space-y-1">
                                    <p><strong>Email:</strong> admin@bpnt.go.id</p>
                                    <p><strong>Password:</strong> admin123</p>
                                    <p class="text-blue-600">Gunakan kredensial di atas untuk login demo</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                        @csrf

                        <!-- Error Notification -->
                        @if ($errors->any())
                            <div id="errorNotification"
                                class="error-notification bg-red-50 border border-red-200 rounded-xl p-4 flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-sm font-medium text-red-800">Login Gagal</h4>
                                    <p class="text-sm text-red-700">Email atau password yang Anda masukkan salah. Silakan
                                        periksa kembali dan coba lagi.</p>
                                </div>
                                <button type="button" onclick="closeErrorNotification()"
                                    class="error-close flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center hover:bg-red-100 transition-colors">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none input-focus transition-all @error('email') border-red-500 @enderror"
                                placeholder="Masukkan Email Anda">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none input-focus transition-all @error('password') border-red-500 @enderror pr-12"
                                    placeholder="Masukkan password Anda">
                                <button type="button" onclick="togglePassword()"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                            </label>
                            <button type="button" onclick="fillDemoCredentials()"
                                class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                Isi Kredensial Demo
                            </button>
                        </div>

                        <button type="submit"
                            class="w-full btn-primary text-white py-3 rounded-xl font-semibold text-lg">
                            Login Sekarang
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <a href="/" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                            ← Kembali ke Beranda
                        </a>
                    </div>

                    <!-- Quick Info -->
                    <div class="mt-8 p-4 bg-blue-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-800">Informasi Sistem</p>
                                <p class="text-xs text-blue-600">Menggunakan metode SMARTER untuk proses seleksi yang
                                    objektif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-center">
        <p class="text-white text-sm opacity-75">
            &copy; 2025 SPK BPNT Kabupaten Cirebon - Transparansi dalam Setiap Keputusan
        </p>
    </div>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('active');
        }

        function checkResult() {
            window.location.href = "/#beranda";
        }

        function closeErrorNotification() {
            const notification = document.getElementById('errorNotification');
            if (notification) {
                notification.style.display = 'none';
            }
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        function fillDemoCredentials() {
            document.querySelector('input[name="email"]').value = 'admin@bpnt.go.id';
            document.querySelector('input[name="password"]').value = 'admin123';

            // Add visual feedback
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = '✓ Kredensial Diisi';
            button.classList.add('text-green-600');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('text-green-600');
            }, 2000);
        }

        // Auto hide error notification after 8 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const notification = document.getElementById('errorNotification');
            if (notification && notification.style.display !== 'none') {
                setTimeout(() => {
                    closeErrorNotification();
                }, 8000);
            }

            // Close mobile menu when clicking outside
            document.addEventListener('click', function (event) {
                const mobileMenu = document.getElementById('mobileMenu');
                const menuButton = event.target.closest('button');

                if (!mobileMenu.contains(event.target) && !menuButton) {
                    mobileMenu.classList.remove('active');
                }
            });

            // Auto-fill demo credentials hint
            const emailInput = document.querySelector('input[name="email"]');
            const passwordInput = document.querySelector('input[name="password"]');

            emailInput.addEventListener('focus', function () {
                if (!this.value) {
                    this.placeholder = 'Coba: admin@bpnt.go.id';
                }
            });

            emailInput.addEventListener('blur', function () {
                if (!this.value) {
                    this.placeholder = 'Masukkan Email Anda';
                }
            });

            passwordInput.addEventListener('focus', function () {
                if (!this.value) {
                    this.placeholder = 'Coba: admin123';
                }
            });

            passwordInput.addEventListener('blur', function () {
                if (!this.value) {
                    this.placeholder = 'Masukkan password Anda';
                }
            });
        });
    </script>

</body>

</html>