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
                order: [],
                pagingType: 'full_numbers',
            });
        });

        function nilai_akhir_button() {
            Swal.fire({
                title: 'Nilai Akhir',
                text: "Menghitung nilai akhir",
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
                        url: "{{ route("nilai-akhir.perhitungan") }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            Swal.fire({
                                title: 'Perhitungan berhasil dilakukan!',
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
                                icon: 'error',
                                confirmButtonColor: '#6419E6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            })
        }
    </script>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Awal Tabel Nilai Akhir --}}
            <div
                class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div
                    class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel {{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        <button
                            class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2"
                            onclick="return nilai_akhir_button()">
                            <i class="ri-add-line"></i>
                            Hitung Nilai Akhir
                        </button>
                    </div>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable"
                            class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top"
                            style="width: 100%;">
                            <thead class="align-bottom">
                                <tr
                                    class="bg-primary-color text-xs font-bold uppercase text-white dark:bg-primary-color-dark dark:text-white">
                                    <th class="rounded-tl"></th>
                                    @foreach ($kriteria as $item)
                                        <th>
                                            {{ $item->kriteria }}
                                        </th>
                                    @endforeach
                                    <th class="rounded-tr">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            {{-- Perbaikan untuk tabel nilai akhir di resources/views/dashboard/perhitungan/index.blade.php
                            --}}

                            {{-- Bagian Tabel Nilai Akhir yang diperbaiki --}}
                            <tbody>
                                @foreach ($alternatif as $item)
                                    <tr
                                        class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-left">
                                            <strong>{{ $item->alternatif }}</strong>
                                        </td>

                                        {{-- TAMPILKAN NILAI PER KRITERIA DARI MATRIKS TERNORMALISASI --}}
                                        @foreach ($kriteria as $krit)
                                            <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                                @php
                                                    // Cari nilai dari matriks ternormalisasi
                                                    $matriksValue = $matriksTernormalisasi
                                                        ->where("alternatif_id", $item->id)
                                                        ->where("kriteria_id", $krit->id)
                                                        ->first();
                                                @endphp
                                                @if ($matriksValue && $matriksValue->nilai !== null)
                                                    {{ number_format($matriksValue->nilai, 4) }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        @endforeach

                                        {{-- TOTAL NILAI --}}
                                        <td class="py-4 px-3 align-middle text-center">
                                            @php
                                                // Cari total dari nilai akhir
                                                $totalRecord = $nilaiAkhir->where("alternatif_id", $item->id)->first();
                                            @endphp
                                            @if ($totalRecord && $totalRecord->nilai !== null)
                                                <span class="px-3 py-2 rounded-full text-sm font-bold text-white"
                                                    style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                                                    {{ number_format($totalRecord->nilai, 4) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Ganti bagian keterangan di resources/views/dashboard/nilai-akhir/index.blade.php --}}

                        <div class="w-fit overflow-x-auto">
                            <table class="table table-xs">
                                <tr>
                                    <td class="text-base font-semibold text-primary-color dark:text-primary-color-dark">
                                        Formula Nilai Akhir:</td>
                                    <td class="text-base text-primary-color dark:text-primary-color-dark">
                                        <strong>NA<sub>i</sub> = Σ<sub>j=1</sub><sup>n</sup> MT<sub>ij</sub></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-base text-primary-color dark:text-primary-color-dark">Keterangan:</td>
                                    <td class="text-base text-primary-color dark:text-primary-color-dark">
                                        NA<sub>i</sub> = Nilai akhir alternatif ke-i, MT<sub>ij</sub> = Matriks
                                        ternormalisasi
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-base text-primary-color dark:text-primary-color-dark">* Pastikan telah
                                        melakukan perhitungan nilai utility dan normalisasi bobot kriteria</td>
                                    <td class="text-base text-primary-color dark:text-primary-color-dark"></td>
                                </tr>
                                <tr>
                                    <td class="text-base text-primary-color dark:text-primary-color-dark">* Nilai akhir =
                                        Penjumlahan semua nilai matriks ternormalisasi per alternatif</td>
                                    <td class="text-base text-primary-color dark:text-primary-color-dark"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Nilai Akhir --}}
        </div>
    </div>
@endsection