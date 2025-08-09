<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - Sistem Bantuan Sosial</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .gradient-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Styling untuk DataTable */
        #hasilTable {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        #hasilTable thead th:first-child {
            border-top-left-radius: 12px;
        }

        #hasilTable thead th:last-child {
            border-top-right-radius: 12px;
        }

        #hasilTable tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        #hasilTable td,
        #hasilTable th {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 12px 8px !important;
        }

        #hasilTable td:nth-child(2),
        #hasilTable th:nth-child(2) {
            text-align: left !important;
        }

        /* Ranking styles */
        .ranking-1 {
            background: linear-gradient(135deg, #fef3c7, #fde68a) !important;
            border-left: 5px solid #f59e0b !important;
        }

        .ranking-2 {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe) !important;
            border-left: 5px solid #6366f1 !important;
        }

        .ranking-3 {
            background: linear-gradient(135deg, #fecaca, #fca5a5) !important;
            border-left: 5px solid #ef4444 !important;
        }

        .ranking-diterima {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0) !important;
            border-left: 5px solid #10b981 !important;
        }

        .ranking-tidak-diterima {
            background: linear-gradient(135deg, #fee2e2, #fecaca) !important;
            border-left: 5px solid #ef4444 !important;
        }

        .medal-gold {
            color: #f59e0b;
            font-size: 1.2rem;
        }

        .medal-silver {
            color: #6b7280;
            font-size: 1.2rem;
        }

        .medal-bronze {
            color: #d97706;
            font-size: 1.2rem;
        }
    </style>
</head>

<body class="font-sans">
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="gradient-card rounded-2xl shadow-xl p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $title }}</h1>
                        <p class="text-gray-600">Hasil perankingan bantuan sosial menggunakan metode SMARTER-ROC</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('hasil-akhir.public.pdf') }}" target="_blank"
                            class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors shadow-lg">
                            <i class="ri-file-pdf-2-line mr-2"></i>
                            Cetak PDF
                        </a>
                        <a href="{{ route('welcome') }}"
                            class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors shadow-lg">
                            <i class="ri-arrow-left-line mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Alert Info -->
            <div class="gradient-card rounded-2xl shadow-xl p-4 mb-6">
                <div class="flex items-center">
                    <i class="ri-information-line text-2xl text-blue-600 mr-3"></i>
                    <div>
                        <p class="text-gray-700 font-medium">
                            Hasil perhitungan SMARTER-ROC telah diurutkan berdasarkan nilai tertinggi.
                            <span class="text-green-600 font-bold">{{ $maxRecipients }} alternatif teratas</span>
                            akan menerima bantuan sosial.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tabel Hasil -->
            <div class="gradient-card rounded-2xl shadow-xl p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Tabel Perankingan</h2>
                    <p class="text-gray-600">Daftar lengkap hasil perhitungan dengan status penerima bantuan</p>
                </div>

                <div class="overflow-x-auto">
                    <table id="hasilTable" class="w-full">
                        <thead>
                            <tr
                                class="text-xs font-bold uppercase text-white text-center bg-gradient-to-r from-gray-800 to-gray-900">
                                <th class="py-4 px-3">Ranking</th>
                                <th class="py-4 px-3 text-left">Alternatif</th>
                                <th class="py-4 px-3">Nilai Akhir</th>
                                <th class="py-4 px-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilaiAkhir as $index => $item)
                                @php
                                    $ranking = $index + 1;
                                    $isDiterima = $ranking <= $maxRecipients;
                                    $rowClass = '';

                                    if ($ranking === 1)
                                        $rowClass = 'ranking-1';
                                    elseif ($ranking === 2)
                                        $rowClass = 'ranking-2';
                                    elseif ($ranking === 3)
                                        $rowClass = 'ranking-3';
                                    elseif ($isDiterima)
                                        $rowClass = 'ranking-diterima';
                                    else
                                        $rowClass = 'ranking-tidak-diterima';
                                @endphp

                                <tr
                                    class="border-b border-gray-200 hover:bg-gray-50 transition-all duration-200 {{ $rowClass }}">
                                    <!-- Ranking -->
                                    <td class="py-4 px-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($ranking === 1)
                                                <i class="ri-medal-line medal-gold"></i>
                                            @elseif($ranking === 2)
                                                <i class="ri-medal-line medal-silver"></i>
                                            @elseif($ranking === 3)
                                                <i class="ri-medal-line medal-bronze"></i>
                                            @endif

                                            <span
                                                class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold text-white"
                                                style="background: linear-gradient(135deg, 
                                                        @if($ranking === 1) #f59e0b, #d97706 
                                                        @elseif($ranking === 2) #6366f1, #4f46e5 
                                                        @elseif($ranking === 3) #ef4444, #dc2626 
                                                        @else #6b7280, #4b5563 @endif);">
                                                {{ $ranking }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Alternatif -->
                                    <td class="py-4 px-3 text-left">
                                        <div class="flex items-center gap-3">
                                            <div class="w-2 h-12 rounded-full bg-gradient-to-b from-blue-500 to-purple-600">
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $item->alternatif }}</div>
                                                <div class="text-sm text-gray-500">Kode: {{ $item->kode }}</div>

                                                @if($ranking === 1)
                                                    <small class="text-yellow-600 font-medium">🏆 Alternatif Terbaik</small>
                                                @elseif($ranking === 2)
                                                    <small class="text-blue-600 font-medium">🥈 Alternatif Kedua</small>
                                                @elseif($ranking === 3)
                                                    <small class="text-red-600 font-medium">🥉 Alternatif Ketiga</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Nilai Akhir -->
                                    <td class="py-4 px-3 text-center">
                                        <span class="px-3 py-2 rounded-full text-sm font-bold text-white shadow-lg" style="background: linear-gradient(135deg, 
                                                    @if($ranking === 1) #f59e0b, #d97706
                                                    @elseif($ranking === 2) #6366f1, #4f46e5
                                                    @elseif($ranking === 3) #ef4444, #dc2626
                                                    @elseif($isDiterima) #10b981, #059669
                                                    @else #6b7280, #4b5563 @endif);">
                                            {{ round($item->nilai, 4) }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-4 px-3 text-center">
                                        @if($isDiterima)
                                            <span
                                                class="px-3 py-2 rounded-full text-sm font-bold text-white bg-gradient-to-r from-green-500 to-green-600 shadow-lg">
                                                <i class="ri-check-line mr-1"></i>
                                                DITERIMA
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-2 rounded-full text-sm font-bold text-white bg-gradient-to-r from-red-500 to-red-600 shadow-lg">
                                                <i class="ri-close-line mr-1"></i>
                                                TIDAK DITERIMA
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Info Box -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 rounded-lg bg-gradient-to-br from-yellow-400 to-yellow-600 text-white shadow-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="ri-trophy-line text-xl"></i>
                            <span class="font-bold">Total Alternatif</span>
                        </div>
                        <p class="text-2xl font-bold">{{ $nilaiAkhir->count() }}</p>
                        <p class="text-xs opacity-90">Jumlah keseluruhan calon penerima</p>
                    </div>

                    <div class="p-4 rounded-lg bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="ri-check-line text-xl"></i>
                            <span class="font-bold">Diterima</span>
                        </div>
                        <p class="text-2xl font-bold">{{ $maxRecipients }}</p>
                        <p class="text-xs opacity-90">Alternatif yang menerima bantuan</p>
                    </div>

                    <div class="p-4 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="ri-line-chart-line text-xl"></i>
                            <span class="font-bold">Metode</span>
                        </div>
                        <p class="text-lg font-bold">SMARTER-ROC</p>
                        <p class="text-xs opacity-90">Sistem pengambilan keputusan</p>
                    </div>
                </div>

                <!-- Interpretasi Nilai -->
                <div class="mt-6 p-4 rounded-lg bg-gradient-to-br from-cyan-500 to-cyan-600 text-white shadow-lg">
                    <h3 class="font-bold mb-3 flex items-center gap-2">
                        <i class="ri-information-line text-xl"></i>
                        Interpretasi Nilai dan Metode
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <h4 class="font-semibold mb-2">Skala Nilai:</h4>
                            <ul class="space-y-1">
                                <li><strong>0.8 - 1.0:</strong> Sangat Baik</li>
                                <li><strong>0.6 - 0.8:</strong> Baik</li>
                                <li><strong>0.4 - 0.6:</strong> Cukup</li>
                                <li><strong>0.2 - 0.4:</strong> Kurang</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">Tentang SMARTER-ROC:</h4>
                            <ul class="space-y-1">
                                <li>• Metode pengambilan keputusan multi-kriteria</li>
                                <li>• Pembobotan otomatis menggunakan ROC</li>
                                <li>• Normalisasi utility untuk konsistensi nilai</li>
                                <li>• Ranking berdasarkan nilai tertinggi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#hasilTable').DataTable({
                responsive: true,
                ordering: false,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4"<"mb-2 sm:mb-0"l><"mb-2 sm:mb-0"f>>rt<"flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4"<"mb-2 sm:mb-0"i><"mb-2 sm:mb-0"p>>',
                initComplete: function () {
                    // Custom styling untuk search dan length
                    $('.dataTables_filter input').addClass('px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500');
                    $('.dataTables_length select').addClass('px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500');
                }
            });
        });
    </script>
</body>

</html>