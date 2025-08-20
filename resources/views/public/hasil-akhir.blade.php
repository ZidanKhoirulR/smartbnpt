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

        /* Kolom Alternatif center alignment */
        #myTable td:nth-child(3),
        #myTable th:nth-child(3) {
            text-align: center !important;
        }

        /* Konsistensi lebar kolom untuk 5 kolom */
        #myTable th:nth-child(1),
        #myTable td:nth-child(1) {
            width: 12%;
        }

        #myTable th:nth-child(2),
        #myTable td:nth-child(2) {
            width: 18%;
        }

        #myTable th:nth-child(3),
        #myTable td:nth-child(3) {
            width: 35%;
        }

        #myTable th:nth-child(4),
        #myTable td:nth-child(4) {
            width: 15%;
        }

        #myTable th:nth-child(5),
        #myTable td:nth-child(5) {
            width: 20%;
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

        /* Status badges */
        .status-diterima {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status-tidak-diterima {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        /* NIK styling */
        .nik-badge {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            word-break: break-all;
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
                </a>
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
                    <br>Status <strong>DITERIMA</strong> untuk nilai ≥ 0.75, <strong>TIDAK DITERIMA</strong> untuk nilai
                    < 0.75 </p>
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
                    Status <strong>DITERIMA</strong> untuk nilai ≥ 0.75, <strong>TIDAK DITERIMA</strong> untuk nilai <
                        0.75. </p>
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
                                <th class="text-center py-4 px-3 border-r border-gray-600">Kode</th>
                                <th class="text-center py-4 px-3 border-r border-gray-600">NIK</th>
                                <th class="text-center py-4 px-3 border-r border-gray-600">Alternatif</th>
                                <th class="text-center py-4 px-3 border-r border-gray-600">Nilai Akhir</th>
                                <th class="text-center py-4 px-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilaiAkhir as $index => $item)
                                @php
                                    $nilai = isset($item->nilai_raw) ? $item->nilai_raw : (is_numeric($item->nilai) ? (float) $item->nilai : 0.0);
                                    $status = $nilai >= 0.75 ? 'diterima' : 'tidak_diterima';
                                    $nilaiDisplay = isset($item->nilai_formatted) ? $item->nilai_formatted : number_format($nilai, 4);
                                @endphp
                                <tr
                                    class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200 
                                        @if($index === 0) ranking-1 @elseif($index === 1) ranking-2 @elseif($index === 2) ranking-3 @endif">

                                    <!-- Kode -->
                                    <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($index === 0)
                                                <i class="ri-medal-line medal-gold"></i>
                                            @elseif($index === 1)
                                                <i class="ri-medal-line medal-silver"></i>
                                            @elseif($index === 2)
                                                <i class="ri-medal-line medal-bronze"></i>
                                            @endif
                                            <span class="font-semibold text-lg">{{ $item->kode }}</span>
                                        </div>
                                    </td>

                                    <!-- NIK -->
                                    <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                        <span class="nik-badge">
                                            {{ $item->nik ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <!-- Alternatif -->
                                    <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <!-- Ranking Badge -->
                                            <span
                                                class="flex items-center justify-center w-10 h-10 rounded-full text-sm font-bold text-white"
                                                style="background: linear-gradient(135deg, 
                                                        @if($index === 0) #f59e0b, #d97706 
                                                        @elseif($index === 1) #6366f1, #4f46e5 
                                                        @elseif($index === 2) #ef4444, #dc2626 
                                                        @else #6b7280, #4b5563 @endif);">
                                                {{ $index + 1 }}
                                            </span>

                                            <div class="text-center">
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
                                    <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
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
                                            {{ $nilaiDisplay }}
                                        </span>
                                    </td>

                                    <!-- Keterangan Status -->
                                    <td class="py-4 px-3 align-middle text-center">
                                        @if($status === 'diterima')
                                            <span class="status-diterima">
                                                <i class="ri-checkbox-circle-line"></i>
                                                DITERIMA
                                            </span>
                                        @else
                                            <span class="status-tidak-diterima">
                                                <i class="ri-close-circle-line"></i>
                                                TIDAK DITERIMA
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Statistik Status --}}
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @php
                        $totalDiterima = collect($nilaiAkhir)->filter(function ($item) {
                            $nilai = isset($item->nilai_raw) ? $item->nilai_raw : (is_numeric($item->nilai) ? (float) $item->nilai : 0.0);
                            return $nilai >= 0.75;
                        })->count();
                        $totalTidakDiterima = collect($nilaiAkhir)->count() - $totalDiterima;
                    @endphp

                    <div class="p-6 rounded-xl text-sm text-white"
                        style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="ri-checkbox-circle-line text-2xl"></i>
                            <span class="font-bold text-lg">Status DITERIMA</span>
                        </div>
                        <p class="text-green-100">{{ $totalDiterima }} alternatif dengan nilai ≥ 0.75</p>
                        <div class="mt-3">
                            <div class="bg-white bg-opacity-30 rounded-full h-3">
                                <div class="bg-white rounded-full h-3"
                                    style="width: {{ $nilaiAkhir->count() > 0 ? ($totalDiterima / $nilaiAkhir->count()) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 rounded-xl text-sm text-white"
                        style="background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="ri-close-circle-line text-2xl"></i>
                            <span class="font-bold text-lg">Status TIDAK DITERIMA</span>
                        </div>
                        <p class="text-red-100">{{ $totalTidakDiterima }} alternatif dengan nilai < 0.75</p>
                                <div class="mt-3">
                                    <div class="bg-white bg-opacity-30 rounded-full h-3">
                                        <div class="bg-white rounded-full h-3"
                                            style="width: {{ $nilaiAkhir->count() > 0 ? ($totalTidakDiterima / $nilaiAkhir->count()) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-xl text-sm text-white"
                        style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="ri-trophy-line text-2xl"></i>
                            <span class="font-bold text-lg">Syarat Penerimaan BPNT</span>
                        </div>
                        <p class="text-yellow-100">
                            Alternatif dengan nilai ≥ 0.75 berstatus <strong>DITERIMA</strong>,
                            nilai < 0.75 berstatus <strong>TIDAK DITERIMA</strong>
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
                        Interpretasi Nilai Akhir & Status
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-2 text-cyan-100">Kategori Nilai:</h4>
                            <ul class="space-y-1 text-cyan-100">
                                <li><strong>0.8 - 1.0:</strong> Sangat Baik</li>
                                <li><strong>0.75 - 0.8:</strong> Baik (DITERIMA)</li>
                                <li><strong>0.6 - 0.75:</strong> Cukup (TIDAK DITERIMA)</li>
                                <li><strong>
                                        < 0.6:</strong> Kurang (TIDAK DITERIMA)</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-cyan-100">Status & Metodologi:</h4>
                            <ul class="space-y-1 text-cyan-100">
                                <li>🟢 Status DITERIMA: Nilai ≥ 0.75</li>
                                <li>🔴 Status TIDAK DITERIMA: Nilai < 0.75</li>
                                <li>• Ranking otomatis berdasarkan nilai tertinggi</li>
                                <li>• Batas minimum penerimaan: 0.75</li>
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
                    $('#' + tableId + ' tbody tr').each(function () {
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
                                { width: "12%", targets: 0 },   // Kode
                                { width: "18%", targets: 1 },   // NIK
                                { width: "35%", targets: 2 },   // Alternatif
                                { width: "15%", targets: 3 },   // Nilai Akhir
                                { width: "20%", targets: 4 },   // Keterangan
                                { className: "text-center", targets: [0, 1, 2, 3, 4] }
                            ],
                            autoWidth: false,
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

            // Inisialisasi DataTable untuk tabel hasil akhir
            initializeDataTable('myTable');
        });
    </script>

</body>

</html>