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
            animation: letterPulse 3s ease-in-out infinite;
            margin: 0 0.1em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            transform-origin: center bottom;
        }

        .smarter-letter:nth-child(1) {
            color: #ffffff;
            text-shadow: 0 0 20px #ff0080, 0 0 40px #ff0080, 0 0 60px #ff0080;
            animation-delay: 0s;
        }

        .smarter-letter:nth-child(2) {
            color: #ffffff;
            text-shadow: 0 0 20px #ff8000, 0 0 40px #ff8000, 0 0 60px #ff8000;
            animation-delay: 0.2s;
        }

        .smarter-letter:nth-child(3) {
            color: #ffffff;
            text-shadow: 0 0 20px #ffff00, 0 0 40px #ffff00, 0 0 60px #ffff00;
            animation-delay: 0.4s;
        }

        .smarter-letter:nth-child(4) {
            color: #ffffff;
            text-shadow: 0 0 20px #00ff00, 0 0 40px #00ff00, 0 0 60px #00ff00;
            animation-delay: 0.6s;
        }

        .smarter-letter:nth-child(5) {
            color: #ffffff;
            text-shadow: 0 0 20px #0080ff, 0 0 40px #0080ff, 0 0 60px #0080ff;
            animation-delay: 0.8s;
        }

        .smarter-letter:nth-child(6) {
            color: #ffffff;
            text-shadow: 0 0 20px #8000ff, 0 0 40px #8000ff, 0 0 60px #8000ff;
            animation-delay: 1.0s;
        }

        .smarter-letter:nth-child(7) {
            color: #ffffff;
            text-shadow: 0 0 20px #ff0040, 0 0 40px #ff0040, 0 0 60px #ff0040;
            animation-delay: 1.2s;
        }

        @keyframes letterPulse {

            0%,
            70%,
            100% {
                transform: translateY(0) scale(1) rotateZ(0deg);
                filter: brightness(1);
            }

            15% {
                transform: translateY(-40px) scale(1.3) rotateZ(-8deg);
                filter: brightness(1.5);
            }

            35% {
                transform: translateY(-20px) scale(1.15) rotateZ(5deg);
                filter: brightness(1.2);
            }

            50% {
                transform: translateY(-10px) scale(1.05) rotateZ(-2deg);
                filter: brightness(1.1);
            }
        }

        .smarter-glow {
            animation: continuousGlow 3s ease-in-out infinite alternate, letterFloat 4s ease-in-out infinite;
        }

        @keyframes continuousGlow {
            0% {
                filter: brightness(1) saturate(1);
            }

            50% {
                filter: brightness(1.3) saturate(1.2);
            }

            100% {
                filter: brightness(1.6) saturate(1.5);
            }
        }

        @keyframes letterFloat {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            25% {
                transform: translateY(-8px) rotate(1deg);
            }

            50% {
                transform: translateY(-15px) rotate(0deg);
            }

            75% {
                transform: translateY(-8px) rotate(-1deg);
            }
        }

        .mobile-menu {
            display: none;
        }

        .mobile-menu.active {
            display: block;
        }

        footer {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        .about-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            padding: 100px 0;
        }

        section {
            scroll-margin-top: 80px;
        }

        /* About section improvements */
        .about-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .about-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 4rem;
            height: 4rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
        }

        @media(max-width: 768px) {
            .smarter-text {
                font-size: 3rem;
            }
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
            <div class="hidden md:flex items-center space-x-4">
                <a href="#beranda"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-blue-50">Beranda</a>
                <a href="#tentang"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-blue-50">Tentang
                    Kami</a>
                <a href="#kontak"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-blue-50">Kontak</a>
                <a href="/login"
                    class="bg-blue-600 text-white hover:bg-blue-700 font-medium transition-colors px-4 py-2 rounded-lg">Login</a>
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
        <div id="mobileMenu" class="mobile-menu md:hidden mt-4 px-6 py-4 bg-white rounded-lg mx-6 shadow-lg">
            <div class="space-y-3">
                <a href="#beranda"
                    class="block text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition-colors">Beranda</a>
                <a href="#tentang"
                    class="block text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition-colors">Tentang
                    Kami</a>
                <a href="#kontak"
                    class="block text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition-colors">Kontak</a>
                <a href="/login"
                    class="block bg-blue-600 text-white hover:bg-blue-700 font-medium py-2 px-3 rounded-lg transition-colors text-center">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
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
                <h2 class="text-4xl font-semibold text-yellow-300 mb-6">SPK Metode</h2>

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

                <!-- Action Button (hanya tombol orange) -->
                <div class="flex justify-center mt-8">
                    <a href="/hasil-akhir"
                        class="btn-primary text-white px-8 py-4 rounded-xl font-semibold text-lg inline-flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        Lihat Hasil Akhir
                    </a>
                </div>
            </div>

            <!-- SMARTER Method Info -->
            <div class="welcome-card rounded-3xl p-8 lg:p-10 mb-8 slide-in" style="animation-delay: 0.2s;">
                <div class="text-center mb-8">
                    <h3 class="text-4xl font-bold text-gray-900 mb-4">Metode SMARTER</h3>
                    <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                        Simple Multi-Attribute Rating Technique Exploiting Ranks
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
                        <div class="font-semibold text-lg mb-1 text-gray-900">Multi</div>
                        <div class="text-sm text-gray-600">Banyak kriteria</div>
                    </div>
                    <div class="bg-yellow-50 rounded-xl p-6 text-center hover:bg-yellow-100 transition-colors">
                        <div class="text-3xl font-bold text-yellow-600 mb-2">A</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Attribute</div>
                        <div class="text-sm text-gray-600">Banyak atribut</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-6 text-center hover:bg-green-100 transition-colors">
                        <div class="text-3xl font-bold text-green-600 mb-2">R</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Rating</div>
                        <div class="text-sm text-gray-600">Sistem penilaian</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-6 text-center hover:bg-blue-100 transition-colors">
                        <div class="text-3xl font-bold text-blue-600 mb-2">T</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Technique</div>
                        <div class="text-sm text-gray-600">Teknik tervalidasi</div>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-6 text-center hover:bg-purple-100 transition-colors">
                        <div class="text-3xl font-bold text-purple-600 mb-2">E</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Exploiting</div>
                        <div class="text-sm text-gray-600">Memanfaatkan</div>
                    </div>
                    <div class="bg-pink-50 rounded-xl p-6 text-center hover:bg-pink-100 transition-colors">
                        <div class="text-3xl font-bold text-pink-600 mb-2">R</div>
                        <div class="font-semibold text-lg mb-1 text-gray-900">Ranks</div>
                        <div class="text-sm text-gray-600">Peringkat preferensi</div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="welcome-card rounded-3xl p-8 lg:p-10 mb-8 slide-in" style="animation-delay: 0.4s;">
                <h3 class="text-3xl font-bold text-gray-900 text-center mb-8">Keunggulan Metode SMARTER</h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-blue-600 mb-2" id="accuracy">98%</div>
                        <div class="text-gray-700 font-medium">Akurasi Seleksi</div>
                        <div class="text-sm text-gray-500">Exploiting ranks</div>
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
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="about-section">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-gray-900 mb-6">Tentang Kami</h2>
                <p class="text-2xl text-gray-600 max-w-4xl mx-auto">
                    Komitmen kami dalam memberikan layanan terbaik untuk masyarakat Kabupaten Cirebon
                </p>
            </div>

            <!-- Visi & Misi Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                <!-- Visi -->
                <div class="about-card">
                    <div class="feature-icon bg-blue-100">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-blue-600 mb-6 text-center">Visi</h3>
                    <p class="text-gray-700 text-lg leading-relaxed text-center">
                        Mewujudkan distribusi bantuan sosial yang tepat sasaran, transparan, dan akuntabel
                        untuk kesejahteraan masyarakat Kabupaten Cirebon melalui implementasi teknologi
                        sistem pendukung keputusan yang modern dan reliable.
                    </p>
                </div>

                <!-- Misi -->
                <div class="about-card">
                    <div class="feature-icon bg-green-100">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-green-600 mb-6 text-center">Misi</h3>
                    <ul class="text-gray-700 text-lg space-y-4">
                        <li class="flex items-start">
                            <span class="text-green-500 text-2xl mr-3 mt-1">•</span>
                            <span>Mengimplementasikan sistem seleksi yang objektif dan terukur menggunakan metode
                                SMARTER</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 text-2xl mr-3 mt-1">•</span>
                            <span>Memberikan transparansi penuh dalam proses pengambilan keputusan penerima
                                bantuan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 text-2xl mr-3 mt-1">•</span>
                            <span>Melakukan evaluasi dan perbaikan berkelanjutan untuk meningkatkan kualitas
                                layanan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 text-2xl mr-3 mt-1">•</span>
                            <span>Memastikan bantuan tepat sasaran sesuai kriteria yang telah ditetapkan</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="about-card text-center">
                    <div class="feature-icon bg-green-100">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-gray-900 mb-4">Transparansi</h4>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Proses seleksi yang transparan dan dapat dipertanggungjawabkan kepada publik
                        dengan dokumentasi lengkap setiap tahapan evaluasi.
                    </p>
                </div>

                <div class="about-card text-center">
                    <div class="feature-icon bg-blue-100">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-gray-900 mb-4">Akurasi Tinggi</h4>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Metode SMARTER memberikan akurasi hingga 98% dalam seleksi penerima bantuan
                        dengan multi-kriteria yang objektif dan terukur.
                    </p>
                </div>

                <div class="about-card text-center">
                    <div class="feature-icon bg-purple-100">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold text-gray-900 mb-4">Evaluasi Berkelanjutan</h4>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Sistem review dan evaluasi berkelanjutan untuk perbaikan kualitas layanan
                        dan peningkatan efektivitas program bantuan sosial.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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

            <!-- Bottom Footer -->
            <div class="border-t border-blue-400 border-opacity-30 mt-12 pt-8">
                <div class="text-center">
                    <div class="flex items-center justify-center space-x-3 mb-4">
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
                    <p class="text-white text-sm">&copy; 2025 Dinas Sosial Kabupaten Cirebon</p>
                    <p class="text-blue-100 text-xs">Dikembangkan dengan metode SMARTER untuk pelayanan yang optimal</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu) {
                mobileMenu.classList.toggle('active');
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

                // Close mobile menu
                if (!mobileMenu.contains(event.target) && !menuButton?.onclick?.toString().includes('toggleMobileMenu')) {
                    mobileMenu.classList.remove('active');
                }
            });
        });
    </script>

</body>

</html>