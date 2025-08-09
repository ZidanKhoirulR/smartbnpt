<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - SPK BPNT Kabupaten Cirebon</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

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
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }

        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="navbar fixed w-full z-50 px-6 py-4">
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
                    <div class="text-sm text-gray-600">Hasil Akhir</div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="hero-bg pt-24 pb-12">
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-8">
            <!-- Background Pattern -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="icon-float absolute top-32 left-10">
                    <div class="w-16 h-16 bg-white bg-opacity-10 rounded-full"></div>
                </div>
                <div class="icon-float absolute top-52 right-20" style="animation-delay: 1s;">
                    <div class="w-12 h-12 bg-white bg-opacity-10 rounded-full"></div>
                </div>
            </div>

            <div class="text-center text-white relative z-10">
                <h1 class="text-5xl font-bold mb-4">{{ $title }}</h1>
                <p class="text-xl text-blue-100 leading-relaxed max-w-3xl mx-auto">
                    Sistem Pendukung Keputusan Penerimaan BPNT dengan metode SMARTER-ROC
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Error Card -->
            <div class="content-card rounded-3xl p-8 shadow-xl text-center">
                <!-- Error Icon -->
                <div class="mx-auto w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <i class="ri-information-line text-4xl text-red-600"></i>
                </div>

                <!-- Error Message -->
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Hasil Belum Tersedia</h2>
                <p class="text-xl text-gray-600 mb-6">{{ $error }}</p>

                <!-- Details -->
                @if(isset($details) && !empty($details))
                    <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
                        <h3 class="font-semibold text-lg text-gray-900 mb-4 flex items-center gap-2">
                            <i class="ri-error-warning-line text-red-500"></i>
                            Detail Masalah:
                        </h3>
                        <ul class="space-y-2 text-gray-700">
                            @foreach($details as $detail)
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 mt-1">•</span>
                                    <span>{{ $detail }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Information Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="p-6 rounded-xl text-white"
                        style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="ri-admin-line text-2xl"></i>
                            <span class="font-bold">Untuk Admin</span>
                        </div>
                        <p class="text-purple-100 text-sm">
                            Silakan login ke dashboard admin untuk melakukan pengaturan data dan perhitungan
                            SMARTER-ROC.
                        </p>
                    </div>

                    <div class="p-6 rounded-xl text-white"
                        style="background: linear-gradient(135deg, #06b6d4, #0891b2); box-shadow: 0 8px 25px rgba(6, 182, 212, 0.3);">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="ri-time-line text-2xl"></i>
                            <span class="font-bold">Dalam Proses</span>
                        </div>
                        <p class="text-cyan-100 text-sm">
                            Hasil perhitungan akan ditampilkan setelah admin menyelesaikan proses perhitungan SMARTER.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('welcome') }}"
                        class="btn-secondary text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 inline-flex items-center justify-center gap-2">
                        <i class="ri-arrow-left-line"></i>
                        Kembali ke Beranda
                    </a>
                </div>

                <!-- Contact Info -->
                <div class="mt-12 p-6 bg-gray-50 rounded-xl">
                    <h3 class="font-bold text-lg text-gray-900 mb-4 flex items-center justify-center gap-2">
                        <i class="ri-customer-service-2-line text-blue-600"></i>
                        Butuh Bantuan?
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="text-center">
                            <i class="ri-phone-line text-blue-600 text-xl mb-2 block"></i>
                            <span class="font-medium text-gray-900">Telepon</span>
                            <p class="text-gray-600">(0231) 321-456</p>
                        </div>
                        <div class="text-center">
                            <i class="ri-mail-line text-blue-600 text-xl mb-2 block"></i>
                            <span class="font-medium text-gray-900">Email</span>
                            <p class="text-gray-600">bpnt@cirebonkab.go.id</p>
                        </div>
                        <div class="text-center">
                            <i class="ri-whatsapp-line text-blue-600 text-xl mb-2 block"></i>
                            <span class="font-medium text-gray-900">WhatsApp</span>
                            <p class="text-gray-600">+62 812-3456-7890</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-xl">SPK BPNT Kabupaten Cirebon</div>
                        <div class="text-sm text-gray-300">Metode SMARTER - Keputusan yang Lebih Baik</div>
                    </div>
                </div>
                <p class="text-gray-300 text-sm">&copy; 2025 Dinas Sosial Kabupaten Cirebon</p>
                <p class="text-gray-400 text-xs">Dikembangkan dengan metode SMARTER untuk pelayanan yang optimal</p>
            </div>
        </div>
    </footer>

</body>

</html>