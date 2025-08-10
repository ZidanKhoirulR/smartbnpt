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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.tailwindcss.min.css">

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

        /* Table styles */
        #myTable {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        #myTable thead th:first-child {
            border-top-left-radius: 12px;
        }

        #myTable thead th:last-child {
            border-top-right-radius: 12px;
        }

        #myTable tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        #myTable td,
        #myTable th {
            text-align: center !important;
            vertical-align: middle !important;
            min-height: 50px;
            padding: 12px 8px !important;
        }

        #myTable td:nth-child(2),
        #myTable th:nth-child(2) {
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

            <!-- Navigation Links -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('welcome') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-blue-50">
                    <i class="ri-home-line mr-1"></i>Beranda
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="hero-bg pt-24 pb-12">
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-8">
            <div class="text-center text-white">
                <h1 class="text-5xl font-bold mb-4">{{ $title }}</h1>
                <p class="text-xl text-blue-100 leading-relaxed max-w-3xl mx-auto">
                    Sistem Pendukung Keputusan Penerimaan BPNT dengan metode SMARTER-ROC
                    <br>Hasil perhitungan telah diurutkan berdasarkan nilai tertinggi
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Alert Info -->
            <div class="mb-8 rounded-lg p-6 text-sm text-white content-card"
                style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);">
                <div class="flex items-center gap-3 mb-2">
                    <i class="ri-information-line text-2xl"></i>
                    <span class="font-bold text-lg">Informasi Hasil Akhir</span>
                </div>
                <p class="text-purple-100">
                    Hasil perhitungan menggunakan metode SMARTER-ROC telah diurutkan berdasarkan nilai tertinggi.
                    Alternatif dengan nilai tertinggi adalah yang terbaik sesuai kriteria yang telah ditetapkan.
                </p>
            </div>

            <!-- Results Table -->
            <div class="content-card rounded-3xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl font-bold text-gray-900">Tabel {{ $title }}</h2>
                    <a href="{{ route('public.pdf.hasil') }}" target="_blank"
                        class="btn-primary text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                        <i class="ri-file-pdf-2-line"></i>
                        Cetak PDF
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table id="myTable"
                        class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top"
                        style="width: 100%;">
                        <thead class="align-bottom">
                            <tr class="text-xs font-bold uppercase text-white text-center"
                                style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                                <th class="text-center py-4 px-3 border-r border-gray-600">Ranking</th>
                                <th class="text-left py-4 px-3 border-r border-gray-600">Alternatif</th>
                                <th class="text-center py-4 px-3">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilaiAkhir as $index => $item)
                                <tr
                                    class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200 
                                                @if($index === 0) ranking-1 @elseif($index === 1) ranking-2 @elseif($index === 2) ranking-3 @endif">

                                    <!-- Ranking -->
                                    <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($index === 0)
                                                <i class="ri-medal-line medal-gold"></i>
                                            @elseif($index === 1)
                                                <i class="ri-medal-line medal-silver"></i>
                                            @elseif($index === 2)
                                                <i class="ri-medal-line medal-bronze"></i>
                                            @endif
                                            <span class="text-2xl font-bold text-gray-800">{{ $index + 1 }}</span>
                                        </div>
                                    </td>

                                    <!-- Alternatif -->
                                    <td class="py-4 px-3 border-r border-gray-200 align-middle text-left">
                                        <div class="flex items-center gap-3">
                                            <!-- Ranking Badge -->
                                            <span
                                                class="flex items-center justify-center w-10 h-10 rounded-full text-sm font-bold text-white"
                                                style="background: linear-gradient(135deg, 
                                                                    @if($index === 0) #f59e0b, #d97706 
                                                                    @elseif($index === 1) #6366f1, #4f46e5 
                                                                    @elseif($index === 2) #ef4444, #dc2626 
                                                                    @else #6b7280, #4b5563 @endif);">
                                                {{ $item->kode }}
                                            </span>

                                            <div>
                                                <div class="font-semibold text-lg text-gray-900">{{ $item->alternatif }}
                                                </div>
                                                @if($index === 0)
                                                    <small class="text-yellow-600 font-medium">🏆 Alternatif Terbaik</small>
                                                @elseif($index === 1)
                                                    <small class="text-blue-600 font-medium">🥈 Alternatif Kedua</small>
                                                @elseif($index === 2)
                                                    <small class="text-red-600 font-medium">🥉 Alternatif Ketiga</small>
                                                @else
                                                    <small class="text-gray-500">Peringkat {{ $index + 1 }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Nilai Akhir -->
                                    <td class="py-4 px-3 align-middle text-center">
                                        <span class="px-4 py-3 rounded-full text-lg font-bold text-white" style="background: linear-gradient(135deg, 
                                                                @if($index === 0) #f59e0b, #d97706
                                                                @elseif($index === 1) #6366f1, #4f46e5
                                                                @elseif($index === 2) #ef4444, #dc2626
                                                                @else #10b981, #059669 @endif); 
                                                                box-shadow: 0 4px 15px rgba(
                                                                    @if($index === 0) 245, 158, 11, 0.3
                                                                    @elseif($index === 1) 99, 102, 241, 0.3
                                                                    @elseif($index === 2) 239, 68, 68, 0.3
                                                                    @else 16, 185, 129, 0.3 @endif);">
                                            {{ $item->nilai }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Info Cards -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-xl text-sm text-white"
                        style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="ri-trophy-line text-2xl"></i>
                            <span class="font-bold text-lg">Peringkat Teratas</span>
                        </div>
                        <p class="text-yellow-100">
                            Alternatif dengan nilai tertinggi dan performa terbaik sesuai kriteria yang ditetapkan dalam
                            sistem BPNT.
                        </p>
                    </div>

                    <div class="p-6 rounded-xl text-sm text-white"
                        style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="ri-line-chart-line text-2xl"></i>
                            <span class="font-bold text-lg">Metode SMARTER-ROC</span>
                        </div>
                        <p class="text-green-100">
                            Pembobotan otomatis berdasarkan ranking kriteria dengan normalisasi utility 0-1 untuk
                            akurasi maksimal.
                        </p>
                    </div>

                    <div class="p-6 rounded-xl text-sm text-white"
                        style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="ri-shield-check-line text-2xl"></i>
                            <span class="font-bold text-lg">Transparansi Penuh</span>
                        </div>
                        <p class="text-purple-100">
                            Proses seleksi yang transparan dan dapat dipertanggungjawabkan dengan dokumentasi lengkap.
                        </p>
                    </div>
                </div>

                <!-- Interpretation Guide -->
                <div class="mt-8 p-6 rounded-xl text-sm text-white"
                    style="background: linear-gradient(135deg, #06b6d4, #0891b2); box-shadow: 0 8px 25px rgba(6, 182, 212, 0.3);">
                    <h3 class="font-bold text-xl mb-4 flex items-center gap-2">
                        <i class="ri-information-line text-2xl"></i>
                        Interpretasi Nilai Akhir
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-2 text-cyan-100">Kategori Nilai:</h4>
                            <ul class="space-y-1 text-cyan-100">
                                <li><strong>0.8 - 1.0:</strong> Sangat Baik - Sangat layak menerima BPNT</li>
                                <li><strong>0.6 - 0.8:</strong> Baik - Layak menerima BPNT</li>
                                <li><strong>0.4 - 0.6:</strong> Cukup - Dapat dipertimbangkan</li>
                                <li><strong>0.2 - 0.4:</strong> Kurang - Prioritas rendah</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-cyan-100">Metodologi:</h4>
                            <ul class="space-y-1 text-cyan-100">
                                <li>• Nilai dihitung berdasarkan normalisasi utility</li>
                                <li>• Pembobotan menggunakan metode ROC (Rank Order Centroid)</li>
                                <li>• Semakin tinggi nilai, semakin baik alternatif</li>
                                <li>• Ranking otomatis berdasarkan nilai tertinggi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="mt-8 text-center">
                    <a href="{{ route('welcome') }}"
                        class="btn-secondary text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 inline-flex items-center gap-2">
                        <i class="ri-arrow-left-line"></i>
                        Kembali ke Beranda
                    </a>
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

    <script>
     $(document).ready(function () {
    // Inisialisasi DataTable dengan error handling
    function initializeDataTable(tableId) {
        try {
            if ($.fn.DataTable.isDataTable('#' + tableId)) {
                $('#' + tableId).DataTable().destroy();
            }
            
            // Hitung jumlah kolom dari header
            var columnCount = $('#' + tableId + ' thead tr:first th').length;
            
            // Validasi konsistensi kolom
            var isValidTable = true;
            $('#' + tableId + ' tbody tr').each(function() {
                var rowColumnCount = $(this).find('td').length;
                if (rowColumnCount !== columnCount) {
                    console.warn('Table ' + tableId + ' has inconsistent column count. Header: ' + columnCount + ', Row: ' + rowColumnCount);
                    isValidTable = false;
                }
            });
            
            if (isValidTable) {
                $('#' + tableId).DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr',
                        },
                    },
                    order: [],
                    pagingType: 'full_numbers',
                    columnDefs: [
                        { targets: '_all', className: 'text-center' }
                    ],
                    language: {
                        emptyTable: "Tidak ada data yang tersedia",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 entries",
                        infoFiltered: "(disaring dari _MAX_ total entries)",
                        lengthMenu: "Tampilkan _MENU_ entries",
                        loadingRecords: "Memuat...",
                        processing: "Sedang memproses...",
                        search: "Cari:",
                        zeroRecords: "Tidak ditemukan data yang sesuai",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            } else {
                console.error('Skipping DataTable initialization for ' + tableId + ' due to column mismatch');
            }
        } catch (error) {
            console.error('Error initializing DataTable for ' + tableId + ':', error);
        }
    }
    </script>

</body>

</html>