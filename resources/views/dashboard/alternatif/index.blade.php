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
                    { width: "8%", targets: 0 },   // No
                    { width: "12%", targets: 1 },  // Kode
                    { width: "20%", targets: 2 },  // NIK
                    { width: "35%", targets: 3 },  // Nama Alternatif
                    { width: "25%", targets: 4 },  // Aksi
                    { className: "text-center", targets: [0, 1, 2, 4] },
                    { className: "text-left", targets: 3 }
                ],
                autoWidth: false,
            });

            // Real-time validation for all forms
            $(document).on('input', 'input[name="nik"]', function () {
                validateNIK(this);
            });

            $(document).on('input', 'input[name="alternatif"]', function () {
                validateAlternatif(this);
            });

            // Auto focus on first input when modal opens
            $(document).on('change', '#create_button, #edit_button', function () {
                if ($(this).is(':checked')) {
                    setTimeout(() => {
                        $(this).closest('.modal').find('input[name="nik"]').focus();
                    }, 200);
                }
            });
        });

        function create_button() {
            // Reset form
            $("input[name='id']").val("");
            $("input[name='kode']").val("{{ $kode }}");
            $("input[name='nik']").val("{{ $nikSuggestion }}");
            $("input[name='alternatif']").val("");
            $("textarea[name='keterangan']").val("");

            // Reset validation styling
            resetValidation();

            // Auto focus on first input
            setTimeout(() => {
                $("#create_button").closest('.modal').find("input[name='nik']").focus();
            }, 200);
        }

        function show_button(alternatif_id) {
            // Show loading
            showLoadingState('show');

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

                    // Hide loading
                    hideLoadingState('show');
                },
                error: function () {
                    hideLoadingState('show');
                    showNotification('Gagal memuat data alternatif', 'error');
                }
            });
        }

        function edit_button(alternatif_id) {
            // Show loading
            showLoadingState('edit');

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

                    // Hide loading
                    hideLoadingState('edit');

                    // Reset validation
                    resetValidation();

                    // Validate current values
                    validateNIK($("input[name='nik']")[0]);
                    validateAlternatif($("input[name='alternatif']")[0]);
                },
                error: function () {
                    hideLoadingState('edit');
                    showNotification('Gagal memuat data alternatif', 'error');
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
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus data...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

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
                        error: function (xhr) {
                            let message = 'Data gagal dihapus!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                title: 'Gagal!',
                                text: message,
                                icon: 'error',
                                confirmButtonColor: '#6419E6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            })
        }

        // Enhanced validation functions
        function validateNIK(input) {
            const nik = input.value.trim();
            const $input = $(input);
            const $formControl = $input.closest('.form-control');

            // Remove previous validation
            $input.removeClass('input-error input-success border-red-500 border-green-500');
            $formControl.find('.validation-message').remove();

            if (!nik) {
                showValidationError($input, 'NIK wajib diisi');
                return false;
            }

            if (!/^[0-9]+$/.test(nik)) {
                showValidationError($input, 'NIK hanya boleh berisi angka');
                return false;
            }

            if (nik.length !== 16) {
                showValidationError($input, 'NIK harus terdiri dari 16 digit');
                return false;
            }

            showValidationSuccess($input);
            return true;
        }

        function validateAlternatif(input) {
            const value = input.value.trim();
            const $input = $(input);
            const $formControl = $input.closest('.form-control');

            // Remove previous validation
            $input.removeClass('input-error input-success border-red-500 border-green-500');
            $formControl.find('.validation-message').remove();

            if (!value) {
                showValidationError($input, 'Nama alternatif wajib diisi');
                return false;
            }

            if (value.length < 3) {
                showValidationError($input, 'Nama alternatif minimal 3 karakter');
                return false;
            }

            if (value.length > 100) {
                showValidationError($input, 'Nama alternatif maksimal 100 karakter');
                return false;
            }

            showValidationSuccess($input);
            return true;
        }

        // Validation helper functions
        function showValidationError($input, message) {
            $input.addClass('input-error border-red-500');
            const $formControl = $input.closest('.form-control');

            // Remove existing message
            $formControl.find('.validation-message').remove();

            // Add error message
            const errorHtml = `
                        <div class="label validation-message">
                            <span class="label-text-alt text-sm text-red-500">
                                <i class="ri-error-warning-line mr-1"></i>${message}
                            </span>
                        </div>
                    `;
            $formControl.append(errorHtml);
        }

        function showValidationSuccess($input) {
            $input.addClass('input-success border-green-500');
            const $formControl = $input.closest('.form-control');
            $formControl.find('.validation-message').remove();
        }

        function resetValidation() {
            $('.input, .textarea').removeClass('input-error input-success border-red-500 border-green-500');
            $('.validation-message').remove();
        }

        // Loading state functions
        function showLoadingState(type) {
            const loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
            for (let i = 1; i <= 4; i++) {
                $(`#loading_${type}${i}`).html(loading);
            }
        }

        function hideLoadingState(type) {
            for (let i = 1; i <= 4; i++) {
                $(`#loading_${type}${i}`).html('');
            }
        }

        // Enhanced notification
        function showNotification(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} fixed top-4 right-4 w-auto z-50 shadow-lg`;
            toast.innerHTML = `
                        <div class="flex items-center gap-2">
                            <i class="ri-${type === 'error' ? 'error-warning' : 'information'}-line"></i>
                            <span>${message}</span>
                        </div>
                    `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Form submission validation
        $(document).on('submit', 'form', function (e) {
            const form = this;
            let isValid = true;

            // Skip validation for import form
            if ($(form).find('input[name="import_data"]').length > 0) {
                return true;
            }

            // Validate required fields
            $(form).find('input[name="nik"]').each(function () {
                if (!validateNIK(this)) {
                    isValid = false;
                }
            });

            $(form).find('input[name="alternatif"]').each(function () {
                if (!validateAlternatif(this)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                showNotification('Periksa kembali form input Anda', 'error');
                return false;
            }

            // Show loading on submit button
            const $submitBtn = $(form).find('button[type="submit"]');
            const originalText = $submitBtn.html();
            $submitBtn.html('<span class="loading loading-spinner loading-sm"></span> Menyimpan...').prop('disabled', true);

            // Restore button after 3 seconds (fallback)
            setTimeout(() => {
                $submitBtn.html(originalText).prop('disabled', false);
            }, 3000);
        });
    </script>
@endsection

@section("css")<style>
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

        /* ALIGNMENT FIXES - Pastikan semua sel rata tengah dengan padding yang lebih kecil */
        #myTable td,
        #myTable th {
            text-align: center !important;
            vertical-align: middle !important;
            min-height: 50px;
            padding: 12px 8px !important;
        }

        /* Nama Alternatif alignment */
        #myTable td:nth-child(4),
        #myTable th:nth-child(4) {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 12px 8px !important;
        }

        /* Hapus semua div wrapper - langsung styling pada td/th */
        #myTable td>div {
            display: block !important;
            width: 100%;
            text-align: center !important;
        }

        /* Semua div dalam sel rata tengah */
        #myTable td:nth-child(4)>div {
            text-align: center !important;
        }

        /* Pastikan paragraf dalam sel juga mengikuti alignment */
        #myTable td p,
        #myTable th p {
            margin: 0 !important;
            padding: 0 !important;
            text-align: inherit;
            width: 100%;
        }

        /* Pastikan button actions center */
        #myTable td:last-child>div {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Pastikan semua header rata tengah dengan force dan padding konsisten */
        #myTable thead th {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 12px 8px !important;
        }

        /* Pastikan semua teks dalam header rata tengah */
        #myTable thead th * {
            text-align: center !important;
        }

        /* Konsistensi lebar kolom */
        #myTable th:nth-child(1),
        #myTable td:nth-child(1) {
            width: 8%;
        }

        #myTable th:nth-child(2),
        #myTable td:nth-child(2) {
            width: 12%;
        }

        #myTable th:nth-child(3),
        #myTable td:nth-child(3) {
            width: 20%;
        }

        #myTable th:nth-child(4),
        #myTable td:nth-child(4) {
            width: 35%;
        }

        #myTable th:nth-child(5),
        #myTable td:nth-child(5) {
            width: 25%;
        }
    </style>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Alert untuk NIK --}}
            <div class="mb-4 rounded-lg p-4 text-sm text-white" role="alert"
                style="background: linear-gradient(135deg, #3b82f6, #6366f1); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
                <span class="font-medium">Info NIK:</span>
                NIK (Nomor Induk Kependudukan) harus berupa angka dengan panjang tepat 16 digit.
                Pastikan NIK yang dimasukkan valid dan tidak duplikat.
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
                        <form action="{{ route("alternatif.store") }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" name="kode"
                                        class="input input-bordered w-full cursor-default bg-slate-100 text-primary-color"
                                        value="{{ old("kode") }}" required readonly />
                                    @error("kode")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>

                                {{-- NIK --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>NIK</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt text-xs text-gray-500">16 digit</span>
                                    </div>
                                    <input type="text" name="nik" class="input input-bordered w-full text-primary-color"
                                        value="{{ old("nik") }}" maxlength="16" pattern="[0-9]{16}"
                                        placeholder="1234567890123456" required />
                                    @error("nik")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>
                            </div>

                            {{-- Nama Alternatif --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Nama Alternatif</x-label-input-required>
                                    </span>
                                </div>
                                <input type="text" name="alternatif" class="input input-bordered w-full text-primary-color"
                                    value="{{ old("alternatif") }}" placeholder="Contoh: John Doe" required />
                                @error("alternatif")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            {{-- Keterangan --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">Keterangan</span>
                                    <span class="label-text-alt text-xs text-gray-500">Opsional</span>
                                </div>
                                <textarea class="textarea textarea-bordered w-full text-primary-color" name="keterangan"
                                    rows="2" placeholder="Keterangan tambahan...">{{ old("keterangan") }}</textarea>
                                @error("keterangan")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <button type="submit"
                                class="mt-4 w-full text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 hover:opacity-90"
                                style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                                <i class="ri-save-line"></i>
                                Simpan Alternatif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Create --}}

            {{-- Awal Modal Show --}}
            <input type="checkbox" id="show_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box max-w-2xl">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Detail {{ $title }}</h3>
                        <label for="show_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            {{-- Kode --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">Kode</span>
                                    <span class="label-text-alt" id="loading_show1"></span>
                                </div>
                                <input type="text" name="show_kode" class="input input-bordered w-full text-primary-color"
                                    readonly />
                            </label>

                            {{-- NIK --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">NIK</span>
                                    <span class="label-text-alt" id="loading_show2"></span>
                                </div>
                                <input type="text" name="show_nik" class="input input-bordered w-full text-primary-color"
                                    readonly />
                            </label>
                        </div>

                        {{-- Nama Alternatif --}}
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Nama Alternatif</span>
                                <span class="label-text-alt" id="loading_show3"></span>
                            </div>
                            <input type="text" name="show_alternatif" class="input input-bordered w-full text-primary-color"
                                readonly />
                        </label>

                        {{-- Keterangan --}}
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Keterangan</span>
                                <span class="label-text-alt" id="loading_show4"></span>
                            </div>
                            <textarea class="textarea textarea-bordered w-full text-primary-color" name="show_keterangan"
                                rows="2" readonly></textarea>
                        </label>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Show --}}

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
                        <form action="{{ route("alternatif.update") }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" name="kode"
                                        class="input input-bordered w-full cursor-default bg-slate-100 text-primary-color"
                                        required readonly />
                                    @error("kode")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>

                                {{-- NIK --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>NIK</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt" id="loading_edit2"></span>
                                    </div>
                                    <input type="text" name="nik" class="input input-bordered w-full text-primary-color"
                                        maxlength="16" pattern="[0-9]{16}" required />
                                    @error("nik")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>
                            </div>

                            {{-- Nama Alternatif --}}
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

                            {{-- Keterangan --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">Keterangan</span>
                                    <span class="label-text-alt" id="loading_edit4"></span>
                                </div>
                                <textarea class="textarea textarea-bordered w-full text-primary-color" name="keterangan"
                                    rows="2"></textarea>
                                @error("keterangan")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <button type="submit" class="btn btn-warning mt-4 w-full text-white">
                                <i class="ri-refresh-line"></i>
                                Perbarui Alternatif
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
                            Kolom yang diperlukan: kode, nik, alternatif, keterangan
                        </div>
                        <form action="{{ route("alternatif.import") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>File Excel</x-label-input-required>
                                    </span>
                                </div>
                                <input type="file" name="import_data" accept=".xlsx,.xls"
                                    class="file-input file-input-bordered w-full text-primary-color" required />
                                @error("import_data")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
                            <button type="submit"
                                class="mt-4 w-full text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 hover:opacity-90"
                                style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);">
                                <i class="ri-upload-line"></i>
                                Simpan Data Import
                            </button>
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
                    <div class="flex gap-2">
                        <label for="create_button"
                            class="mb-0 inline-block cursor-pointer rounded-lg px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-white shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2"
                            onclick="return create_button()"
                            style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                            <i class="ri-add-fill"></i>
                            Tambah
                        </label>
                        <label for="import_button"
                            class="mb-0 inline-block cursor-pointer rounded-lg px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-white shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2"
                            style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                            <i class="ri-file-excel-2-line"></i>
                            Impor
                        </label>
                    </div>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable"
                            class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top text-center"
                            style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="text-xs font-bold uppercase text-white text-center"
                                    style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                                    <th class="rounded-tl text-center py-4 px-3 border-r border-gray-600">No.</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Kode</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">NIK</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Nama Alternatif</th>
                                    <th class="rounded-tr text-center py-4 px-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $key => $item)
                                    <tr class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                        <!-- No. -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            {{ $key + 1 }}.
                                        </td>

                                        <!-- Kode -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            {{ $item->kode }}
                                        </td>

                                        <!-- NIK -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-white break-all"
                                                style="background: linear-gradient(135deg, #3b82f6, #6366f1);">
                                                {{ $item->nik }}
                                            </span>
                                        </td>

                                        <!-- Nama Alternatif -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            {{ $item->alternatif }}
                                        </td>

                                        <!-- Aksi -->
                                        <td class="py-4 px-3 align-middle text-center">
                                            <label for="show_button"
                                                class="px-3 py-2 rounded-lg text-white font-semibold cursor-pointer transition-all duration-200 hover:opacity-90 text-sm inline-flex items-center mr-2"
                                                onclick="return show_button('{{ $item->id }}')"
                                                style="background: linear-gradient(135deg, #06b6d4, #0891b2); box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);">
                                                <i class="ri-eye-line text-base"></i>
                                            </label>
                                            <label for="edit_button"
                                                class="px-3 py-2 rounded-lg text-white font-semibold cursor-pointer transition-all duration-200 hover:opacity-90 text-sm inline-flex items-center mr-2"
                                                onclick="return edit_button('{{ $item->id }}')"
                                                style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                                                <i class="ri-pencil-line text-base"></i>
                                            </label>
                                            <label for="delete_button"
                                                class="px-3 py-2 rounded-lg text-white font-semibold cursor-pointer transition-all duration-200 hover:opacity-90 text-sm inline-flex items-center"
                                                onclick="return delete_button('{{ $item->id }}')"
                                                style="background: linear-gradient(135deg, #e11d48, #be185d); box-shadow: 0 4px 15px rgba(225, 29, 72, 0.3);">
                                                <i class="ri-delete-bin-line text-base"></i>
                                            </label>
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