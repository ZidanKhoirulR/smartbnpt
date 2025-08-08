@extends("dashboard.layouts.main")

@section("js")
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    },
                },
                ordering: false,
                pagingType: 'full_numbers',
            });
        });
    </script>
    @section("css")
        <style>
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

            /* ALIGNMENT FIXES - Pastikan semua sel rata tengah dengan padding yang konsisten */
            #myTable td,
            #myTable th {
                text-align: center !important;
                vertical-align: middle !important;
                min-height: 50px;
                padding: 12px 8px !important;
            }

            /* Kolom Alternatif tetap rata kiri */
            #myTable td:nth-child(2),
            #myTable th:nth-child(2) {
                text-align: left !important;
            }

            /* Semua div dalam sel rata tengah */
            #myTable td > div {
                display: block !important;
                width: 100%;
                text-align: center !important;
            }

            /* Kolom alternatif div tetap rata kiri */
            #myTable td:nth-child(2) > div {
                text-align: left !important;
            }

            /* Pastikan paragraf dalam sel mengikuti alignment */
            #myTable td p,
            #myTable th p {
                margin: 0 !important;
                padding: 0 !important;
                text-align: inherit;
                width: 100%;
            }

            /* Pastikan semua header rata tengah dengan force dan padding konsisten */
            #myTable thead th {
                text-align: center !important;
                vertical-align: middle !important;
                padding: 12px 8px !important;
            }

            /* Pastikan semua teks dalam header rata tengah kecuali kolom alternatif */
            #myTable thead th * {
                text-align: center !important;
            }

            #myTable thead th:nth-child(2) * {
                text-align: left !important;
            }

            /* Konsistensi lebar kolom */
            #myTable th:nth-child(1),
            #myTable td:nth-child(1) {
                width: 20%;
            }

            #myTable th:nth-child(2),
            #myTable td:nth-child(2) {
                width: 60%;
            }

            #myTable th:nth-child(3),
            #myTable td:nth-child(3) {
                width: 20%;
            }

            /* Ranking styles untuk baris */
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

            /* Medali icons */
            .medal-gold { color: #f59e0b; font-size: 1.2rem; }
            .medal-silver { color: #6b7280; font-size: 1.2rem; }
            .medal-bronze { color: #d97706; font-size: 1.2rem; }
        </style>
    @endsection
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Alert untuk hasil akhir --}}
            <div class="mb-4 rounded-lg p-4 text-sm text-white" role="alert"
                style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);">
                <span class="font-medium">Info Hasil Akhir:</span>
                Hasil perhitungan SMARTER-ROC telah diurutkan berdasarkan nilai tertinggi. 
                Alternatif dengan nilai tertinggi adalah yang terbaik sesuai kriteria yang telah ditetapkan.
            </div>

            {{-- Awal Tabel Hasil Akhir --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel {{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        <a href="{{ route('pdf.hasilAkhir') }}" target="_blank" 
                            class="mb-0 inline-block cursor-pointer rounded-lg px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-white shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2"
                            style="background: linear-gradient(135deg, #e11d48, #be185d); box-shadow: 0 4px 15px rgba(225, 29, 72, 0.3);">
                            <i class="ri-file-pdf-2-line"></i>
                            Cetak PDF
                        </a>
                    </div>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top text-center" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="text-xs font-bold uppercase text-white text-center"
                                    style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Kode</th>
                                    <th class="text-left py-4 px-3 border-r border-gray-600">Alternatif</th>
                                    <th class="text-center py-4 px-3">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nilaiAkhir as $index => $item)
                                    <tr class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200 
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
                                                <span class="font-semibold">{{ $item->kode }}</span>
                                            </div>
                                        </td>

                                        <!-- Alternatif -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-left">
                                            <div class="flex items-center gap-3">
                                                <!-- Ranking Badge -->
                                                <span class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold text-white"
                                                    style="background: linear-gradient(135deg, 
                                                        @if($index === 0) #f59e0b, #d97706 
                                                        @elseif($index === 1) #6366f1, #4f46e5 
                                                        @elseif($index === 2) #ef4444, #dc2626 
                                                        @else #6b7280, #4b5563 @endif);">
                                                    {{ $index + 1 }}
                                                </span>

                                                <div>
                                                    <div class="font-semibold text-primary-color">{{ $item->alternatif }}</div>
                                                    @if($index === 0)
                                                        <small class="text-yellow-600 font-medium">🏆 Alternatif Terbaik</small>
                                                    @elseif($index === 1)
                                                        <small class="text-blue-600 font-medium">🥈 Alternatif Kedua</small>
                                                    @elseif($index === 2)
                                                        <small class="text-red-600 font-medium">🥉 Alternatif Ketiga</small>
                                                    @else
                                                        <small class="text-gray-500">Ranking {{ $index + 1 }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Nilai Akhir -->
                                        <td class="py-4 px-3 align-middle text-center">
                                            <span class="px-3 py-2 rounded-full text-sm font-bold text-white"
                                                style="background: linear-gradient(135deg, 
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

                        {{-- Info Box Interpretasi --}}
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="p-4 rounded-lg text-sm text-white"
                                style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="ri-trophy-line text-lg"></i>
                                    <span class="font-bold">Peringkat 1</span>
                                </div>
                                <p class="text-xs">Alternatif dengan nilai tertinggi dan performa terbaik sesuai kriteria yang ditetapkan.</p>
                            </div>

                            <div class="p-4 rounded-lg text-sm text-white"
                                style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="ri-line-chart-line text-lg"></i>
                                    <span class="font-bold">Metode SMARTER-ROC</span>
                                </div>
                                <p class="text-xs">Pembobotan otomatis berdasarkan ranking kriteria dengan normalisasi utility 0-1.</p>
                            </div>

                            <div class="p-4 rounded-lg text-sm text-white"
                                style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="ri-file-pdf-2-line text-lg"></i>
                                    <span class="font-bold">Laporan PDF</span>
                                </div>
                                <p class="text-xs">Hasil lengkap dapat dicetak dalam format PDF untuk dokumentasi dan presentasi.</p>
                            </div>
                        </div>

                        {{-- Penjelasan Nilai --}}
                        <div class="mt-4 p-4 rounded-lg text-sm text-white"
                            style="background: linear-gradient(135deg, #06b6d4, #0891b2); box-shadow: 0 8px 25px rgba(6, 182, 212, 0.3);">
                            <h6 class="font-bold mb-2 flex items-center gap-2">
                                <i class="ri-information-line"></i>
                                Interpretasi Nilai Akhir
                            </h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <ul class="list-disc ml-5">
                                    <li><strong>Nilai 0.8 - 1.0:</strong> Sangat Baik</li>
                                    <li><strong>Nilai 0.6 - 0.8:</strong> Baik</li>
                                    <li><strong>Nilai 0.4 - 0.6:</strong> Cukup</li>
                                    <li><strong>Nilai 0.2 - 0.4:</strong> Kurang</li>
                                </ul>
                                <ul class="list-disc ml-5">
                                    <li>Nilai dihitung berdasarkan normalisasi utility</li>
                                    <li>Pembobotan menggunakan metode ROC</li>
                                    <li>Semakin tinggi nilai, semakin baik alternatif</li>
                                    <li>Ranking otomatis berdasarkan nilai tertinggi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Hasil Akhir --}}
        </div>
    </div>
@endsection