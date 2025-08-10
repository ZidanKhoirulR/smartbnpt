@extends("dashboard.layouts.main")

@section("js")
    <script>
        $(document).ready(function () {
            $('#myTable1').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    },
                },
                order: [],
                pagingType: 'full_numbers',
            });

            $('#myTable2').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    },
                },
                order: [],
                pagingType: 'full_numbers',
            });

            $('#myTable3').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    },
                },
                order: [],
                pagingType: 'full_numbers',
            });
            $('#myTable4').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    },
                },
                order: [],
                pagingType: 'full_numbers',
            });
        });

        function perhitungan_button() {
            Swal.fire({
                title: 'Perhitungan Metode SMARTER',
                text: "Menghitung normalisasi bobot ROC, nilai utility dan nilai akhir dengan metode SMARTER-ROC",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#6419E6',
                cancelButtonColor: '#F87272',
                confirmButtonText: 'Hitung',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menghitung...',
                        text: 'Sedang melakukan perhitungan SMARTER-ROC',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        type: "post",
                        url: "{{ route("perhitungan.smarter") }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            Swal.fire({
                                title: 'Perhitungan berhasil dilakukan!',
                                text: 'Perhitungan SMARTER-ROC telah selesai. Anda dapat melihat hasil detail.',
                                icon: 'success',
                                confirmButtonColor: '#6419E6',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function (response) {
                            Swal.fire({
                                title: 'Perhitungan gagal dilakukan!',
                                text: 'Terjadi kesalahan saat melakukan perhitungan. Silakan coba lagi.',
                                icon: 'error',
                                confirmButtonColor: '#6419E6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            })
        }

        function lihat_hasil_detail() {
            window.location.href = "{{ route('hasil-perhitungan') }}";
        }
    </script>

    @section("css")
        <style>
            /* Styling untuk semua tabel */
            #myTable1,
            #myTable2,
            #myTable3,
            #myTable4 {
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            /* Header corners */
            #myTable1 thead th:first-child,
            #myTable2 thead th:first-child,
            #myTable3 thead th:first-child,
            #myTable4 thead th:first-child {
                border-top-left-radius: 12px;
            }

            #myTable1 thead th:last-child,
            #myTable2 thead th:last-child,
            #myTable3 thead th:last-child,
            #myTable4 thead th:last-child {
                border-top-right-radius: 12px;
            }

            /* Hover effects */
            #myTable1 tbody tr:hover,
            #myTable2 tbody tr:hover,
            #myTable3 tbody tr:hover,
            #myTable4 tbody tr:hover {
                background-color: #f8fafc;
                transform: scale(1.01);
                transition: all 0.2s ease;
            }

            /* ALIGNMENT FIXES - Semua sel rata tengah dengan padding konsisten */
            #myTable1 td,
            #myTable1 th,
            #myTable2 td,
            #myTable2 th,
            #myTable3 td,
            #myTable3 th,
            #myTable4 td,
            #myTable4 th {
                text-align: center !important;
                vertical-align: middle !important;
                min-height: 50px;
                padding: 12px 8px !important;
            }

            /* Kolom alternatif tetap rata kiri */
            #myTable2 td:first-child,
            #myTable3 td:first-child,
            #myTable4 td:first-child {
                text-align: left !important;
            }

            /* Semua div dalam sel rata tengah */
            #myTable1 td>div,
            #myTable2 td>div,
            #myTable3 td>div,
            #myTable4 td>div {
                display: block !important;
                width: 100%;
                text-align: center !important;
            }

            /* Kolom alternatif div tetap rata kiri */
            #myTable2 td:first-child>div,
            #myTable3 td:first-child>div,
            #myTable4 td:first-child>div {
                text-align: left !important;
            }

            /* Pastikan paragraf mengikuti alignment */
            #myTable1 td p,
            #myTable1 th p,
            #myTable2 td p,
            #myTable2 th p,
            #myTable3 td p,
            #myTable3 th p,
            #myTable4 td p,
            #myTable4 th p {
                margin: 0 !important;
                padding: 0 !important;
                text-align: inherit;
                width: 100%;
            }

            /* Pastikan span badge center */
            #myTable1 td span,
            #myTable2 td span,
            #myTable3 td span,
            #myTable4 td span {
                display: inline-block;
                text-align: center;
            }

            /* Pastikan semua header rata tengah */
            #myTable1 thead th,
            #myTable2 thead th,
            #myTable3 thead th,
            #myTable4 thead th {
                text-align: center !important;
                vertical-align: middle !important;
                padding: 12px 8px !important;
            }

            #myTable1 thead th *,
            #myTable2 thead th *,
            #myTable3 thead th *,
            #myTable4 thead th * {
                text-align: center !important;
            }

            /* Footer alignment */
            #myTable1 tfoot td,
            #myTable2 tfoot td,
            #myTable3 tfoot td,
            #myTable4 tfoot td {
                vertical-align: middle !important;
            }

            #myTable1 tfoot td[colspan="2"],
            #myTable1 tfoot td[colspan="3"] {
                text-align: right !important;
            }

            #myTable1 tfoot td:not([colspan]) {
                text-align: center !important;
            }
        </style>
    @endsection
