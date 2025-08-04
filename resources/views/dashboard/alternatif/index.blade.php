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
                columnDefs: [
                    { width: "10%", targets: 0 }, // Kode
                    { width: "20%", targets: 1 }, // NIK
                    { width: "45%", targets: 2 }, // Nama Alternatif
                    { width: "25%", targets: 3 }, // Aksi
                    { className: "text-center", targets: [0, 1, 3] },
                    { className: "text-left", targets: 2 }
                ],
                autoWidth: false,
            });
        });

        function create_button() {
            $("input[name='id']").val("");
            $("input[name='kode']").val("{{ $kode }}");
            $("input[name='nik']").val("{{ $nikSuggestion }}");
            $("input[name='alternatif']").val("");
            $("textarea[name='keterangan']").val("");
        }

        function show_button(alternatif_id) {
            // Loading effect start
            let loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
            $("#loading_show1").html(loading);
            $("#loading_show2").html(loading);
            $("#loading_show3").html(loading);
            $("#loading_show4").html(loading);

            $.ajax({
                type: "get",
                url: "{{ route("alternatif.edit") }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "alternatif_id": alternatif_id
                },
                success: function (data) {
                    $("input[name='show_kode']").val(data.data.kode);
                    $("input[name='show_nik']").val(data.data.nik);
                    $("input[name='show_alternatif']").val(data.data.alternatif);
                    $("textarea[name='show_keterangan']").val(data.data.keterangan);

                    // Loading effect end
                    loading = "";
                    $("#loading_show1").html(loading);
                    $("#loading_show2").html(loading);
                    $("#loading_show3").html(loading);
                    $("#loading_show4").html(loading);
                }
            });
        }

        function edit_button(alternatif_id) {
            // Loading effect start
            let loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
            $("#loading_edit1").html(loading);
            $("#loading_edit2").html(loading);
            $("#loading_edit3").html(loading);
            $("#loading_edit4").html(loading);

            $.ajax({
                type: "get",
                url: "{{ route("alternatif.edit") }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "alternatif_id": alternatif_id
                },
                success: function (data) {
                    $("input[name='id']").val(data.data.id);
                    $("input[name='kode']").val(data.data.kode);
                    $("input[name='nik']").val(data.data.nik);
                    $("input[name='alternatif']").val(data.data.alternatif);
                    $("textarea[name='keterangan']").val(data.data.keterangan);

                    // Loading effect end
                    loading = "";
                    $("#loading_edit1").html(loading);
                    $("#loading_edit2").html(loading);
                    $("#loading_edit3").html(loading);
                    $("#loading_edit4").html(loading);
                }
            });
        }

        function delete_button(alternatif_id) {
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
                        url: "{{ route("alternatif.delete") }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "alternatif_id": alternatif_id
                        },
                        success: function (response) {
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
                        error: function (response) {
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

        // Validasi NIK real-time
        function validateNIK(input) {
            let nik = input.value;
            let feedback = input.parentNode.querySelector('.nik-feedback');

            // Remove existing feedback
            if (feedback) {
                feedback.remove();
            }

            // Create new feedback element
            feedback = document.createElement('div');
            feedback.className = 'label nik-feedback';

            if (nik.length > 0) {
                if (!/^[0-9]+$/.test(nik)) {
                    feedback.innerHTML = '<span class="label-text-alt text-sm text-error">NIK hanya boleh berisi angka</span>';
                    input.parentNode.appendChild(feedback);
                } else if (nik.length !== 16) {
                    feedback.innerHTML = '<span class="label-text-alt text-sm text-error">NIK harus terdiri dari 16 digit</span>';
                    input.parentNode.appendChild(feedback);
                } else {
                    feedback.innerHTML = '<span class="label-text-alt text-sm text-success">NIK valid</span>';
                    input.parentNode.appendChild(feedback);
                }
            }
        }
    </script>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Awal Modal Create --}}
            <input type="checkbox" id="create_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Tambah {{ $title }}</h3>
                        <label for="create_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <form action="{{ route("alternatif.store") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" hidden>

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Kode</x-label-input-required>
                                    </span>
                                </div>
                                <input type="text" name="kode"
                                    class="input input-bordered w-full cursor-default bg-slate-100 text-primary-color"
                                    value="{{ old("kode") }}" required readonly />
                                @error("kode")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>NIK</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit1"></span>
                                </div>
                                <input type="text" name="nik" class="input input-bordered w-full text-primary-color"
                                    value="{{ old("nik") }}" maxlength="16" pattern="[0-9]{16}" oninput="validateNIK(this)"
                                    required />
                                @error("nik")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Nama Alternatif</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit2"></span>
                                </div>
                                <input type="text" name="alternatif" class="input input-bordered w-full text-primary-color"
                                    value="{{ old("alternatif") }}" required />
                                @error("alternatif")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <span>Keterangan</span>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit3"></span>
                                </div>
                                <textarea class="textarea textarea-bordered w-full text-primary-color"
                                    name="keterangan">{{ old("keterangan") }}</textarea>
                                @error("keterangan")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <button type="submit" class="btn btn-success mt-3 w-full text-white">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Create --}}

            {{-- Awal Modal Show --}}
            <input type="checkbox" id="show_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Detail {{ $title }}</h3>
                        <label for="show_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Kode</span>
                                <span class="label-text-alt" id="loading_show1"></span>
                            </div>
                            <input type="text" name="show_kode" class="input input-bordered w-full text-primary-color"
                                readonly />
                        </label>

                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">NIK</span>
                                <span class="label-text-alt" id="loading_show2"></span>
                            </div>
                            <input type="text" name="show_nik" class="input input-bordered w-full text-primary-color"
                                readonly />
                        </label>

                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Nama Alternatif</span>
                                <span class="label-text-alt" id="loading_show3"></span>
                            </div>
                            <input type="text" name="show_alternatif" class="input input-bordered w-full text-primary-color"
                                readonly />
                        </label>

                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Keterangan</span>
                                <span class="label-text-alt" id="loading_show4"></span>
                            </div>
                            <textarea class="textarea textarea-bordered w-full text-primary-color" name="show_keterangan"
                                readonly></textarea>
                        </label>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Show --}}

            {{-- Awal Modal Edit --}}
            <input type="checkbox" id="edit_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Ubah {{ $title }}</h3>
                        <label for="edit_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <form action="{{ route("alternatif.update") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" hidden>

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Kode</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit1"></span>
                                </div>
                                <input type="text" name="kode"
                                    class="input input-bordered w-full cursor-default bg-slate-100 text-primary-color"
                                    required readonly />
                                @error("kode")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>NIK</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit2"></span>
                                </div>
                                <input type="text" name="nik" class="input input-bordered w-full text-primary-color"
                                    maxlength="16" pattern="[0-9]{16}" oninput="validateNIK(this)" required />
                                @error("nik")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Nama Alternatif</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit3"></span>
                                </div>
                                <input type="text" name="alternatif" class="input input-bordered w-full text-primary-color"
                                    required />
                                @error("alternatif")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">Keterangan</span>
                                    <span class="label-text-alt" id="loading_edit4"></span>
                                </div>
                                <textarea class="textarea textarea-bordered w-full text-primary-color"
                                    name="keterangan"></textarea>
                                @error("keterangan")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <button type="submit" class="btn btn-warning mt-3 w-full text-white">Perbarui</button>
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
                        <form action="{{ route("alternatif.import") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>File Excel</x-label-input-required>
                                    </span>
                                </div>
                                <input type="file" name="import_data"
                                    class="file-input file-input-bordered w-full text-primary-color" required />
                                <div class="label">
                                    <span class="label-text-alt text-xs text-gray-500">Format: kode, nik, alternatif,
                                        keterangan</span>
                                </div>
                                @error("import_data")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
                            <button type="submit" class="btn btn-success mt-3 w-full text-white">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Import --}}

            {{-- Awal Tabel Alternatif --}}
            <div
                class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div
                    class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel {{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        <label for="create_button"
                            class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2"
                            onclick="return create_button()">
                            <i class="ri-add-fill"></i>
                            Tambah
                        </label>
                        <label for="import_button"
                            class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2">
                            <i class="ri-file-excel-2-line"></i>
                            Impor
                        </label>
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
                                    <th class="rounded-tl w-20">Kode</th>
                                    <th class="w-32">NIK</th>
                                    <th class="w-auto">Nama Alternatif</th>
                                    <th class="rounded-tr w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $item)
                                    <tr class="border-b border-primary-color bg-transparent dark:border-primary-color-dark">
                                        <td class="w-20">
                                            <p
                                                class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                {{ $item->kode }}
                                            </p>
                                        </td>
                                        <td class="w-32">
                                            <p
                                                class="text-center align-middle text-sm font-medium leading-tight text-primary-color dark:text-primary-color-dark break-all">
                                                {{ $item->nik }}
                                            </p>
                                        </td>
                                        <td class="w-auto min-w-0">
                                            <p
                                                class="text-left align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark px-2">
                                                {{ $item->alternatif }}
                                            </p>
                                        </td>
                                        <td class="w-32">
                                            <div class="text-center align-middle space-x-1">
                                                <label for="show_button" class="btn btn-outline btn-info btn-sm"
                                                    onclick="return show_button('{{ $item->id }}')">
                                                    <i class="ri-eye-line text-base"></i>
                                                </label>
                                                <label for="edit_button" class="btn btn-outline btn-warning btn-sm"
                                                    onclick="return edit_button('{{ $item->id }}')">
                                                    <i class="ri-pencil-fill text-base"></i>
                                                </label>
                                                <label for="delete_button" class="btn btn-outline btn-error btn-sm"
                                                    onclick="return delete_button('{{ $item->id }}')">
                                                    <i class="ri-delete-bin-line text-base"></i>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Alternatif --}}
        </div>
    </div>
@endsection