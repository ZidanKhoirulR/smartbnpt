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

        function create_button() {
            $("input[name='id']").val("");
            $("input[name='kriteria']").val("");
            $("input[name='bobot']").val("");
            $("input[name='ranking']").val("");
                $("input[name='kode']").val("{{ $kode }}");

                // Reset radio buttons
                $("input[name='jenis_kriteria']").prop('checked', false);
                $("#benefit_create").prop("checked", true);
            }

            function edit_button(kriteria_id) {
                // Loading effect start
                let loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
                $("#loading_edit1").html(loading);
                $("#loading_edit2").html(loading);
                $("#loading_edit3").html(loading);
                $("#loading_edit4").html(loading);
                $("#loading_edit5").html(loading);

                $.ajax({
                    type: "get",
                    url: "{{ route("kriteria.edit") }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "kriteria_id": kriteria_id
                    },
                    success: function(data) {
                        // console.log(data.data);

                        $("input[name='id']").val(data.data.id);
                        $("input[name='kode']").val(data.data.kode);
                        $("input[name='kriteria']").val(data.data.kriteria);
                        $("input[name='bobot']").val(data.data.bobot);
                        $("input[name='ranking']").val(data.data.ranking || '');

                        if (data.data.jenis_kriteria == "benefit") {
                            $("#benefit_edit").prop("checked", true);
                        } else if (data.data.jenis_kriteria == "cost") {
                            $("#cost_edit").prop("checked", true);
                        }

                        // Loading effect end
                        loading = "";
                        $("#loading_edit1").html(loading);
                        $("#loading_edit2").html(loading);
                        $("#loading_edit3").html(loading);
                        $("#loading_edit4").html(loading);
                        $("#loading_edit5").html(loading);
                    }
                });
            }

            function delete_button(kriteria_id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dipulihkan kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#6419E6',
                    cancelButtonColor: '#F87272',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "{{ route("kriteria.delete") }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "kriteria_id": kriteria_id
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Data berhasil dihapus!',
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
                                    title: 'Data gagal dihapus!',
                                    icon: 'error',
                                    confirmButtonColor: '#6419E6',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                })
            }

            // Validasi ranking secara real-time
            function validateRanking(input) {
                const value = parseInt(input.value);
                const maxRanking = {{ $kriteria->count() + 1 }}; // +1 untuk kriteria baru

                if (value < 1) {
                    input.setCustomValidity('Ranking minimal adalah 1');
                } else if (value > maxRanking) {
                    input.setCustomValidity(`Ranking maksimal adalah ${maxRanking}`);
                } else {
                    input.setCustomValidity('');
                }
            }
        </script>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Alert untuk ranking --}}
            <div class="mb-4 rounded-lg bg-blue-50 p-4 text-sm text-blue-800 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <span class="font-medium">Info Ranking:</span> 
                Ranking menentukan tingkat kepentingan kriteria (1 = Paling Penting, 2 = Kedua Paling Penting, dst). 
                Pastikan tidak ada ranking yang duplikat dan berurutan mulai dari 1.
            </div>

            {{-- Awal Modal Create --}}
            <input type="checkbox" id="create_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box max-w-2xl">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Tambah {{ $title }}</h3>
                        <label for="create_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <form action="{{ route("kriteria.store") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" hidden>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                {{-- Kode --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Kode</x-label-input-required>
                                        </span>
                                    </div>
                                    <input type="text" name="kode" class="input input-bordered w-full cursor-default bg-slate-100 text-primary-color" value="{{ old("kode") }}" required readonly />
                                    @error("kode")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>

                                {{-- Ranking Kepentingan --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Ranking Kepentingan</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt text-xs text-gray-500">1 = Paling Penting</span>
                                    </div>
                                    <input type="number" min="1" max="{{ $kriteria->count() + 1 }}" step="1" name="ranking" 
                                           class="input input-bordered w-full text-primary-color" 
                                           value="{{ old("ranking") }}" 
                                           oninput="validateRanking(this)"
                                           placeholder="1, 2, 3, ..." required />
                                    @error("ranking")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>
                            </div>

                            {{-- Kriteria --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Nama Kriteria</x-label-input-required>
                                    </span>
                                </div>
                                <input type="text" name="kriteria" class="input input-bordered w-full text-primary-color" value="{{ old("kriteria") }}" placeholder="Contoh: Pendapatan per Bulan" required />
                                @error("kriteria")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                {{-- Bobot --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Bobot (%)</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt text-xs text-gray-500">Untuk analisis tambahan</span>
                                    </div>
                                    <input type="number" min="0" max="100" step="0.01" name="bobot" class="input input-bordered w-full text-primary-color" value="{{ old("bobot") }}" placeholder="0-100" required />
                                    @error("bobot")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>

                                {{-- Jenis Kriteria --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Jenis Kriteria</x-label-input-required>
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="form-control">
                                            <label class="label cursor-pointer justify-start gap-2">
                                                <input type="radio" value="cost" name="jenis_kriteria" class="radio-primary radio" />
                                                <span class="label-text">Cost</span>
                                            </label>
                                            <p class="text-xs text-gray-500">Semakin kecil semakin baik</p>
                                        </div>
                                        <div class="form-control">
                                            <label class="label cursor-pointer justify-start gap-2">
                                                <input type="radio" value="benefit" name="jenis_kriteria" id="benefit_create" class="radio-primary radio" checked />
                                                <span class="label-text">Benefit</span>
                                            </label>
                                            <p class="text-xs text-gray-500">Semakin besar semakin baik</p>
                                        </div>
                                    </div>
                                    @error("jenis_kriteria")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success mt-4 w-full text-white">
                                <i class="ri-save-line"></i>
                                Simpan Kriteria
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Create --}}

            {{-- Awal Modal Edit --}}
            <input type="checkbox" id="edit_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box max-w-2xl">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Ubah {{ $title }}</h3>
                        <label for="edit_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <form action="{{ route("kriteria.update") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" hidden>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                {{-- Kode --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Kode</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt" id="loading_edit1"></span>
                                    </div>
                                    <input type="text" name="kode" class="input input-bordered w-full cursor-default bg-slate-100 text-primary-color" required readonly />
                                    @error("kode")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>

                                {{-- Ranking Kepentingan --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Ranking Kepentingan</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt" id="loading_edit5"></span>
                                    </div>
                                    <input type="number" min="1" max="{{ $kriteria->count() }}" step="1" name="ranking" 
                                           class="input input-bordered w-full text-primary-color" 
                                           oninput="validateRanking(this)"
                                           placeholder="1, 2, 3, ..." required />
                                    @error("ranking")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>
                            </div>

                            {{-- Kriteria --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Nama Kriteria</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit2"></span>
                                </div>
                                <input type="text" name="kriteria" class="input input-bordered w-full text-primary-color" required />
                                @error("kriteria")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                {{-- Bobot --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Bobot (%)</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt" id="loading_edit3"></span>
                                    </div>
                                    <input type="number" min="0" max="100" step="0.01" name="bobot" class="input input-bordered w-full text-primary-color" required />
                                    @error("bobot")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>

                                {{-- Jenis Kriteria --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Jenis Kriteria</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt" id="loading_edit4"></span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="form-control">
                                            <label class="label cursor-pointer justify-start gap-2">
                                                <input type="radio" value="cost" name="jenis_kriteria" id="cost_edit" class="radio-primary radio" />
                                                <span class="label-text">Cost</span>
                                            </label>
                                            <p class="text-xs text-gray-500">Semakin kecil semakin baik</p>
                                        </div>
                                        <div class="form-control">
                                            <label class="label cursor-pointer justify-start gap-2">
                                                <input type="radio" value="benefit" name="jenis_kriteria" id="benefit_edit" class="radio-primary radio" />
                                                <span class="label-text">Benefit</span>
                                            </label>
                                            <p class="text-xs text-gray-500">Semakin besar semakin baik</p>
                                        </div>
                                    </div>
                                    @error("jenis_kriteria")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>
                            </div>

                            <button type="submit" class="btn btn-warning mt-4 w-full text-white">
                                <i class="ri-refresh-line"></i>
                                Perbarui Kriteria
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Edit --}}

            {{-- Awal Modal Import --}}
            <input type="checkbox" id="import_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Impor {{ $title }}</h3>
                        <label for="import_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <div class="mb-4 rounded-lg bg-yellow-50 p-4 text-sm text-yellow-800" role="alert">
                            <span class="font-medium">Format Excel:</span> 
                            Kolom yang diperlukan: kriteria, bobot, jenis_kriteria, ranking
                        </div>
                        <form action="{{ route("kriteria.import") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>File Excel</x-label-input-required>
                                    </span>
                                </div>
                                <input type="file" name="import_data" accept=".xlsx,.xls" class="file-input file-input-bordered w-full text-primary-color" required />
                                @error("import_data")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
                            <button type="submit" class="btn btn-success mt-3 w-full text-white">
                                <i class="ri-upload-line"></i>
                                Simpan Data Import
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Import --}}

            {{-- Awal Tabel Kriteria --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel {{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        <label for="create_button" class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return create_button()">
                            <i class="ri-add-fill"></i>
                            Tambah
                        </label>
                        <label for="import_button" class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return import_button()">
                            <i class="ri-file-excel-2-line"></i>
                            Impor
                        </label>
                    </div>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-primary-color text-xs font-bold uppercase text-white dark:bg-primary-color-dark dark:text-white">
                                    <th class="rounded-tl">No.</th>
                                    <th>Kode</th>
                                    <th>Ranking</th>
                                    <th>Nama Kriteria</th>
                                    <th>Bobot (%)</th>
                                    <th>Jenis</th>
                                    <th class="rounded-tr">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria->sortBy('ranking') as $value => $item)
                                    <tr class="border-b border-primary-color bg-transparent dark:border-primary-color-dark">
                                        <td>
                                            <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                {{ $value + 1 }}.
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                {{ $item->kode }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="flex items-center justify-center">
                                                <span class="badge badge-primary badge-sm">
                                                    {{ $item->ranking ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-left align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                {{ $item->kriteria }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                {{ $item->bobot }}%
                                            </p>
                                        </td>
                                        <td>
                                            <div class="flex justify-center">
                                                @if($item->jenis_kriteria == 'benefit')
                                                    <span class="badge badge-success badge-sm">BENEFIT</span>
                                                @else
                                                    <span class="badge badge-warning badge-sm">COST</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center align-middle">
                                                <label for="edit_button" class="btn btn-outline btn-warning btn-sm" onclick="return edit_button('{{ $item->id }}')">
                                                    <i class="ri-pencil-line text-base"></i>
                                                </label>
                                                <label for="delete_button" class="btn btn-outline btn-error btn-sm" onclick="return delete_button('{{ $item->id }}')">
                                                    <i class="ri-delete-bin-line text-base"></i>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td colspan="4" class="text-right align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                        Total Bobot:
                                    </td>
                                    <td class="text-center align-middle text-base font-bold leading-tight text-primary-color dark:text-primary-color-dark">
                                        {{ $sumBobot }}%
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Kriteria --}}
        </div>
    </div>
@endsection