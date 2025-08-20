@extends("dashboard.layouts.main")

@section("js")
    <script>
        $(document).ready(function () {
            @foreach ($kriteria as $item)
                $('#myTable_{{ $item->id }}').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr',
                        },
                    },
                    order: [],
                    pagingType: 'full_numbers',
                });
            @endforeach

            // Real-time validation for all forms
            $(document).on('input', 'input[name="sub_kriteria"]', function () {
                validateSubKriteria(this);
            });

            $(document).on('input', 'input[name="bobot"]', function () {
                validateBobot(this);
                updateWeightInfo();
            });

            $(document).on('change', 'select[name="kriteria_id"]', function () {
                validateKriteria(this);
            });

            // Auto-calculate weight info on modal open
            $('#create_sub_kriteria, #edit_sub_kriteria').on('change', function () {
                if ($(this).is(':checked')) {
                    setTimeout(() => {
                        updateWeightInfo();
                    }, 100);
                }
            });
        });

        function create_button() {
            // Reset form
            $('#create_sub_kriteria_form')[0].reset();
            $("input[name='id']").val("");

            // Reset validation styling
            resetValidation();

            // Auto focus on first select
            setTimeout(() => {
                $("#create_sub_kriteria").closest('.modal').find("select[name='kriteria_id']").focus();
            }, 200);
        }

        function edit_button(id) {
            // Reset form dan show loading
            resetValidation();
            showLoadingState();

            // Ambil data sub kriteria berdasarkan ID
            $.ajax({
                type: "GET",
                url: "{{ route('sub-kriteria.edit') }}",
                data: {
                    "sub_kriteria_id": id  // Fix parameter name
                },
                timeout: 10000, // 10 second timeout
                success: function (response) {
                    console.log('Response:', response); // Debug log

                    // Populate form - fix selector untuk modal edit
                    $("#edit_sub_kriteria_form input[name='id']").val(response.id);
                    $("#edit_sub_kriteria_form input[name='kriteria_id']").val(response.kriteria_id);
                    $("#edit_sub_kriteria_form input[name='kriteria_nama']").val(response.kriteria ? response.kriteria.kriteria : '');
                    $("#edit_sub_kriteria_form input[name='sub_kriteria']").val(response.sub_kriteria);
                    $("#edit_sub_kriteria_form input[name='bobot']").val(response.bobot);

                    // Simpan bobot asli untuk perhitungan weight info
                    $("#edit_sub_kriteria_form input[name='bobot']").data('original', response.bobot);

                    // Hide loading
                    hideLoadingState();

                    // Reset validation and update weight info
                    resetValidation();
                    updateWeightInfo();

                    // Validate current values
                    validateSubKriteria($("#edit_sub_kriteria_form input[name='sub_kriteria']")[0]);
                    validateBobot($("#edit_sub_kriteria_form input[name='bobot']")[0]);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', xhr.responseText); // Debug log
                    hideLoadingState();

                    let errorMessage = 'Gagal memuat data sub kriteria';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (status === 'timeout') {
                        errorMessage = 'Request timeout - server terlalu lama merespon';
                    }

                    showNotification(errorMessage, 'error');
                }
            });
        }

        function delete_button(id) {
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
                        type: "POST",
                        url: "{{ route('sub-kriteria.delete') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "sub_kriteria_id": id  // Fix parameter name
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
            });
        }

        // Validation functions
        function validateSubKriteria(input) {
            const value = input.value.trim();
            const $input = $(input);
            const $formControl = $input.closest('.form-control');

            // Remove previous validation
            $input.removeClass('input-error input-success border-red-500 border-green-500');
            $formControl.find('.validation-message').remove();

            if (!value) {
                showValidationError($input, 'Nama sub kriteria wajib diisi');
                return false;
            }

            if (value.length < 3) {
                showValidationError($input, 'Nama sub kriteria minimal 3 karakter');
                return false;
            }

            if (value.length > 100) {
                showValidationError($input, 'Nama sub kriteria maksimal 100 karakter');
                return false;
            }

            showValidationSuccess($input);
            return true;
        }

        function validateBobot(input) {
            const value = parseFloat(input.value);
            const $input = $(input);
            const $formControl = $input.closest('.form-control');

            // Remove previous validation
            $input.removeClass('input-error input-success border-red-500 border-green-500');
            $formControl.find('.validation-message').remove();

            if (!input.value.trim()) {
                showValidationError($input, 'Bobot wajib diisi');
                return false;
            }

            if (isNaN(value) || value < 0) {
                showValidationError($input, 'Bobot minimal adalah 0');
                return false;
            }

            if (value > 100) {
                showValidationError($input, 'Bobot maksimal adalah 100%');
                return false;
            }

                      showValidationSuccess($input);
            return true;
        }

        function validateKriteria(input) {
            const value = input.value;
            const $input = $(input);
            const $formControl = $input.closest('.form-control');

            // Remove previous validation
            $input.removeClass('input-error input-success border-red-500 border-green-500');
            $formControl.find('.validation-message').remove();

            if (!value) {
                showValidationError($input, 'Kriteria wajib dipilih');
                return false;
            }

            showValidationSuccess($input);
            return true;
        }

        // Helper function to get current total weight for a criteria
        function getCurrentKriteriaTotal(kriteriaId) {
            let total = 0;
            @foreach($kriteria as $kri)
                @if($subKriteria->where('kriteria_id', $kri->id)->count() > 0)
                    if ('{{ $kri->id }}' == kriteriaId) {
                        @foreach($subKriteria->where('kriteria_id', $kri->id) as $sub)
                            total += {{ $sub->bobot }};
                        @endforeach
                    }
                @endif
            @endforeach
            return total;
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
            $('.input, .select').removeClass('input-error input-success border-red-500 border-green-500');
            $('.validation-message').remove();
        }

        // Loading state functions
        function showLoadingState() {
            const loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
            for (let i = 1; i <= 3; i++) {
                $(`#loading_edit${i}`).html(loading);
            }
        }

        function hideLoadingState() {
            for (let i = 1; i <= 3; i++) {
                $(`#loading_edit${i}`).html('');
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

            // Validate all required fields
            $(form).find('input[required], select[required]').each(function () {
                if (this.name === 'sub_kriteria' && !validateSubKriteria(this)) {
                    isValid = false;
                }
                if (this.name === 'bobot' && !validateBobot(this)) {
                    isValid = false;
                }
                if (this.name === 'kriteria_id' && !validateKriteria(this)) {
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

@section("css")
<style>
    .table-container {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .table-container thead th:first-child {
        border-top-left-radius: 12px;
    }

    .table-container thead th:last-child {
        border-top-right-radius: 12px;
    }

    .table-container tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.01);
        transition: all 0.2s ease;
    }

    /* ALIGNMENT FIXES - Pastikan semua sel rata tengah dengan padding yang lebih kecil */
    .table-container td,
    .table-container th {
        text-align: center !important;
        vertical-align: middle !important;
        min-height: 50px;
        padding: 12px 8px !important;
    }

    /* Semua kolom rata tengah */
    .table-container td>div {
        display: block !important;
        width: 100%;
        text-align: center !important;
    }

    /* Pastikan paragraf dalam sel juga mengikuti alignment */
    .table-container td p,
    .table-container th p {
        margin: 0 !important;
        padding: 0 !important;
        text-align: center !important;
        width: 100%;
    }

    /* Pastikan span badge center */
    .table-container td span {
        display: inline-block;
        text-align: center;
    }

    /* Pastikan button actions center */
    .table-container td:last-child>div {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    /* Pastikan semua header rata tengah dengan force dan padding konsisten */
    .table-container thead th {
        text-align: center !important;
        vertical-align: middle !important;
        padding: 12px 8px !important;
    }

    /* Pastikan semua teks dalam header rata tengah */
    .table-container thead th * {
        text-align: center !important;
    }

    /* Footer alignment */
    .table-container tfoot td {
        vertical-align: middle !important;
    }

    /* Total Bobot text alignment */
    .table-container tfoot td[colspan] {
        text-align: right !important;
    }

    /* Nilai total bobot alignment */
    .table-container tfoot td.total-value {
        text-align: center !important;
    }
</style>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Alert untuk sub kriteria --}}
            <div class="mb-4 rounded-lg p-4 text-sm text-white" role="alert"
                style="background: linear-gradient(135deg, #3b82f6, #6366f1); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
                <span class="font-medium">Info Sub Kriteria:</span>
                Sub kriteria digunakan untuk memberikan nilai detail pada setiap kriteria utama.
                Pastikan bobot sub kriteria sesuai dengan tingkat kepentingannya dan total bobot per kriteria tidak melebihi
                100%.
            </div>

            {{-- Awal Modal Create --}}
            <input type="checkbox" id="create_sub_kriteria" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box max-w-2xl">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Tambah {{ $title }}</h3>
                        <label for="create_sub_kriteria" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <form id="create_sub_kriteria_form" action="{{ route('sub-kriteria.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id">

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                {{-- Kriteria --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Kriteria</x-label-input-required>
                                        </span>
                                    </div>
                                    <select name="kriteria_id" class="select select-bordered w-full text-primary-color"
                                        required>
                                        <option value="" disabled selected>Pilih Kriteria!</option>
                                        @foreach ($kriteria as $item)
                                            <option value="{{ $item->id }}" {{ old('kriteria_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->kriteria }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kriteria_id')
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>

                                {{-- Bobot --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Bobot (%)</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt text-xs text-gray-500">Nilai numerik untuk
                                            perhitungan</span>
                                    </div>
                                    <input type="number" min="0" max="100" step="0.01" name="bobot"
                                        class="input input-bordered w-full text-primary-color" value="{{ old('bobot') }}"
                                        placeholder="0-100" required />
                                    @error('bobot')
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>
                            </div>

                            {{-- Sub Kriteria --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Sub Kriteria</x-label-input-required>
                                    </span>
                                </div>
                                <input type="text" name="sub_kriteria"
                                    class="input input-bordered w-full text-primary-color" value="{{ old('sub_kriteria') }}"
                                    placeholder="Contoh: Sangat Baik, Baik, Cukup" required />
                                @error('sub_kriteria')
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <button type="submit"
                                class="mt-4 w-full text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 hover:opacity-90"
                                style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                                <i class="ri-save-line"></i>
                                Simpan Sub Kriteria
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Create --}}

            {{-- Awal Modal Edit --}}
            <input type="checkbox" id="edit_sub_kriteria" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box max-w-2xl">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Ubah {{ $title }}</h3>
                        <label for="edit_sub_kriteria" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <form id="edit_sub_kriteria_form" action="{{ route('sub-kriteria.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id">
                            <input type="hidden" name="kriteria_id">

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                {{-- Kriteria (read-only) --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            Kriteria
                                        </span>
                                        <span class="label-text-alt" id="loading_edit1"></span>
                                    </div>
                                    <input type="text" name="kriteria_nama"
                                        class="input input-bordered w-full cursor-default bg-slate-100 text-primary-color"
                                        readonly />
                                </label>

                                {{-- Bobot --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>Bobot (%)</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt" id="loading_edit2"></span>
                                    </div>
                                    <input type="number" min="0" max="100" step="0.01" name="bobot"
                                        class="input input-bordered w-full text-primary-color" required />
                                    @error('bobot')
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>
                            </div>

                            {{-- Sub Kriteria --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Sub Kriteria</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit3"></span>
                                </div>
                                <input type="text" name="sub_kriteria"
                                    class="input input-bordered w-full text-primary-color" required />
                                @error('sub_kriteria')
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <button type="submit"
                                class="mt-4 w-full text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 hover:opacity-90"
                                style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                                <i class="ri-refresh-line"></i>
                                Perbarui Sub Kriteria
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Edit --}}

            {{-- Tabel Sub Kriteria --}}
            @foreach ($kriteria as $kri)
                <div
                    class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                    <div
                        class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                        <h6 class="font-bold text-primary-color dark:text-primary-color-dark">
                            Tabel {{ $title }} - {{ $kri->kriteria }}
                        </h6>
                        <div class="w-1/2 max-w-full flex-none px-3 text-right">
                            <label for="create_sub_kriteria"
                                class="mb-0 inline-block cursor-pointer rounded-lg px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-white shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2"
                                onclick="return create_button()"
                                style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                                <i class="ri-add-fill"></i>
                                Tambah
                            </label>
                        </div>
                    </div>
                    <div class="flex-auto px-0 pb-2 pt-0">
                        <div class="overflow-x-auto p-0 px-6 pb-6">
                            <table id="myTable_{{ $kri->id }}"
                                class="table-container nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top text-center"
                                style="width: 100%;">
                                <thead class="align-bottom">
                                    <tr class="text-xs font-bold uppercase text-white text-center"
                                        style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                                        <th class="rounded-tl text-center py-4 px-3 border-r border-gray-600">No.</th>
                                        <th class="text-center py-4 px-3 border-r border-gray-600">Nama Sub Kriteria</th>
                                        <th class="text-center py-4 px-3 border-r border-gray-600">Bobot (%)</th>
                                        <th class="rounded-tr text-center py-4 px-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subKriteria->where('kriteria_id', $kri->id) as $key => $item)
                                        <tr
                                            class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                            <!-- No. -->
                                            <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                                {{ $key + 1 }}.
                                            </td>

                                            <!-- Nama Sub Kriteria -->
                                            <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                                {{ $item->sub_kriteria }}
                                            </td>

                                            <!-- Bobot -->
                                            <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                                {{ $item->bobot }}%
                                            </td>

                                            <!-- Aksi -->
                                            <td class="py-4 px-3 align-middle text-center">
                                                <label for="edit_sub_kriteria"
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
                                <tfoot>
                                    <tr class="border-t-2 border-gray-300"
                                        style="background: linear-gradient(135deg, #f8fafc, #e2e8f0);">
                                        <td colspan="2"
                                            class="text-right py-4 px-3 text-base font-semibold text-gray-800 border-r border-gray-200">
                                            Total Bobot:
                                        </td>
                                        <td class="total-value text-center py-4 px-3 text-base font-bold text-white border-r border-gray-200"
                                            style="background: linear-gradient(135deg, #059669, #047857);">
                                            {{ $subKriteria->where('kriteria_id', $kri->id)->sum('bobot') }}%
                                        </td>
                                        <td class="py-4 px-3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection