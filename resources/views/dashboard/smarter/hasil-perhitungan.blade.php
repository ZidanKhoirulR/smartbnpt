@extends("dashboard.layouts.main")

@section("js")
    <script>
        $(document).ready(function () {
            $('#hasilTable').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    },
                },
                order: [[1, 'desc']], // Sort by nilai akhir descending
                pagingType: 'full_numbers',
            });

            $('#detailNormalisasiTable').DataTable({
                responsive: true,
                pagingType: 'full_numbers',
            });

            $('#detailUtilityTable').DataTable({
                responsive: true,
                pagingType: 'full_numbers',
            });

            $('#detailNilaiAkhirTable').DataTable({
                responsive: true,
                pagingType: 'full_numbers',
            });
        });

        function printReport() {
            window.print();
        }

        function exportPDF() {
            window.location.href = "{{ route('pdf.hasil') }}";
        }
    </script>
@endsection

@section("css")
    <style>
        .ranking-badge {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
            font-weight: bold;
            color: white;
            margin-right: 8px;
        }

        .rank-1 {
            background: linear-gradient(135deg, #ffd700, #ffed4a);
            color: #1a1a1a;
        }

        .rank-2 {
            background: linear-gradient(135deg, #c0c0c0, #e2e8f0);
            color: #1a1a1a;
        }

        .rank-3 {
            background: linear-gradient(135deg, #cd7f32, #f6ad55);
            color: white;
        }

        .rank-other {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
            color: white;
        }

        .detail-card {
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-title {
                text-align: center;
                margin-bottom: 20px;
                font-size: 24px;
                font-weight: bold;
            }
        }
    </style>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">

            {{-- Print Title (hidden on screen) --}}
            <div class="print-title" style="display: none;">
                HASIL PERHITUNGAN METODE SMARTER-ROC
                <br>
                <small>Sistem Pendukung Keputusan</small>
            </div>

            {{-- Header --}}
            <div
                class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20 no-print">
                <div
                    class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Hasil Detail Perhitungan
                        SMARTER-ROC</h6>
                    <div class="flex gap-2">
                        <button onclick="exportPDF()"
                            class="inline-block cursor-pointer rounded-lg px-4 py-2 text-center text-sm font-bold text-white transition-all hover:-translate-y-px hover:opacity-75"
                            style="background: linear-gradient(135deg, #dc2626, #b91c1c); box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);">
                            <i class="ri-file-pdf-line"></i> Export PDF
                        </button>
                        <button onclick="printReport()"
                            class="inline-block cursor-pointer rounded-lg px-4 py-2 text-center text-sm font-bold text-white transition-all hover:-translate-y-px hover:opacity-75"
                            style="background: linear-gradient(135deg, #059669, #047857); box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);">
                            <i class="ri-printer-line"></i> Print
                        </button>
                        <a href="{{ route('perhitungan') }}"
                            class="inline-block cursor-pointer rounded-lg px-4 py-2 text-center text-sm font-bold text-white transition-all hover:-translate-y-px hover:opacity-75"
                            style="background: linear-gradient(135deg, #6b7280, #4b5563); box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);">
                            <i class="ri-arrow-left-line"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Alert Info --}}
            <div class="mb-4 rounded-lg p-4 text-sm text-white" role="alert"
                style="background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
                <span class="font-medium">Hasil Perhitungan SMARTER-ROC:</span>
                Berikut adalah hasil lengkap perhitungan menggunakan metode SMARTER dengan pembobotan ROC (Rank Order
                Centroid).
                Alternatif dengan nilai tertinggi merupakan rekomendasi terbaik.
            </div>

            {{-- Ranking Hasil Akhir --}}
            <div
                class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20 detail-card">
                <div class="border-b-solid mb-0 rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">
                        <i class="ri-trophy-line text-yellow-500"></i> Ranking Hasil Akhir
                    </h6>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="hasilTable"
                            class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top"
                            style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="text-xs font-bold uppercase text-white"
                                    style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Ranking</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Alternatif</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Nilai Akhir</th>
                                    <th class="text-center py-4 px-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($hasilAkhir && $hasilAkhir->count() > 0)
                                    @foreach ($hasilAkhir as $index => $item)
                                        <tr
                                            class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                            <td class="text-center py-4 px-3 border-r border-gray-200">
                                                <span
                                                    class="ranking-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }}">
                                                    {{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td class="text-left py-4 px-3 border-r border-gray-200">
                                                <strong class="text-lg">{{ $item->alternatif }}</strong>
                                            </td>
                                            <td class="text-center py-4 px-3 border-r border-gray-200">
                                                <span class="px-3 py-2 rounded-full text-sm font-bold text-white"
                                                    style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                                                    {{ number_format($item->total_nilai, 4) }}
                                                </span>
                                            </td>
                                            <td class="text-center py-4 px-3">
                                                @if($index == 0)
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold text-white"
                                                        style="background: linear-gradient(135deg, #10b981, #059669);">
                                                        TERBAIK
                                                    </span>
                                                @elseif($index < 3)
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold text-white"
                                                        style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                                        TOP {{ $index + 1 }}
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold text-white"
                                                        style="background: linear-gradient(135deg, #6b7280, #4b5563);">
                                                        RANK {{ $index + 1 }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-8 text-gray-500">
                                            Belum ada data hasil perhitungan. Silakan lakukan perhitungan terlebih dahulu.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Detail Bobot ROC --}}
            <div
                class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20 detail-card">
                <div class="border-b-solid mb-0 rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">
                        <i class="ri-scales-line text-blue-500"></i> Detail Bobot ROC (Rank Order Centroid)
                    </h6>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="detailNormalisasiTable"
                            class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top"
                            style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="text-xs font-bold uppercase text-white"
                                    style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Kode</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Kriteria</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Ranking</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Bobot ROC</th>
                                    <th class="text-center py-4 px-3">Jenis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($normalisasiBobot && $normalisasiBobot->count() > 0)
                                    @foreach ($normalisasiBobot as $item)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="text-center py-4 px-3 border-r border-gray-200">
                                                {{ $item->kriteria->kode }}
                                            </td>
                                            <td class="text-center py-4 px-3 border-r border-gray-200">
                                                {{ $item->kriteria->kriteria }}
                                            </td>
                                            <td class="text-center py-4 px-3 border-r border-gray-200">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                    style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                                                    {{ $item->kriteria->ranking }}
                                                </span>
                                            </td>
                                            <td class="text-center py-4 px-3 border-r border-gray-200">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                    style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                                                    {{ number_format($item->normalisasi, 4) }}
                                                </span>
                                            </td>
                                            <td class="text-center py-4 px-3">
                                                @if($item->kriteria->jenis_kriteria == 'benefit')
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                        style="background: linear-gradient(135deg, #10b981, #059669);">BENEFIT</span>
                                                @else
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                        style="background: linear-gradient(135deg, #f59e0b, #d97706);">COST</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Detail Nilai Utility --}}
            <div
                class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20 detail-card">
                <div class="border-b-solid mb-0 rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">
                        <i class="ri-line-chart-line text-green-500"></i> Detail Nilai Utility
                    </h6>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="detailUtilityTable"
                            class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top"
                            style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="text-xs font-bold uppercase text-white"
                                    style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Alternatif</th>
                                    @if($kriteria && $kriteria->count() > 0)
                                        @foreach ($kriteria as $item)
                                            <th class="text-center py-4 px-3 border-r border-gray-600">{{ $item->kode }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if($alternatif && $alternatif->count() > 0)
                                    @foreach ($alternatif as $item)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="text-left py-4 px-3 border-r border-gray-200">
                                                <strong>{{ $item->alternatif }}</strong>
                                            </td>
                                            @if($nilaiUtility && $nilaiUtility->count() > 0)
                                                @foreach ($nilaiUtility->where("alternatif_id", $item->id) as $value)
                                                    <td class="text-center py-4 px-3 border-r border-gray-200">
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                            style="background: linear-gradient(135deg, #10b981, #059669);">
                                                            {{ number_format($value->nilai, 4) }}
                                                        </span>
                                                    </td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Detail Nilai Akhir --}}
            <div
                class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20 detail-card">
                <div class="border-b-solid mb-0 rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">
                        <i class="ri-calculator-line text-purple-500"></i> Detail Nilai Akhir SMARTER
                    </h6>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="detailNilaiAkhirTable"
                            class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top"
                            style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="text-xs font-bold uppercase text-white"
                                    style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Alternatif</th>
                                    @if($kriteria && $kriteria->count() > 0)
                                        @foreach ($kriteria as $item)
                                            <th class="text-center py-4 px-3 border-r border-gray-600">{{ $item->kode }}</th>
                                        @endforeach
                                    @endif
                                    <th class="text-center py-4 px-3">Total Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($alternatif && $alternatif->count() > 0)
                                    @foreach ($alternatif as $item)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="text-left py-4 px-3 border-r border-gray-200">
                                                <strong>{{ $item->alternatif }}</strong>
                                            </td>
                                            @if($nilaiAkhir && $nilaiAkhir->count() > 0)
                                                @foreach ($nilaiAkhir->where("alternatif_id", $item->id) as $value)
                                                    <td class="text-center py-4 px-3 border-r border-gray-200">
                                                        {{ number_format($value->nilai, 4) }}
                                                    </td>
                                                @endforeach
                                                <td class="text-center py-4 px-3">
                                                    <span class="px-3 py-2 rounded-full text-sm font-bold text-white"
                                                        style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                                                        {{ number_format($nilaiAkhir->where("alternatif_id", $item->id)->sum("nilai"), 4) }}
                                                    </span>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Formula Penjelasan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="p-4 rounded-lg text-sm text-white"
                    style="background: linear-gradient(135deg, #06b6d4, #0891b2); box-shadow: 0 8px 25px rgba(6, 182, 212, 0.3);">
                    <h6 class="font-bold mb-2">Formula ROC:</h6>
                    <p class="mb-2">
                        <strong>w<sub>j</sub> = (1/K) × Σ<sub>k=r<sub>j</sub></sub><sup>K</sup> (1/r<sub>k</sub>)</strong>
                    </p>
                    <ul class="list-disc ml-5 text-sm">
                        <li>w<sub>j</sub> = Bobot kriteria ke-j</li>
                        <li>K = Jumlah total kriteria</li>
                        <li>r<sub>j</sub> = Ranking kriteria ke-j</li>
                    </ul>
                </div>

                <div class="p-4 rounded-lg text-sm text-white"
                    style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                    <h6 class="font-bold mb-2">Formula SMARTER:</h6>
                    <p class="mb-2">
                        <strong>S<sub>i</sub> = Σ<sub>j=1</sub><sup>n</sup> w<sub>j</sub> × u<sub>ij</sub></strong>
                    </p>
                    <ul class="list-disc ml-5">
                        <li>S<sub>i</sub> = Nilai akhir alternatif ke-i</li>
                        <li>w<sub>j</sub> = Bobot ROC kriteria ke-j</li>
                        <li>u<sub>ij</sub> = Nilai utility alternatif ke-i pada kriteria ke-j</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection