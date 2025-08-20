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

            {{-- Alert untuk debugging --}}
                @if(isset($debug) && $debug)
                    <div class="mb-4 rounded-lg p-4 text-sm text-white bg-yellow-500">
                        <strong>Debug Info:</strong><br>
                        Jumlah Alternatif: {{ $alternatif ? $alternatif->count() : 'null' }}<br>
                        Jumlah Kriteria: {{ $kriteria ? $kriteria->count() : 'null' }}<br>
                        Jumlah Matriks Ternormalisasi: {{ $matriksTernormalisasi ? $matriksTernormalisasi->count() : 'null' }}<br>
                        Jumlah Nilai Akhir Total: {{ $nilaiAkhirTotal ? $nilaiAkhirTotal->count() : 'null' }}
                    </div>
                @endif

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
                                        @if($kriteria && $kriteria->count() > 0)
                                            @foreach ($kriteria as $item)
                                                <th class="text-center py-4 px-3 border-r border-gray-600">{{ $item->kriteria }}</th>
                                            @endforeach
                                        @else
                                            <th class="text-center py-4 px-3 border-r border-gray-600">No Criteria Found</th>
                                        @endif
                                        <th class="text-center py-4 px-3">Total Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($alternatif && $alternatif->count() > 0)
                                        @foreach ($alternatif as $item)
                                            <tr class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                                <td class="py-4 px-3 border-r border-gray-200 align-middle text-left">
                                                    <strong>{{ $item->alternatif }}</strong>
                                                </td>

                                                {{-- TAMPILKAN NILAI PER KRITERIA DARI MATRIKS TERNORMALISASI --}}
                                                @if($kriteria && $kriteria->count() > 0)
                                                    @foreach ($kriteria as $krit)
                                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                                            @php
                                                                // Debug: cek data yang tersedia
                                                                $matriksValue = null;

                                                                // Coba beberapa pendekatan untuk mendapatkan nilai
                                                                if (isset($matriksTernormalisasi) && $matriksTernormalisasi && $matriksTernormalisasi->count() > 0) {
                                                                    $matriksValue = $matriksTernormalisasi
                                                                        ->where("alternatif_id", $item->id)
                                                                        ->where("kriteria_id", $krit->id)
                                                                        ->first();
                                                                }

                                                                // Jika tidak ada, coba dari tabel nilai akhir
                                                                if (!$matriksValue && isset($nilaiAkhirTotal) && $nilaiAkhirTotal) {
                                                                    $matriksValue = $nilaiAkhirTotal
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
                                                                {{-- Fallback: tampilkan nilai dummy atau kosong --}}
                                                                <span class="px-2 py-1 rounded-full text-xs text-gray-500 bg-gray-200">
                                                                    0.0000
                                                                </span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                @else
                                                    <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                                        <span class="text-gray-400">No criteria available</span>
                                                    </td>
                                                @endif

                                                {{-- TOTAL NILAI --}}
                                                <td class="py-4 px-3 align-middle text-center">
                                                    @php
                                                        // Hitung total dari nilai yang ada
                                                        $totalNilai = 0;
                                                        $hasData = false;

                                                        // Metode 1: dari nilaiAkhirTotal langsung
                                                        if (isset($nilaiAkhirTotal) && $nilaiAkhirTotal) {
                                                            $totalRecord = $nilaiAkhirTotal->where("alternatif_id", $item->id);
                                                            if ($totalRecord->count() > 0) {
                                                                $totalNilai = $totalRecord->sum("nilai");
                                                                $hasData = true;
                                                            }
                                                        }

                                                        // Metode 2: hitung manual dari matriksTernormalisasi
                                                        if (!$hasData && isset($matriksTernormalisasi) && $matriksTernormalisasi) {
                                                            $nilaiList = $matriksTernormalisasi->where("alternatif_id", $item->id);
                                                            if ($nilaiList->count() > 0) {
                                                                $totalNilai = $nilaiList->sum("nilai");
                                                                $hasData = true;
                                                            }
                                                        }
                                                    @endphp

                                                    @if ($hasData && $totalNilai > 0)
                                                        <span class="px-3 py-2 rounded-full text-sm font-bold text-white"
                                                            style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                                                            {{ number_format($totalNilai, 4) }}
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-2 rounded-full text-sm font-bold text-white bg-gray-400">
                                                            0.0000
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="{{ ($kriteria ? $kriteria->count() : 1) + 2 }}" class="py-8 text-center text-gray-500">
                                                Tidak ada data alternatif yang tersedia
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            {{-- Info Box dengan Formula --}}
                            <div class="mt-3 p-4 rounded-lg text-sm text-white"
                                style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                                <h6 class="font-bold mb-2">Formula Nilai Akhir:</h6>
                                <p class="mb-2"><strong>NA<sub>i</sub> = Σ<sub>j=1</sub><sup>n</sup> (w<sub>j</sub> × u<sub>ij</sub>)</strong></p>
                                <ul class="list-disc ml-5">
                                    <li>NA<sub>i</sub> = Nilai akhir alternatif ke-i</li>
                                    <li>w<sub>j</sub> = Bobot kriteria ke-j (ROC normalization)</li>
                                    <li>u<sub>ij</sub> = Nilai utility alternatif ke-i pada kriteria ke-j</li>
                                    <li>n = Jumlah kriteria @if(isset($kriteria) && $kriteria && $kriteria->count() > 0)({{ $kriteria->count() }})@endif</li>
                                    <li>Alternatif dengan nilai tertinggi adalah yang terbaik</li>
                                </ul>
                            </div>

                            {{-- Debug Info (hanya tampil jika dalam mode debug) --}}
                            @if(config('app.debug', false))
                                <div class="mt-4 p-4 rounded-lg text-sm bg-gray-100 text-gray-700">
                                    <h6 class="font-bold mb-2">Debug Information:</h6>
                                    <ul class="list-disc ml-5 text-xs">
                                        <li>Data alternatif: {{ isset($alternatif) ? ($alternatif ? $alternatif->count() . ' records' : 'null') : 'not set' }}</li>
                                        <li>Data kriteria: {{ isset($kriteria) ? ($kriteria ? $kriteria->count() . ' records' : 'null') : 'not set' }}</li>
                                        <li>Matriks ternormalisasi: {{ isset($matriksTernormalisasi) ? ($matriksTernormalisasi ? $matriksTernormalisasi->count() . ' records' : 'null') : 'not set' }}</li>
                                        <li>Nilai akhir total: {{ isset($nilaiAkhirTotal) ? ($nilaiAkhirTotal ? $nilaiAkhirTotal->count() . ' records' : 'null') : 'not set' }}</li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Akhir Tabel Nilai Akhir --}}
            </div>
        </div>
@endsection