@endsection

@section("container")
    <div class="mb-4 rounded-lg p-4 text-sm text-white" role="alert"
        style="background: linear-gradient(135deg, #059669, #047857); box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="font-medium">Langkah Perhitungan:</span>
                <ol class="list-decimal ml-5 mt-1 text-sm">
                    <li>Hitung bobot ROC dari ranking kriteria</li>
                    <li>Normalisasi nilai ke utility (0-1)</li>
                    <li>Kalikan utility dengan bobot ROC</li>
                    <li>Jumlahkan hasil per alternatif</li>
                </ol>
            </div>
            <div>
                <span class="font-medium">Formula Kunci:</span>
                <ul class="list-disc ml-5 mt-1 text-sm">
                    <li><strong>ROC:</strong> w<sub>j</sub> = (1/K) × Σ(1/r<sub>k</sub>)</li>
                    <li><strong>Utility:</strong> u<sub>ij</sub> = (x<sub>ij</sub> - x<sub>min</sub>) / (x<sub>max</sub> -
                        x<sub>min</sub>)</li>
                    <li><strong>Matriks:</strong> MT<sub>ij</sub> = u<sub>ij</sub> × w<sub>j</sub></li>
                    <li><strong>Nilai Akhir:</strong> NA<sub>i</sub> = Σ MT<sub>ij</sub></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Header dengan tombol aksi --}}
    <div
        class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
        <div
            class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
            <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Perhitungan Metode SMARTER-ROC
            </h6>
            <div class="w-1/2 max-w-full flex-none px-3 text-right">
                @if($nilaiAkhir->first())
                    <button
                        class="mb-0 inline-block cursor-pointer rounded-lg px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-white shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2 mr-2"
                        onclick="return lihat_hasil_detail()"
                        style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                        <i class="ri-eye-line"></i>
                        Lihat Detail
                    </button>
                @endif
                <button
                    class="mb-0 inline-block cursor-pointer rounded-lg px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-white shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2"
                    onclick="return perhitungan_button()"
                    style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                    <i class="ri-calculator-line"></i>
                    Hitung SMARTER
                </button>
            </div>
        </div>
    </div>

    {{-- Info Box ROC --}}
    @if($normalisasiBobot->first())
        <div class="mb-4 rounded-lg p-4 text-sm text-white" role="alert"
            style="background: linear-gradient(135deg, #059669, #047857); box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="font-medium">ROC (Rank Order Centroid):</span>
                    <br>Pembobotan berdasarkan ranking kriteria menggunakan formula matematika ROC.
                </div>
                <div>
                    <span class="font-medium">SMARTER Method:</span>
                    <br>Normalisasi utility dan perhitungan nilai akhir dengan pembobotan otomatis.
                </div>
            </div>
        </div>
    @endif

    {{-- Awal Tabel Normalisasi Bobot Kriteria (ROC) --}}
    <div
        class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
        <div
            class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
            <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel Bobot ROC (Rank Order
                Centroid)</h6>
        </div>
        <div class="flex-auto px-0 pb-2 pt-0">
            <div class="overflow-x-auto p-0 px-6 pb-6">
                <table id="myTable1"
                    class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top text-center"
                    style="width: 100%;">
                    <thead class="align-bottom">
                        <tr class="text-xs font-bold uppercase text-white text-center"
                            style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                            <th class="text-center py-4 px-3 border-r border-gray-600">Kode</th>
                            <th class="text-center py-4 px-3 border-r border-gray-600">Nama Kriteria</th>
                            <th class="text-center py-4 px-3 border-r border-gray-600">Ranking</th>
                            <th class="text-center py-4 px-3 border-r border-gray-600">Bobot ROC</th>
                            <th class="text-center py-4 px-3">Jenis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($normalisasiBobot as $item)
                            <tr class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                    {{ $item->kriteria->kode }}
                                </td>
                                <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                    {{ $item->kriteria->kriteria }}
                                </td>
                                <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                        style="background: linear-gradient(135deg, #3b82f6, #6366f1);">
                                        {{ $item->kriteria->ranking ?? $item->kriteria->bobot }}
                                    </span>
                                </td>
                                <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                        style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                                        {{ round($item->normalisasi, 4) }}
                                    </span>
                                </td>
                                <td class="py-4 px-3 align-middle text-center">
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
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-300"
                            style="background: linear-gradient(135deg, #f8fafc, #e2e8f0);">
                            <td colspan="3"
                                class="text-right py-4 px-3 text-base font-semibold text-gray-800 border-r border-gray-200">
                                Total Bobot:
                            </td>
                            <td class="text-center py-4 px-3 text-base font-bold text-white border-r border-gray-200"
                                style="background: linear-gradient(135deg, #059669, #047857);">
                                {{ round($normalisasiBobot->sum("normalisasi"), 4) }}
                            </td>
                            <td class="py-4 px-3"></td>
                        </tr>
                    </tfoot>
                </table>
                @if($normalisasiBobot->first())
                    <div class="mt-3 p-4 rounded-lg text-sm text-white"
                        style="background: linear-gradient(135deg, #06b6d4, #0891b2); box-shadow: 0 8px 25px rgba(6, 182, 212, 0.3);">
                        <h6 class="font-bold mb-2">Formula ROC:</h6>
                        <p class="mb-2">
                            <strong>w<sub>j</sub> = (1/K) × Σ<sub>k=r<sub>j</sub></sub><sup>K</sup>
                                (1/r<sub>k</sub>)</strong>
                        </p>
                        <ul class="list-disc ml-5 text-sm">
                            <li>w<sub>j</sub> = Bobot kriteria ke-j</li>
                            <li>K = Jumlah total kriteria ({{ $normalisasiBobot->count() }})</li>
                            <li>r<sub>j</sub> = Ranking kriteria ke-j</li>
                            <li>Ranking 1 = paling penting, ranking tertinggi = kurang penting</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- Akhir Tabel Normalisasi Bobot Kriteria --}}

    {{-- Awal Tabel Nilai Utility --}}
    <div
        class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
        <div
            class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
            <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel Utility</h6>
        </div>
        <div class="flex-auto px-0 pb-2 pt-0">
            <div class="overflow-x-auto p-0 px-6 pb-6">
                <table id="myTable2"
                    class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top text-center"
                    style="width: 100%;">
                    <thead class="align-bottom">
                        <tr class="text-xs font-bold uppercase text-white text-center"
                            style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                            <th class="text-center py-4 px-3 border-r border-gray-600">Alternatif</th>
                            @foreach ($kriteria as $item)
                                <th class="text-center py-4 px-3 border-r border-gray-600">
                                    {{ $item->kriteria }}<br>
                                    <small class="text-xs opacity-80">({{ $item->jenis_kriteria }})</small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alternatif as $item)
                            <tr class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-3 border-r border-gray-200 align-middle text-left">
                                    <strong>{{ $item->alternatif }}</strong>
                                </td>
                                @if ($nilaiUtility->first())
                                    @foreach ($nilaiUtility->where("alternatif_id", $item->id) as $value)
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            @if ($value->nilai == 0)
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                    style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                                    {{ round($value->nilai, 4) }}
                                                </span>
                                            @elseif ($value->nilai == null)
                                                <span class="text-gray-400">-</span>
                                            @else
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                    style="background: linear-gradient(135deg, #10b981, #059669);">
                                                    {{ round($value->nilai, 4) }}
                                                </span>
                                            @endif
                                        </td>
                                    @endforeach
                                @else
                                    @foreach ($kriteria as $krit_item)
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            <span class="text-gray-400">-</span>
                                        </td>
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3 p-4 rounded-lg text-sm text-white"
                    style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                    <h6 class="font-bold mb-2">Formula Utility:</h6>
                    <ul class="list-disc ml-5">
                        <li><strong>Benefit:</strong> u<sub>ij</sub> = (x<sub>ij</sub> - x<sub>min</sub>) /
                            (x<sub>max</sub> - x<sub>min</sub>)</li>
                        <li><strong>Cost:</strong> u<sub>ij</sub> = (x<sub>max</sub> - x<sub>ij</sub>) /
                            (x<sub>max</sub> - x<sub>min</sub>)</li>
                        <li>Nilai utility berkisar antara 0 hingga 1</li>
                        <li>Pastikan setiap alternatif terisi semua pada menu penilaian</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- Akhir Tabel Nilai Utility --}}

    {{-- Tabel Matriks Ternormalisasi --}}
    <div
        class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
        <div
            class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
            <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel Matriks Ternormalisasi</h6>
        </div>
        <div class="flex-auto px-0 pb-2 pt-0">
            <div class="overflow-x-auto p-0 px-6 pb-6">
                <table id="myTable4"
                    class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top text-center"
                    style="width: 100%;">
                    <thead class="align-bottom">
                        <tr class="text-xs font-bold uppercase text-white text-center"
                            style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                            <th class="text-center py-4 px-3 border-r border-gray-600">Alternatif</th>
                            @foreach ($kriteria as $item)
                                <th class="text-center py-4 px-3 border-r border-gray-600">
                                    {{ $item->kriteria }}
                                    @if($normalisasiBobot->where('kriteria_id', $item->id)->first())
                                        <br><small class="text-xs opacity-80">(W:
                                            {{ round($normalisasiBobot->where('kriteria_id', $item->id)->first()->normalisasi, 4) }})</small>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alternatif as $item)
                            <tr class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-3 border-r border-gray-200 align-middle text-left">
                                    <strong>{{ $item->alternatif }}</strong>
                                </td>
                                @if (isset($matriksTernormalisasi) && $matriksTernormalisasi->first())
                                    @foreach ($matriksTernormalisasi->where("alternatif_id", $item->id) as $value)
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                style="background: linear-gradient(135deg, #059669, #047857);">
                                                {{ round($value->nilai, 4) }}
                                            </span>
                                        </td>
                                    @endforeach
                                @else
                                    @foreach ($kriteria as $krit)
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            <span class="text-gray-400">-</span>
                                        </td>
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3 p-4 rounded-lg text-sm text-white"
                    style="background: linear-gradient(135deg, #059669, #047857); box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);">
                    <h6 class="font-bold mb-2">Formula Matriks Ternormalisasi:</h6>
                    <p class="mb-2">
                        <strong>MT<sub>ij</sub> = u<sub>ij</sub> × w<sub>j</sub></strong>
                    </p>
                    <ul class="list-disc ml-5">
                        <li>MT<sub>ij</sub> = Matriks ternormalisasi alternatif ke-i pada kriteria ke-j</li>
                        <li>u<sub>ij</sub> = Nilai utility alternatif ke-i pada kriteria ke-j</li>
                        <li>w<sub>j</sub> = Bobot ROC kriteria ke-j</li>
                        <li>Hasil perkalian utility dengan bobot ROC</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- Akhir Matriks Ternormalisasi --}}

    {{-- Awal Tabel Nilai Akhir --}}
    <div
        class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
        <div
            class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
            <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel Nilai Akhir SMARTER</h6>
        </div>
        <div class="flex-auto px-0 pb-2 pt-0">
            <div class="overflow-x-auto p-0 px-6 pb-6">
                <table id="myTable3"
                    class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top text-center"
                    style="width: 100%;">
                    <thead class="align-bottom">
                        <tr class="text-xs font-bold uppercase text-white text-center"
                            style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                            <th class="text-center py-4 px-3 border-r border-gray-600">Alternatif</th>
                            @foreach ($kriteria as $item)
                                <th class="text-center py-4 px-3 border-r border-gray-600">{{ $item->kriteria }}</th>
                            @endforeach
                            <th class="text-center py-4 px-3">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alternatif as $item)
                            <tr class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-3 border-r border-gray-200 align-middle text-left">
                                    <strong>{{ $item->alternatif }}</strong>
                                </td>
                                @if ($nilaiAkhir->first())
                                    @foreach ($nilaiAkhir->where("alternatif_id", $item->id) as $value)
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            @if ($value->nilai == 0)
                                                {{ round($value->nilai, 4) }}
                                            @elseif ($value->nilai == null)
                                                <span class="text-gray-400">-</span>
                                            @else
                                                {{ round($value->nilai, 4) }}
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="py-4 px-3 align-middle text-center">
                                        <span class="px-3 py-2 rounded-full text-sm font-bold text-white"
                                            style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                                            {{ round($nilaiAkhir->where("alternatif_id", $item->id)->sum("nilai"), 4) }}
                                        </span>
                                    </td>
                                @else
                                    @foreach ($kriteria as $krit_item)
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            <span class="text-gray-400">-</span>
                                        </td>
                                    @endforeach
                                    <td class="py-4 px-3 align-middle text-center">
                                        <span class="text-gray-400">-</span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3 p-4 rounded-lg text-sm text-white"
                    style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                    <h6 class="font-bold mb-2">Formula Nilai Akhir:</h6>
                    <p class="mb-2 text-lg">
                        <strong>Total = K1 + K2 + K3 + ... + Kn</strong>
                    </p>
                    <ul class="list-disc ml-5">
                        <li>Total = Penjumlahan nilai semua kriteria untuk setiap alternatif</li>
                        <li>K1, K2, K3 = Nilai setiap kriteria dari matriks ternormalisasi</li>
                        <li>Contoh: Alternatif A = 0.2500 + 0.1875 + 0.0833 = 0.5208</li>
                        <li>Alternatif dengan total nilai tertinggi = alternatif terbaik</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- Akhir Tabel Nilai Akhir --}}
    </div>
    </div>
@endsection