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
                        $.ajax({
                            type: "post",
                            url: "{{ route("perhitungan.smarter") }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
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
                            error: function(response) {
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
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            <div role="alert" class="alert mb-5 flex items-center justify-between border-0 bg-secondary-color shadow-xl dark:bg-secondary-color-dark dark:shadow-secondary-color-dark/20">
                <h6 class="font-bold text-primary-color dark:text-white">Perhitungan Metode SMARTER-ROC</h6>
                <div class="flex gap-2">
                    @if($nilaiAkhir->first())
                        <button class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-info bg-transparent bg-white px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-info shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return lihat_hasil_detail()">
                            <i class="ri-eye-line"></i>
                            Lihat Hasil Detail
                        </button>
                    @endif
                    <button class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent bg-white px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return perhitungan_button()">
                        <i class="ri-calculator-line"></i>
                        Perhitungan SMARTER-ROC
                    </button>
                </div>
            </div>

            {{-- Info Box ROC --}}
            @if($normalisasiBobot->first())
                <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-gradient-to-r from-blue-50 to-indigo-50 bg-clip-border shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h6 class="font-bold text-primary-color">Informasi Metode SMARTER-ROC</h6>
                            <i class="ri-information-line text-2xl text-info"></i>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="mb-2"><strong>ROC (Rank Order Centroid):</strong></p>
                                <ul class="list-disc ml-4 text-gray-700">
                                    <li>Pembobotan berdasarkan ranking kriteria</li>
                                    <li>Kriteria ranking 1 = paling penting</li>
                                    <li>Bobot dihitung otomatis menggunakan formula ROC</li>
                                </ul>
                            </div>
                            <div>
                                <p class="mb-2"><strong>SMARTER Method:</strong></p>
                                <ul class="list-disc ml-4 text-gray-700">
                                    <li>Simple Multi-Attribute Rating Technique Extended to Ranking</li>
                                    <li>Normalisasi utility untuk setiap kriteria</li>
                                    <li>Perhitungan nilai akhir dengan pembobotan ROC</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Awal Tabel Normalisasi Bobot Kriteria (ROC) --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel Bobot ROC (Rank Order Centroid)</h6>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable1" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-primary-color text-xs font-bold uppercase text-white dark:bg-primary-color-dark dark:text-white">
                                    <th class="rounded-tl">Kode</th>
                                    <th>Nama Kriteria</th>
                                    <th>Ranking</th>
                                    <th>Bobot ROC</th>
                                    <th class="rounded-tr">Jenis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($normalisasiBobot as $item)
                                    <tr class="border-b border-primary-color bg-transparent dark:border-primary-color-dark">
                                        <td>
                                            <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                {{ $item->kriteria->kode }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-left align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                {{ $item->kriteria->kriteria }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center align-middle text-base font-bold leading-tight text-success">
                                                {{ $item->kriteria->ranking ?? $item->kriteria->bobot }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center align-middle text-base font-bold leading-tight text-info">
                                                {{ round($item->normalisasi, 4) }}
                                            </p>
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->kriteria->jenis_kriteria == 'Benefit' ? 'badge-success' : 'badge-warning' }}">
                                                {{ $item->kriteria->jenis_kriteria }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-100">
                                    <td></td>
                                    <td class="text-right align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">Total:</td>
                                    <td></td>
                                    <td class="text-center align-middle text-base font-bold leading-tight text-info">
                                        {{ round($normalisasiBobot->sum("normalisasi"), 4) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        @if($normalisasiBobot->first())
                            <div class="mt-3 p-4 bg-info bg-opacity-10 rounded-lg">
                                <h6 class="font-bold text-info mb-2">Formula ROC:</h6>
                                <p class="text-sm text-gray-700 mb-2">
                                    <strong>w<sub>j</sub> = (1/K) × Σ<sub>k=r<sub>j</sub></sub><sup>K</sup> (1/r<sub>k</sub>)</strong>
                                </p>
                                <ul class="text-sm text-gray-600 list-disc ml-5">
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
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel Nilai Utility</h6>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable2" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-primary-color text-xs font-bold uppercase text-white dark:bg-primary-color-dark dark:text-white">
                                    <th class="rounded-tl">Alternatif</th>
                                    @foreach ($kriteria as $item)
                                        <th>{{ $item->kriteria }}<br><small>({{ $item->jenis_kriteria }})</small></th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $item)
                                    <tr class="border-b border-primary-color bg-transparent dark:border-primary-color-dark">
                                        <td>
                                            <p class="text-left align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                {{ $item->alternatif }}
                                            </p>
                                        </td>
                                        @if ($nilaiUtility->first())
                                            @foreach ($nilaiUtility->where("alternatif_id", $item->id) as $value)
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                        @if ($value->nilai == 0)
                                                            {{ round($value->nilai, 4) }}
                                                        @elseif ($value->nilai == null)
                                                            -
                                                        @else
                                                            {{ round($value->nilai, 4) }}
                                                        @endif
                                                    </p>
                                                </td>
                                            @endforeach
                                        @else
                                            @foreach ($kriteria as $krit_item)
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                        -
                                                    </p>
                                                </td>
                                            @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3 p-4 bg-warning bg-opacity-10 rounded-lg">
                            <h6 class="font-bold text-warning mb-2">Formula Utility:</h6>
                            <ul class="text-sm text-gray-600 list-disc ml-5">
                                <li><strong>Benefit:</strong> u<sub>ij</sub> = (x<sub>ij</sub> - x<sub>min</sub>) / (x<sub>max</sub> - x<sub>min</sub>)</li>
                                <li><strong>Cost:</strong> u<sub>ij</sub> = (x<sub>max</sub> - x<sub>ij</sub>) / (x<sub>max</sub> - x<sub>min</sub>)</li>
                                <li>Nilai utility berkisar antara 0 hingga 1</li>
                                <li>Pastikan setiap alternatif terisi semua pada menu penilaian</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Nilai Utility --}}

            {{-- Awal Tabel Nilai Akhir --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel Nilai Akhir SMARTER</h6>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable3" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-primary-color text-xs font-bold uppercase text-white dark:bg-primary-color-dark dark:text-white">
                                    <th class="rounded-tl">Alternatif</th>
                                    @foreach ($kriteria as $item)
                                        <th>{{ $item->kriteria }}</th>
                                    @endforeach
                                    <th class="rounded-tr">Total Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $item)
                                    <tr class="border-b border-primary-color bg-transparent dark:border-primary-color-dark">
                                        <td>
                                            <p class="text-left align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                {{ $item->alternatif }}
                                            </p>
                                        </td>
                                        @if ($nilaiAkhir->first())
                                            @foreach ($nilaiAkhir->where("alternatif_id", $item->id) as $value)
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                        @if ($value->nilai == 0)
                                                            {{ round($value->nilai, 4) }}
                                                        @elseif ($value->nilai == null)
                                                            -
                                                        @else
                                                            {{ round($value->nilai, 4) }}
                                                        @endif
                                                    </p>
                                                </td>
                                            @endforeach
                                            <td>
                                                <p class="text-center align-middle text-base font-bold leading-tight text-info">
                                                    {{ round($nilaiAkhir->where("alternatif_id", $item->id)->sum("nilai"), 4) }}
                                                </p>
                                            </td>
                                        @else
                                            @foreach ($kriteria as $krit_item)
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                        -
                                                    </p>
                                                </td>
                                            @endforeach
                                            <td>
                                                <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                    -
                                                </p>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3 p-4 bg-success bg-opacity-10 rounded-lg">
                            <h6 class="font-bold text-success mb-2">Formula SMARTER:</h6>
                            <p class="text-sm text-gray-700 mb-2">
                                <strong>S<sub>i</sub> = Σ<sub>j=1</sub><sup>n</sup> w<sub>j</sub> × u<sub>ij</sub></strong>
                            </p>
                            <ul class="text-sm text-gray-600 list-disc ml-5">
                                <li>S<sub>i</sub> = Nilai akhir alternatif ke-i</li>
                                <li>w<sub>j</sub> = Bobot ROC kriteria ke-j</li>
                                <li>u<sub>ij</sub> = Nilai utility alternatif ke-i pada kriteria ke-j</li>
                                <li>Nilai akhir tertinggi = alternatif terbaik</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Nilai Akhir --}}
        </div>
    </div>
@endsection