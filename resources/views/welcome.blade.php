<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Penerimaan BPNT - Metode SMART</title>
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

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="hero-bg relative">
        <div class="relative z-10">
            <!-- Navigation -->
            <nav class="flex items-center justify-between p-6 max-w-7xl mx-auto">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <div class="text-white">
                        <div class="font-bold text-lg">SPK BPNT</div>
                        <div class="text-xs text-blue-100">Sistem Pendukung Keputusan</div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="btn-primary text-white px-6 py-2 rounded-full font-semibold">
                        Login
                    </a>
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="relative z-10 max-w-7xl mx-auto px-6 py-16">
                <div class="text-center text-white mb-8">
                    <p class="text-blue-100 mb-4">SELAMAT DATANG</p>
                    <h1 class="text-5xl font-bold mb-4">
                        PENERIMAAN BANTUAN PANGAN NON TUNAI
                    </h1>
                    <h2 class="text-3xl font-semibold text-yellow-300 mb-6">
                        Kabupaten Cirebon
                    </h2>
                    <p class="text-lg text-blue-100 max-w-4xl mx-auto leading-relaxed">
                        Situs ini dioperasikan sebagai pusat informasi dan pengolahan seleksi data masyarakat penerima
                        BPNT
                        Kabupaten Cirebon Tahun Anggaran 2024/2025 secara <span
                            class="font-semibold text-yellow-300">online</span> dan <span
                            class="font-semibold text-yellow-300">real time</span>
                    </p>
                </div>

                <!-- Search Box -->
                <div class="max-w-2xl mx-auto mb-12">
                    <div class="bg-white rounded-full p-2 shadow-lg flex">
                        <input type="text" placeholder="Masukkan NIK Anda Untuk Melihat Hasil"
                            class="flex-1 px-6 py-3 rounded-full border-0 outline-none text-gray-700">
                        <button class="btn-primary px-8 py-3 rounded-full text-white font-semibold">
                            Cari 🔍
                        </button>
                    </div>
                </div>

                <!-- Character Illustrations -->
                <div class="flex justify-center items-end space-x-8">
                    <div class="icon-float">
                        <div
                            class="w-24 h-32 bg-gradient-to-b from-purple-400 to-purple-600 rounded-t-full rounded-b-lg relative">
                            <div
                                class="absolute top-4 left-1/2 transform -translate-x-1/2 w-6 h-6 bg-yellow-200 rounded-full">
                            </div>
                            <div
                                class="absolute bottom-8 left-1/2 transform -translate-x-1/2 w-16 h-16 bg-white rounded-lg">
                            </div>
                        </div>
                    </div>
                    <div class="icon-float" style="animation-delay: 0.5s;">
                        <div
                            class="w-24 h-32 bg-gradient-to-b from-red-400 to-red-600 rounded-t-full rounded-b-lg relative">
                            <div
                                class="absolute top-4 left-1/2 transform -translate-x-1/2 w-6 h-6 bg-yellow-200 rounded-full">
                            </div>
                            <div
                                class="absolute bottom-8 left-1/2 transform -translate-x-1/2 w-16 h-16 bg-white rounded-lg">
                            </div>
                        </div>
                    </div>
                    <div class="icon-float" style="animation-delay: 1s;">
                        <div
                            class="w-24 h-32 bg-gradient-to-b from-blue-400 to-blue-600 rounded-t-full rounded-b-lg relative">
                            <div
                                class="absolute top-4 left-1/2 transform -translate-x-1/2 w-6 h-6 bg-yellow-200 rounded-full">
                            </div>
                            <div
                                class="absolute bottom-8 left-1/2 transform -translate-x-1/2 w-16 h-16 bg-white rounded-lg">
                            </div>
                        </div>
                    </div>
                    <div class="icon-float" style="animation-delay: 1.5s;">
                        <div
                            class="w-24 h-32 bg-gradient-to-b from-orange-400 to-orange-600 rounded-t-full rounded-b-lg relative">
                            <div
                                class="absolute top-4 left-1/2 transform -translate-x-1/2 w-6 h-6 bg-yellow-200 rounded-full">
                            </div>
                            <div
                                class="absolute bottom-8 left-1/2 transform -translate-x-1/2 w-16 h-16 bg-white rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Zonasi -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-lg">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Analisis Kriteria</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Diperuntukkan bagi keluarga dengan kriteria ekonomi terdekat
                    </p>
                </div>

                <!-- Afirmasi -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-lg">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Penilaian SMART</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Diperuntukkan bagi keluarga yang kurang mampu secara ekonomi
                    </p>
                </div>

                <!-- Prestasi -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-lg">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Ranking Otomatis</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Diperuntukkan bagi keluarga yang memiliki prestasi khusus
                    </p>
                </div>

                <!-- Mutasi -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-lg">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Verifikasi Data</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Diperuntukkan bagi keluarga yang berdomisili luar kota
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About SMART Method Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Tentang Metode SMART</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Simple Multi-Attribute Rating Technique (SMART) adalah metode pengambilan keputusan
                    yang membantu menentukan penerima BPNT berdasarkan kriteria yang telah ditetapkan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 font-bold">1</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Penentuan Kriteria</h3>
                            <p class="text-gray-600">Mengidentifikasi kriteria penting seperti pendapatan, jumlah
                                tanggungan, kepemilikan aset, dan kondisi rumah.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 font-bold">2</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Pemberian Bobot</h3>
                            <p class="text-gray-600">Setiap kriteria diberi bobot sesuai tingkat kepentingannya dalam
                                penentuan penerima BPNT.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 font-bold">3</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Penilaian & Ranking</h3>
                            <p class="text-gray-600">Sistem menghitung skor total dan membuat ranking untuk menentukan
                                prioritas penerima bantuan.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Keunggulan Sistem</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-gray-700">Objektif dan transparan</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-gray-700">Proses cepat dan akurat</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-gray-700">Mudah dipahami dan digunakan</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-gray-700">Hasil dapat dipertanggungjawabkan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 hero-bg relative">
        <div class="relative z-10 max-w-4xl mx-auto text-center px-6">
            <h2 class="text-4xl font-bold text-white mb-6">Siap Menggunakan Sistem SPK BPNT?</h2>
            <p class="text-xl text-blue-100 mb-8">
                Mulai proses pendaftaran dan verifikasi data calon penerima BPNT dengan sistem yang mudah dan
                terpercaya.
            </p>
            <div class="space-x-4">

                <button
                    class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-colors">
                    Pelajari Lebih Lanjut
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-white">SPK BPNT</div>
                            <div class="text-xs">Kabupaten Cirebon</div>
                        </div>
                    </div>
                    <p class="text-sm">
                        Sistem Pendukung Keputusan untuk penerimaan Bantuan Pangan Non Tunai
                        menggunakan metode SMART (Simple Multi-Attribute Rating Technique).
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-4">Kontak</h3>
                    <div class="space-y-2 text-sm">
                        <p>📧 bpnt@cirebonkab.go.id</p>
                        <p>📞 (0231) 123-4567</p>
                        <p>📍 Jl. Siliwangi No. 1, Cirebon</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
                <p>&copy; 2025 SPK BPNT Kabupaten Cirebon. Menggunakan metode SMART untuk transparansi dan akurasi.</p>
            </div>
        </div>
    </footer>

</body>

</html>