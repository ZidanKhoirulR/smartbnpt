<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Penerimaan BPNT - Metode SMARTER</title>
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

        .btn-primary {
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.4);
        }

        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .welcome-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .search-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .search-box:focus-within {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
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

        .slide-in {
            animation: slideInUp 0.6s ease-out forwards;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* SMARTER Animated Text */
        .smarter-text {
            font-size: 5rem;
            font-weight: 800;
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }

        .smarter-letter {
            display: inline-block;
            animation: letterBounce 2s ease-in-out infinite;
            margin: 0 0.1em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .smarter-letter:nth-child(1) {
            color: #ef4444;
            animation-delay: 0s;
        }

        .smarter-letter:nth-child(2) {
            color: #f97316;
            animation-delay: 0.1s;
        }

        .smarter-letter:nth-child(3) {
            color: #eab308;
            animation-delay: 0.2s;
        }

        .smarter-letter:nth-child(4) {
            color: #22c55e;
            animation-delay: 0.3s;
        }

        .smarter-letter:nth-child(5) {
            color: #3b82f6;
            animation-delay: 0.4s;
        }

        .smarter-letter:nth-child(6) {
            color: #8b5cf6;
            animation-delay: 0.5s;
        }

        .smarter-letter:nth-child(7) {
            color: #ec4899;
            animation-delay: 0.6s;
        }

        @keyframes letterBounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0) scale(1);
            }

            40% {
                transform: translateY(-20px) scale(1.1);
            }

            60% {
                transform: translateY(-10px) scale(1.05);
            }
        }

        .smarter-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 5px currentColor, 0 0 10px currentColor, 0 0 15px currentColor;
            }

            to {
                text-shadow: 0 0 10px currentColor, 0 0 20px currentColor, 0 0 30px currentColor;
            }
        }

        .mobile-menu {
            display: none;
        }

        .mobile-menu.active {
            display: block;
        }

        .search-result {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        footer {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        /* About section styling */
        .about-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        /* Loading animation for login */
        .loading {
            display: none;
        }

        .loading.active {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Smooth section transitions */
        section {
            scroll-margin-top: 80px;
        }
    </style>
</head>

<body class="bg-gray-50">
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
                <a href="#beranda" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Beranda</a>
                <button onclick="loginPage()" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                    Login
                    <svg class="loading w-4 h-4 ml-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <button onclick="checkResult()"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Cek Hasil</button>
                <a href="#tentang" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Tentang
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
                <a href="#beranda" class="block text-gray-700 hover:text-blue-600 font-medium">Beranda</a>
                <button onclick="loginPage()"
                    class="block text-gray-700 hover:text-blue-600 font-medium text-left w-full">Login</button>
                <button onclick="checkResult()"
                    class="block text-gray-700 hover:text-blue-600 font-medium text-left w-full">Cek Hasil</button>
                <a href="#tentang" class="block text-gray-700 hover:text-blue-600 font-medium">Tentang Kami</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section / Beranda -->
    <section id="beranda" class="hero-bg min-h-screen pt-24">
        <!-- Background Pattern -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="icon-float absolute top-32 left-10">
                <div class="w-16 h-16 bg-white bg-opacity-10 rounded-full"></div>
            </div>
            <div class="icon-float absolute top-52 right-20" style="animation-delay: 1s;">
                <div class="w-12 h-12 bg-white bg-opacity-10 rounded-full"></div>
            </div>
            <div class="icon-float absolute bottom-32 left-20" style="animation-delay: 2s;">
                <div class="w-20 h-20 bg-white bg-opacity-10 rounded-full"></div>
            </div>
            <div class="icon-float absolute bottom-20 right-10" style="animation-delay: 0.5s;">
                <div class="w-14 h-14 bg-white bg-opacity-10 rounded-full"></div>
            </div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-12">
            <!-- Welcome Header -->
            <div class="text-center text-white mb-12 fade-in">
                <h1 class="text-6xl font-bold mb-4">Selamat Datang</h1>
                <h2 class="text-4xl font-semibold text-yellow-300 mb-6">
                    SPK Metode
                </h2>

                <!-- Animated SMARTER Text -->
                <div class="smarter-text mb-6">
                    <span class="smarter-letter smarter-glow">S</span>
                    <span class="smarter-letter smarter-glow">M</span>
                    <span class="smarter-letter smarter-glow">A</span>
                    <span class="smarter-letter smarter-glow">R</span>
                    <span class="smarter-letter smarter-glow">T</span>
                    <span class="smarter-letter smarter-glow">E</span>
                    <span class="smarter-letter smarter-glow">R</span>
                </div>

                <p class="text-xl text-blue-100 leading-relaxed max-w-4xl mx-auto mb-8">
                    Sistem Pendukung Keputusan Penerimaan BPNT dengan metode
                    <span class="font-bold text-yellow-300">SMARTER</span>
                    untuk transparansi dan akurasi tertinggi dalam seleksi penerima bantuan
                </p>
            </div>

            <!-- Search NIK Section -->
            <div class="welcome-card rounded-3xl p-8 lg:p-12 mb-8 slide-in" style="animation-delay: 0.2s;">
                <div class="text-center mb-8">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Cek Status Penerima BPNT</h3>
                    <p class="text-lg text-gray-600">Masukkan NIK untuk mengetahui status penerimaan bantuan Anda</p>
                </div>

                <div class="max-w-2xl mx-auto">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" id="nikInput" placeholder="Masukkan NIK (16 digit)" maxlength="16"
                                class="search-box w-full px-6 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"
                                onkeypress="handleEnterSearch(event)">
                        </div>
                        <button onclick="searchNIK()"
                            class="btn-primary text-white px-8 py-4 rounded-xl font-semibold text-lg whitespace-nowrap">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari NIK
                        </button>
                    </div>

                    <!-- Search Result -->
                    <div id="searchResult" class="search-result rounded-xl p-6 mt-6 hidden">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Status Penerima BPNT</h4>
                                <div id="resultContent" class="space-y-2 text-gray-700">
                                    <!-- Result will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-800">Informasi</p>
                                <p class="text-xs text-blue-600">Pastikan NIK yang dimasukkan sesuai dengan KTP dan
                                    terdaftar di sistem</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SMARTER Method Info -->
            <div class="welcome-card rounded-3xl p-8 lg:p-10 mb-8 slide-in" style="animation-delay: 0.4s;">
                <div class="text-center mb-8">
                    <h3 class="text-4xl font-bold text-gray-900 mb-4">Metode SMARTER</h3>
                    <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                        Simple Multi-Attribute Rating Technique Extended to Ranking dengan Evaluation dan Review
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-7 gap-4">
                    <div class="bg-red-50 rounded-xl p-6 text-center hover:bg-red-100 transition-colors">
                        <div class="text-3xl font-bold text-red-600 mb-2">S</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Simple</div>
                        <div class="text-sm text-gray-600">Mudah dipahami</div>
                    </div>
                    <div class="bg-orange-50 rounded-xl p-6 text-center hover:bg-orange-100 transition-colors">
                        <div class="text-3xl font-bold text-orange-600 mb-2">M</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Multi-Attribute</div>
                        <div class="text-sm text-gray-600">Banyak kriteria</div>
                    </div>
                    <div class="bg-yellow-50 rounded-xl p-6 text-center hover:bg-yellow-100 transition-colors">
                        <div class="text-3xl font-bold text-yellow-600 mb-2">A</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Rating</div>
                        <div class="text-sm text-gray-600">Sistem penilaian</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-6 text-center hover:bg-green-100 transition-colors">
                        <div class="text-3xl font-bold text-green-600 mb-2">R</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Technique</div>
                        <div class="text-sm text-gray-600">Teknik tervalidasi</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-6 text-center hover:bg-blue-100 transition-colors">
                        <div class="text-3xl font-bold text-blue-600 mb-2">T</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Extended</div>
                        <div class="text-sm text-gray-600">Diperluas dengan ranking</div>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-6 text-center hover:bg-purple-100 transition-colors">
                        <div class="text-3xl font-bold text-purple-600 mb-2">E</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Evaluation</div>
                        <div class="text-sm text-gray-600">Evaluasi berkelanjutan</div>
                    </div>
                    <div class="bg-pink-50 rounded-xl p-6 text-center hover:bg-pink-100 transition-colors">
                        <div class="text-3xl font-bold text-pink-600 mb-2">R</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Review</div>
                        <div class="text-sm text-gray-600">Review sistematis</div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="welcome-card rounded-3xl p-8 lg:p-10 slide-in" style="animation-delay: 0.6s;">
                <h3 class="text-3xl font-bold text-gray-900 text-center mb-8">Keunggulan Metode SMARTER</h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-blue-600 mb-2" id="accuracy">98%</div>
                        <div class="text-gray-700 font-medium">Akurasi Seleksi</div>
                        <div class="text-sm text-gray-500">Extended evaluation</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-green-600 mb-2" id="speed">15x</div>
                        <div class="text-gray-700 font-medium">Lebih Efisien</div>
                        <div class="text-sm text-gray-500">Dari proses manual</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-purple-600 mb-2" id="transparency">100%</div>
                        <div class="text-gray-700 font-medium">Transparansi</div>
                        <div class="text-sm text-gray-500">Audit trail lengkap</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-orange-600 mb-2" id="satisfaction">96%</div>
                        <div class="text-gray-700 font-medium">Kepuasan</div>
                        <div class="text-sm text-gray-500">Berdasarkan survey</div>
                    </div>
                </div>
            </div>

            <!-- Quick Access Buttons -->
            <div class="text-center space-y-4 slide-in" style="animation-delay: 0.8s;">
                <h3 class="text-2xl font-bold text-white mb-6">Akses Cepat</h3>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="loginPage()"
                        class="btn-primary text-white px-8 py-4 rounded-xl font-semibold text-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login Sistem
                    </button>
                    <button onclick="checkResult()"
                        class="btn-secondary text-white px-8 py-4 rounded-xl font-semibold text-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Cek Hasil BPNT
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="about-section py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Tentang Kami</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Komitmen kami dalam memberikan layanan terbaik untuk masyarakat Kabupaten Cirebon
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
                <div class="space-y-6">
                    <h3 class="text-3xl font-bold text-gray-900">Visi & Misi</h3>
                    <div class="space-y-4">
                        <div class="bg-white p-6 rounded-xl shadow-lg">
                            <h4 class="text-xl font-semibold text-blue-600 mb-3 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Visi
                            </h4>
                            <p class="text-gray-700">Mewujudkan distribusi bantuan sosial yang tepat sasaran,
                                transparan, dan akuntabel untuk kesejahteraan masyarakat Kabupaten Cirebon.</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-lg">
                            <h4 class="text-xl font-semibold text-green-600 mb-3 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Misi
                            </h4>
                            <ul class="text-gray-700 space-y-2">
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2">•</span>
                                    Mengimplementasikan sistem seleksi yang objektif dan terukur
                                </li>
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2">•</span>
                                    Memberikan transparansi penuh dalam proses pengambilan keputusan
                                </li>
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2">•</span>
                                    Melakukan evaluasi dan perbaikan berkelanjutan
                                </li>
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2">•</span>
                                    Memastikan bantuan tepat sasaran sesuai kriteria yang ditetapkan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-3xl p-8">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-4">Komitmen Kualitas</h4>
                        <p class="text-gray-700 leading-relaxed">
                            Dengan menggunakan metode SMARTER, kami berkomitmen memberikan hasil seleksi
                            yang akurat, fair, dan dapat dipertanggungjawabkan kepada seluruh masyarakat.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Additional Information Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 mb-2">Akurasi Tinggi</h4>
                    <p class="text-gray-600">Metode SMARTER memberikan akurasi hingga 98% dalam seleksi penerima bantuan
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 mb-2">Transparansi</h4>
                    <p class="text-gray-600">Proses seleksi yang transparan dan dapat dipertanggungjawabkan kepada
                        publik</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 mb-2">Evaluasi Berkelanjutan</h4>
                    <p class="text-gray-600">Sistem review dan evaluasi berkelanjutan untuk perbaikan kualitas layanan
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Contact Info -->
                <div class="space-y-4">
                    <h4 class="text-2xl font-bold mb-6">Kontak Kami</h4>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-yellow-300 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="font-medium">Alamat Kantor</p>
                                <p class="text-blue-100 text-sm">Jl. Sunan Kalijaga No. 7, Sumber, Kabupaten Cirebon,
                                    Jawa Barat 45611</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <div>
                                <p class="font-medium">Telepon</p>
                                <p class="text-blue-100 text-sm">(0231) 321-456</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <div>
                                <p class="font-medium">Email</p>
                                <p class="text-blue-100 text-sm">bpnt@cirebonkab.go.id</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Office Hours -->
                <div class="space-y-4">
                    <h4 class="text-2xl font-bold mb-6">Jam Operasional</h4>
                    <div class="space-y-3">
                        <div>
                            <p class="font-medium">Senin - Kamis</p>
                            <p class="text-blue-100 text-sm">08:00 - 15:30 WIB</p>
                        </div>
                        <div>
                            <p class="font-medium">Jumat</p>
                            <p class="text-blue-100 text-sm">08:00 - 11:30 WIB</p>
                        </div>
                        <div>
                            <p class="font-medium">Sabtu - Minggu</p>
                            <p class="text-blue-100 text-sm">Tutup</p>
                        </div>
                        <div class="mt-4 p-3 bg-yellow-500 bg-opacity-20 rounded-lg">
                            <p class="text-yellow-200 text-xs">
                                <strong>Catatan:</strong> Layanan online tersedia 24/7
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h4 class="text-2xl font-bold mb-6">Tautan Cepat</h4>
                    <div class="space-y-3">
                        <button onclick="loginPage()"
                            class="block text-blue-100 hover:text-yellow-300 transition-colors text-left">Login
                            Sistem</button>
                        <button onclick="checkResult()"
                            class="block text-blue-100 hover:text-yellow-300 transition-colors text-left">Cek Status
                            BPNT</button>
                        <a href="#" class="block text-blue-100 hover:text-yellow-300 transition-colors">Panduan
                            Penggunaan</a>
                        <a href="#" class="block text-blue-100 hover:text-yellow-300 transition-colors">FAQ</a>
                        <a href="#" class="block text-blue-100 hover:text-yellow-300 transition-colors">Bantuan
                            Teknis</a>
                        <a href="https://cirebonkab.go.id"
                            class="block text-blue-100 hover:text-yellow-300 transition-colors">Website Resmi Pemkab</a>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="space-y-4">
                    <h4 class="text-2xl font-bold mb-6">Kontak Darurat</h4>
                    <div class="space-y-3">
                        <div>
                            <p class="font-medium text-yellow-300">Hotline BPNT</p>
                            <p class="text-blue-100 text-sm">0800-1-BPNT (2768)</p>
                        </div>
                        <div>
                            <p class="font-medium text-yellow-300">WhatsApp Center</p>
                            <p class="text-blue-100 text-sm">+62 812-3456-7890</p>
                        </div>
                        <div>
                            <p class="font-medium text-yellow-300">Email Pengaduan</p>
                            <p class="text-blue-100 text-sm">pengaduan@bpnt-cirebon.go.id</p>
                        </div>
                        <div>
                            <p class="font-medium text-yellow-300">SMS Gateway</p>
                            <p class="text-blue-100 text-sm">0811-2233-4455</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Office Locations Section -->
            <div class="border-t border-blue-400 border-opacity-30 mt-12 pt-8">
                <h4 class="text-2xl font-bold mb-6 text-center">Lokasi Pelayanan BPNT</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white bg-opacity-10 p-6 rounded-xl">
                        <h5 class="font-bold text-yellow-300 mb-2">Kantor Pusat</h5>
                        <p class="text-blue-100 text-sm">Dinas Sosial Kabupaten Cirebon</p>
                        <p class="text-blue-100 text-sm">Jl. Sunan Kalijaga No. 7, Sumber</p>
                        <p class="text-blue-100 text-sm">Kode Pos: 45611</p>
                    </div>
                    <div class="bg-white bg-opacity-10 p-6 rounded-xl">
                        <h5 class="font-bold text-yellow-300 mb-2">Kantor Cabang Utara</h5>
                        <p class="text-blue-100 text-sm">Jl. Raya Pantura Km. 25</p>
                        <p class="text-blue-100 text-sm">Kecamatan Losari</p>
                        <p class="text-blue-100 text-sm">Telp: (0231) 654-321</p>
                    </div>
                    <div class="bg-white bg-opacity-10 p-6 rounded-xl">
                        <h5 class="font-bold text-yellow-300 mb-2">Kantor Cabang Selatan</h5>
                        <p class="text-blue-100 text-sm">Jl. Raya Cirebon-Kuningan</p>
                        <p class="text-blue-100 text-sm">Kecamatan Dukupuntang</p>
                        <p class="text-blue-100 text-sm">Telp: (0231) 987-654</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-blue-400 border-opacity-30 mt-8 pt-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-xl">SPK BPNT Kabupaten Cirebon</div>
                                <div class="text-sm text-blue-100">Metode SMARTER - Keputusan yang Lebih Baik</div>
                            </div>
                        </div>
                        <div class="space-y-1 text-blue-100 text-sm">
                            <p><strong>NPWP:</strong> 00.123.456.7-321.000</p>
                            <p><strong>Fax:</strong> (0231) 321-457</p>
                            <p><strong>Website:</strong> sosial.cirebonkab.go.id</p>
                            <div class="mt-2 inline-block px-3 py-1 bg-green-500 bg-opacity-20 rounded-full">
                                <span class="text-green-200 text-xs font-medium">ISO 9001:2015 Certified</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center lg:text-right">
                        <div class="space-y-2">
                            <p class="text-white text-sm">
                                &copy; 2025 Dinas Sosial Kabupaten Cirebon
                            </p>
                            <p class="text-blue-100 text-xs">
                                Dikembangkan dengan metode SMARTER untuk pelayanan yang optimal
                            </p>
                            <div class="flex justify-center lg:justify-end space-x-4 mt-4">
                                <a href="#" class="text-blue-100 hover:text-yellow-300 transition-colors"
                                    title="Twitter">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-blue-100 hover:text-yellow-300 transition-colors"
                                    title="Facebook">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-blue-100 hover:text-yellow-300 transition-colors"
                                    title="Instagram">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.64.4 3.18 1.15 4.54-.6 2.25-1.57 4.28-1.57 4.28s2.54-.85 5.23-1.69c1.32.77 2.85 1.23 4.5 1.23 5.46 0 9.91-4.45 9.91-9.91C21.35 6.45 16.9 2 12.04 2zm0 14.82c-1.05 0-2.07-.26-2.96-.74l-2.13.71.71-2.13c-.48-.89-.74-1.91-.74-2.96 0-3.39 2.76-6.15 6.15-6.15s6.15 2.76 6.15 6.15-2.76 6.12-6.18 6.12z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-blue-100 hover:text-yellow-300 transition-colors"
                                    title="YouTube">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('active');
        }

        function loginPage() {
            const button = event.target;
            const loading = button.querySelector('.loading');

            // Show loading animation
            if (loading) {
                loading.classList.add('active');
            }
            button.style.pointerEvents = 'none';

            // Simulate navigation to login page
            setTimeout(() => {
                alert('Mengarahkan ke halaman login...\n\n✅ SPK BPNT - Metode SMARTER\n✅ Login dengan kredensial yang valid\n✅ Akses dashboard admin\n✅ Kelola data penerima BPNT\n\n📋 Fitur Login:\n• Validasi pengguna\n• Session management\n• Role-based access\n• Security measures');

                // Reset button state
                if (loading) {
                    loading.classList.remove('active');
                }
                button.style.pointerEvents = 'auto';
            }, 2000);
        }

        function checkResult() {
            alert('🔍 Fitur Cek Hasil BPNT:\n\n• Cek status penerimaan bantuan\n• Lihat riwayat distribusi bantuan\n• Download surat keterangan penerima\n• Informasi jadwal pengambilan\n• Status verifikasi dokumen\n\n💡 Tip: Gunakan kolom pencarian NIK di halaman utama untuk akses cepat!');
        }

        function searchNIK() {
            const nikInput = document.getElementById('nikInput');
            const nik = nikInput.value.trim();
            const resultDiv = document.getElementById('searchResult');
            const resultContent = document.getElementById('resultContent');

            if (nik.length !== 16) {
                alert('⚠️ NIK harus terdiri dari 16 digit angka');
                nikInput.focus();
                return;
            }

            if (!/^\d{16}$/.test(nik)) {
                alert('⚠️ NIK hanya boleh berisi angka');
                nikInput.focus();
                return;
            }

            // Show loading state
            resultDiv.innerHTML = '<div class="text-center py-8"><div class="animate-spin inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full"></div><p class="text-gray-600 mt-4">Mencari data NIK...</p></div>';
            resultDiv.classList.remove('hidden');

            // Simulate search with delay
            setTimeout(() => {
                const isReceived = Math.random() > 0.3; // 70% chance of being a recipient
                const smarterScore = isReceived ? (75 + Math.random() * 25).toFixed(1) : (30 + Math.random() * 45).toFixed(1);
                const ranking = isReceived ? Math.floor(100 + Math.random() * 500) : Math.floor(600 + Math.random() * 650);

                if (isReceived) {
                    resultDiv.innerHTML = `
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Status Penerima BPNT</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                                    <div>
                                        <p><strong>NIK:</strong> ${nik}</p>
                                        <p><strong>Status:</strong> <span class="text-green-600 font-semibold">✅ DITERIMA</span></p>
                                        <p><strong>Periode:</strong> Januari - Desember 2025</p>
                                    </div>
                                    <div>
                                        <p><strong>Skor SMARTER:</strong> ${smarterScore} / 100</p>
                                        <p><strong>Ranking:</strong> ${ranking} dari 1,250 pendaftar</p>
                                        <p><strong>Tanggal Penetapan:</strong> 15 Januari 2025</p>
                                    </div>
                                </div>
                                <div class="mt-4 p-3 bg-green-50 rounded-lg border border-green-200">
                                    <p class="text-green-700 text-sm">
                                        <strong>📋 Informasi:</strong> Bantuan dapat diambil setiap tanggal 1-10 di agen/e-warong terdekat dengan membawa KTP asli.
                                        <br><strong>💳 Saldo:</strong> Rp 200.000/bulan | <strong>📅 Pengambilan terakhir:</strong> 5 Februari 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                    resultDiv.className = 'search-result rounded-xl p-6 mt-6 border-green-200';
                } else {
                    resultDiv.innerHTML = `
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Status Penerima BPNT</h4>
                                <div class="space-y-2 text-gray-700">
                                    <p><strong>NIK:</strong> ${nik}</p>
                                    <p><strong>Status:</strong> <span class="text-red-600 font-semibold">❌ TIDAK DITERIMA</span></p>
                                    <p><strong>Skor SMARTER:</strong> ${smarterScore} / 100</p>
                                    <p><strong>Ranking:</strong> ${ranking} dari 1,250 pendaftar</p>
                                    <p><strong>Batas Minimum:</strong> 75.0 / 100</p>
                                </div>
                                <div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-200">
                                    <p class="text-red-700 text-sm">
                                        <strong>📋 Informasi:</strong> Skor belum memenuhi batas minimum untuk periode ini. 
                                        <br><strong>📅 Periode Selanjutnya:</strong> Juli 2025 | <strong>💡 Saran:</strong> Lengkapi persyaratan dan dokumen pendukung.
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                    resultDiv.className = 'search-result rounded-xl p-6 mt-6 border-red-200';
                }

                // Scroll to result
                resultDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 1500);
        }

        function handleEnterSearch(event) {
            if (event.key === 'Enter') {
                searchNIK();
            }
        }

        // Counter animation
        function animateCounters() {
            const counters = [
                { id: 'accuracy', target: 98, suffix: '%' },
                { id: 'speed', target: 15, suffix: 'x' },
                { id: 'transparency', target: 100, suffix: '%' },
                { id: 'satisfaction', target: 96, suffix: '%' }
            ];

            counters.forEach(counter => {
                const element = document.getElementById(counter.id);
                let current = 0;
                const increment = counter.target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= counter.target) {
                        element.textContent = counter.target + counter.suffix;
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current) + counter.suffix;
                    }
                }, 20);
            });
        }

        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Intersection Observer for animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';

                    // Trigger counter animation when statistics section is visible
                    if (entry.target.querySelector('#accuracy')) {
                        setTimeout(animateCounters, 500);
                        observer.unobserve(entry.target);
                    }
                }
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobileMenu');
                    mobileMenu.classList.remove('active');

                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize animations
            const slideElements = document.querySelectorAll('.slide-in');
            slideElements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                observer.observe(el);
            });

            // Add parallax effect to floating elements
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallax = document.querySelectorAll('.icon-float');
                const speed = 0.5;

                parallax.forEach(element => {
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                });
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function (event) {
                const mobileMenu = document.getElementById('mobileMenu');
                const menuButton = event.target.closest('button');

                if (!mobileMenu.contains(event.target) && !menuButton) {
                    mobileMenu.classList.remove('active');
                }
            });

            // Auto-focus NIK input when page loads
            const nikInput = document.getElementById('nikInput');
            if (nikInput) {
                setTimeout(() => {
                    nikInput.focus();
                }, 1000);
            }
        });

        // Format NIK input (add spaces for better readability)
        document.getElementById('nikInput').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\s/g, '').replace(/\D/g, '');
            if (value.length > 16) {
                value = value.slice(0, 16);
            }
            e.target.value = value;
        });

        // Add enter key support for mobile menu links
        document.querySelectorAll('#mobileMenu a, #mobileMenu button').forEach(link => {
            link.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    this.click();
                }
            });
        });
    </script>

</body>

</html>