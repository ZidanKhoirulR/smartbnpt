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
                                                    $matriksValue = null;
                                                    if ($matriksTernormalisasi && $matriksTernormalisasi->count() > 0) {
                                                        $matriksValue = $matriksTernormalisasi
                                                            ->where("alternatif_id", $item->id)
                                                            ->where("kriteria_id", $krit->id)
                                                            ->first();
                                                    }
                                                @endphp
                                                @if ($matriksValue && isset($matriksValue->nilai) && $matriksValue->nilai !== null)
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                        style="background: linear-gradient(135deg, #059669, #047857);">
                                                        {{ number_format($matriksValue->nilai, 4) }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        @endforeach

                                        {{-- TOTAL NILAI --}}
                                        <td class="py-4 px-3 align-middle text-center">
                                            @php
                                                // Cari total dari nilai akhir
                                                $totalRecord = null;
                                                if ($nilaiAkhirTotal && $nilaiAkhirTotal->count() > 0) {
                                                    $totalRecord = $nilaiAkhirTotal->where("alternatif_id", $item->id)->first();
                                                }
                                            @endphp
                                            @if ($totalRecord && isset($totalRecord->nilai) && $totalRecord->nilai !== null)
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

                        <div class="mt-3 p-4 rounded-lg text-sm text-white"
                            style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                            <h6 class="font-bold mb-2">Formula Nilai Akhir:</h6>
                            <p class="mb-2"><strong>NA<sub>i</sub> = Σ<sub>j=1</sub><sup>n</sup> MT<sub>ij</sub></strong>
                            </p>
                            <ul class="list-disc ml-5">
                                <li>NA<sub>i</sub> = Nilai akhir alternatif ke-i</li>
                                <li>MT<sub>ij</sub> = Matriks ternormalisasi alternatif ke-i pada kriteria ke-j</li>
                                <li>n = Jumlah kriteria @if($kriteria->count() > 0)({{ $kriteria->count() }})@endif</li>
                                <li>Alternatif dengan nilai tertinggi adalah yang terbaik</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Nilai Akhir --}}
        </div>
    </div>
@endsection