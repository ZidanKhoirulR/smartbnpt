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
                updateWeightInfo();
            });

            // Auto-calculate weight info on modal open
            $('body').on('change', '#create_sub_kriteria, #edit_sub_kriteria', function () {
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
            updateWeightInfo();

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
                    "id": id
                },
                timeout: 10000, // 10 second timeout
                success: function (response) {
                    console.log('Response:', response); // Debug log

                    // Check if response has the expected structure
                    let data = response.data ? response.data : response;

                    // Populate form - pastikan selector tepat untuk modal edit
                    $("#edit_sub_kriteria_form input[name='id']").val(data.id);
                    $("#edit_sub_kriteria_form input[name='kriteria_id']").val(data.kriteria_id);
                    $("#edit_sub_kriteria_form input[name='kriteria_nama']").val(data.kriteria ? data.kriteria.kriteria : data.kriteria_nama);
                    $("#edit_sub_kriteria_form input[name='sub_kriteria']").val(data.sub_kriteria);
                    $("#edit_sub_kriteria_form input[name='bobot']").val(data.bobot);

                    // Simpan bobot asli untuk perhitungan weight info
                    $("#edit_sub_kriteria_form input[name='bobot']").data('original', data.bobot);

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
                            "id": id
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

            // Get current kriteria for weight calculation
            const kriteriaId = $('input[name="kriteria_id"]').val() || $('select[name="kriteria_id"]').val();
            if (kriteriaId) {
                const currentTotal = getCurrentKriteriaTotal(kriteriaId);
                const isEdit = $('input[name="id"]').val() !== '';
                let originalWeight = 0;

                if (isEdit) {
                    originalWeight = parseFloat($input.data('original')) || 0;
                }

                const newTotal = currentTotal - originalWeight + value;

                if (newTotal > 100) {
                    const maxAllowed = 100 - currentTotal + originalWeight;
                    showValidationError($input, `Bobot terlalu besar. Maksimal: ${maxAllowed.toFixed(2)}%`);
                    return false;
                }
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

        function updateWeightInfo() {
            // Tentukan modal mana yang sedang aktif
            const isEditModal = $('#edit_sub_kriteria').is(':checked');
            const isCreateModal = $('#create_sub_kriteria').is(':checked');

            let currentBobot, kriteriaId, bobotInput;

            if (isEditModal) {
                bobotInput = $("#edit_sub_kriteria_form input[name='bobot']");
                currentBobot = parseFloat(bobotInput.val()) || 0;
                kriteriaId = $("#edit_sub_kriteria_form input[name='kriteria_id']").val();
            } else if (isCreateModal) {
                bobotInput = $("#create_sub_kriteria_form input[name='bobot']");
                currentBobot = parseFloat(bobotInput.val()) || 0;
                kriteriaId = $("#create_sub_kriteria_form select[name='kriteria_id']").val();
            } else {
                return; // Tidak ada modal yang aktif
            }

            const isEdit = $("#edit_sub_kriteria_form input[name='id']").val() !== '';

            if (!kriteriaId) {
                $('.weight-info').remove();
                return;
            }

            const totalBobot = getCurrentKriteriaTotal(kriteriaId);
            let originalBobot = 0;

            if (isEdit) {
                originalBobot = parseFloat(bobotInput.data('original')) || 0;
            }

            const remaining = 100 - totalBobot + originalBobot - currentBobot;
            const used = totalBobot - originalBobot + currentBobot;

            // Update weight info in modal
            $('.weight-info').remove();
            const $bobotControl = bobotInput.closest('.form-control');

            let colorClass = 'text-blue-600';
            let icon = 'ri-information-line';

            if (remaining < 0) {
                colorClass = 'text-red-600';
                icon = 'ri-error-warning-line';
            } else if (remaining === 0) {
                colorClass = 'text-green-600';
                icon = 'ri-checkbox-circle-line';
            }

            const weightInfoHtml = `
                        <div class="label weight-info">
                            <span class="label-text-alt text-xs ${colorClass}">
                                <i class="${icon} mr-1"></i>
                                Terpakai: ${used.toFixed(1)}% | Sisa: ${remaining.toFixed(1)}%
                            </span>
                        </div>
                    `;

            $bobotControl.append(weightInfoHtml);
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
    // Import button function placeholder
                function import_button() {
                    showNotification('Fitur import belum tersedia', 'info');
                }
            </script>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Alert untuk sub kriteria --}}
            <div class="mb-4 rounded-lg bg-blue-50 p-4 text-sm text-blue-800 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <span class="font-medium">Info Sub Kriteria:</span> 
                Sub kriteria digunakan untuk memberikan nilai detail pada setiap kriteria utama. 
                Pastikan bobot sub kriteria sesuai dengan tingkat kepentingannya dan total bobot per kriteria tidak melebihi 100%.
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
                        <form id="create_sub_kriteria_form" action="{{ route('sub-kriteria.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <select name="kriteria_id" class="select select-bordered w-full text-primary-color" required>
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
                                        <span class="label-text-alt text-xs text-gray-500">Nilai numerik untuk perhitungan</span>
                                    </div>
                                    <input type="number" min="0" max="100" step="0.01" name="bobot" 
                                           class="input input-bordered w-full text-primary-color" 
                                           value="{{ old('bobot') }}" 
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
                                       class="input input-bordered w-full text-primary-color" 
                                       value="{{ old('sub_kriteria') }}" 
                                       placeholder="Contoh: Sangat Baik, Baik, Cukup" required />
                                @error('sub_kriteria')
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <button type="submit" class="btn btn-success mt-4 w-full text-white">
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
                        <form id="edit_sub_kriteria_form" action="{{ route('sub-kriteria.update') }}" method="POST" enctype="multipart/form-data">
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

                            <button type="submit" class="btn btn-warning mt-4 w-full text-white">
                                <i class="ri-refresh-line"></i>
                                Perbarui Sub Kriteria
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
                            Kolom yang diperlukan: kriteria_id, sub_kriteria, bobot
                        </div>
                        <form action="{{ route('sub-kriteria.import') }}" method="POST" enctype="multipart/form-data">
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

            {{-- Tabel Sub Kriteria --}}
            @foreach ($kriteria as $kri)
                <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                    <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                        <h6 class="font-bold text-primary-color dark:text-primary-color-dark">
                            Tabel {{ $title }} - {{ $kri->kriteria }}
                        </h6>
                        <div class="w-1/2 max-w-full flex-none px-3 text-right">
                            <label for="create_sub_kriteria" class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return create_button()">
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
                            <table id="myTable_{{ $kri->id }}" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                                <thead class="align-bottom">
                                    <tr class="bg-primary-color text-xs font-bold uppercase text-white dark:bg-primary-color-dark dark:text-white">
                                        <th class="rounded-tl">No.</th>
                                        <th>Nama Sub Kriteria</th>
                                        <th>Bobot (%)</th>
                                        <th class="rounded-tr">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subKriteria->where('kriteria_id', $kri->id) as $key => $item)
                                        <tr class="border-b border-primary-color bg-transparent dark:border-primary-color-dark">
                                            <td>
                                                <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                    {{ $key + 1 }}.
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-left align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                    {{ $item->sub_kriteria }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                    {{ $item->bobot }}%
                                                </p>
                                            </td>
                                            <td>
                                                <div class="text-center align-middle">
                                                    <label for="edit_sub_kriteria" class="btn btn-outline btn-warning btn-sm" onclick="return edit_button('{{ $item->id }}')">
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
                                        <td colspan="2" class="text-right align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                            Total Bobot:
                                        </td>
                                        <td class="text-center align-middle text-base font-bold leading-tight text-primary-color dark:text-primary-color-dark">
                                            {{ $subKriteria->where('kriteria_id', $kri->id)->sum('bobot') }}%
                                        </td>
                                        <td></td>
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