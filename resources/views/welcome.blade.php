<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Urbanist', sans-serif;
            background: linear-gradient(-45deg, #7b2ff7, #f107a3, #00ffe7);
            background-size: 400% 400%;
            animation: gradientShift 12s ease infinite;
            position: relative;
            overflow-x: hidden;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .bubble {
            position: absolute;
            z-index: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            animation: bubbleMove 30s ease-in-out infinite;
        }

        @keyframes bubbleMove {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0.3;
            }

            50% {
                transform: translateY(-200px) translateX(160px);
                opacity: 0.6;
            }

            100% {
                transform: translateY(0) translateX(0);
                opacity: 0.3;
            }
        }

        .icon-zoom {
            transition: transform 1.5s ease-in-out;
            animation: iconPulse 4s ease-in-out infinite;
        }

        @keyframes iconPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.12);
            }
        }

        .btn-transition {
            transition: all 0.3s ease-in-out;
        }

        .btn-transition:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
        }

        .feature-box {
            background: #ffffffcc;
            border-radius: 1rem;
            padding: 2rem;
            transition: transform 0.4s ease, box-shadow 0.4s ease, opacity 0.4s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            opacity: 0;
            transform: translateY(20px);
            z-index: 10;
        }

        .feature-box.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col text-white">
    <!-- Bubbles -->
    <div class="bubble" style="width: 60px; height: 60px; top: 15%; left: 10%;"></div>
    <div class="bubble" style="width: 90px; height: 90px; top: 25%; left: 25%;"></div>
    <div class="bubble" style="width: 70px; height: 70px; top: 40%; left: 60%;"></div>
    <div class="bubble" style="width: 100px; height: 100px; top: 55%; left: 75%;"></div>
    <div class="bubble" style="width: 80px; height: 80px; top: 70%; left: 40%;"></div>
    <div class="bubble" style="width: 50px; height: 50px; top: 80%; left: 15%;"></div>
    <div class="bubble" style="width: 120px; height: 120px; top: 20%; left: 80%;"></div>
    <div class="bubble" style="width: 60px; height: 60px; top: 35%; left: 90%;"></div>

    <!-- Header -->
    <header class="px-10 py-6 bg-pink-700 bg-opacity-90 flex items-center justify-between border-b border-white/10">
        <div class="text-4xl font-extrabold">
            @php
                date_default_timezone_set('Asia/Jakarta');
                $hour = (int) date('H');
                $greeting = match (true) {
                    $hour >= 5 && $hour < 12 => 'Selamat Pagi',
                    $hour >= 12 && $hour < 15 => 'Selamat Siang',
                    $hour >= 15 && $hour < 18 => 'Selamat Sore',
                    default => 'Selamat Malam',
                };
            @endphp
            {{ $greeting }} 👋
        </div>
        <div class="space-x-4">
            <a href="{{ route('login') }}"
                class="bg-yellow-400 text-black px-4 py-2 rounded-full font-semibold hover:bg-yellow-300 transition-all btn-transition">Login</a>
            <a href="#"
                class="bg-white text-gray-800 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-all btn-transition">Tentang
                Kami</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="min-h-screen flex flex-col md:flex-row items-center justify-between px-10 py-20">
        <div class="max-w-xl space-y-6">
            <h1 class="text-5xl font-extrabold leading-tight">Selamat Datang di Sistem Pendukung Keputusan</h1>
            <p class="text-lg">SMART (Simple Multi-Attribute Rating Technique) adalah metode efektif untuk menentukan
                alternatif terbaik secara cepat, akurat, dan transparan.</p>
            <a href="{{ route('login') }}"
                class="inline-block bg-yellow-400 text-black px-6 py-3 rounded-full font-semibold shadow-md hover:bg-yellow-300 transition-all btn-transition">Cek
                Data Disini Yuk</a>
        </div>
        <div class="mt-12 md:mt-0">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/teamwork-support-6558972-5393435.png"
                alt="Gotong Royong" class="w-full max-w-md">
        </div>
    </section>

    <!-- Features Section -->
    <section class="relative z-10 min-h-screen px-10 py-20 bg-gray-50 text-gray-800">
        <h2 class="text-center text-3xl font-bold mb-12">Keunggulan SMART</h2>
        <div id="featureGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <div class="feature-box text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/4472/4472583.png" alt="Cepat"
                    class="mx-auto w-16 h-16 icon-zoom mb-4">
                <h3 class="text-xl font-bold mb-2">Cepat</h3>
                <p>Proses pengambilan keputusan yang cepat dan efisien tanpa mengorbankan akurasi.</p>
            </div>
            <div class="feature-box text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/2989/2989988.png" alt="Akurat"
                    class="mx-auto w-16 h-16 icon-zoom mb-4">
                <h3 class="text-xl font-bold mb-2">Akurat</h3>
                <p>Menghasilkan keputusan yang didukung oleh analisa atribut yang objektif.</p>
            </div>
            <div class="feature-box text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="Transparan"
                    class="mx-auto w-16 h-16 icon-zoom mb-4">
                <h3 class="text-xl font-bold mb-2">Transparan</h3>
                <p>Proses penilaian dan perhitungan yang jelas dan dapat ditelusuri.</p>
            </div>
            <div class="feature-box text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/1048/1048953.png" alt="Mudah Digunakan"
                    class="mx-auto w-16 h-16 icon-zoom mb-4">
                <h3 class="text-xl font-bold mb-2">Mudah Digunakan</h3>
                <p>Tampilan antarmuka yang ramah pengguna membuat sistem mudah dipahami.</p>
            </div>
            <div class="feature-box text-center">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/teamwork-support-6558972-5393435.png"
                    alt="Gotong Royong" class="mx-auto w-16 h-16 icon-zoom mb-4">
                <h3 class="text-xl font-bold mb-2">Kolaboratif</h3>
                <p>Dapat digunakan secara bersama dalam tim untuk menghasilkan keputusan bersama.</p>
            </div>
            <div class="feature-box text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/3820/3820330.png" alt="Fleksibel"
                    class="mx-auto w-16 h-16 icon-zoom mb-4">
                <h3 class="text-xl font-bold mb-2">Fleksibel</h3>
                <p>Dapat disesuaikan dengan berbagai jenis masalah dan kriteria keputusan.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-6 text-sm text-gray-300 bg-gray-800 bg-opacity-95 border-t border-white/10">
        &copy; {{ date('Y') }} SMART SPK. All rights reserved.
    </footer>

    <!-- Scroll Reveal Script -->
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.feature-box').forEach(box => {
            observer.observe(box);
        });
    </script>
</body>

</html>