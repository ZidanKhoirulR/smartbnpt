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
        // Real-time validation for all forms
                $(document).on('input', 'input[name="ranking"]', function() {
                    validateRanking(this);
                });

                $(document).on('input', 'input[name="bobot"]', function() {
                    validateBobot(this);
                    updateWeightInfo();
                });

                $(document).on('input', 'input[name="kriteria"]', function() {
                    validateKriteria(this);
                });

                // Auto-calculate weight info on modal open
                $(document).on('change', '#create_button, #edit_button', function() {
                    if ($(this).is(':checked')) {
                        setTimeout(() => {
                            updateWeightInfo();
                        }, 100);
                    }
                });
            });

            function create_button() {
                // Reset form
                $("input[name='id']").val("");
                $("input[name='kriteria']").val("");
                $("input[name='bobot']").val("");
                $("input[name='ranking']").val("");
                $("input[name='kode']").val("{{ $kode }}");

                // Reset radio buttons
                $("input[name='jenis_kriteria']").prop('checked', false);
                $("#benefit_create").prop("checked", true);

                // Reset validation styling
                resetValidation();

                // Update weight info
                updateWeightInfo();

                // Auto focus on first input
                setTimeout(() => {
                    $("#create_button").closest('.modal').find("input[name='ranking']").focus();
                }, 200);
            }

            function edit_button(kriteria_id) {
                // Show loading
                showLoadingState();

                $.ajax({
                    type: "get",
                    url: "{{ route("kriteria.edit") }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "kriteria_id": kriteria_id
                    },
                    success: function(data) {
                        // Populate form
                        $("input[name='id']").val(data.data.id);
                        $("input[name='kode']").val(data.data.kode);
                        $("input[name='kriteria']").val(data.data.kriteria);
                        $("input[name='bobot']").val(data.data.bobot);
                        $("input[name='ranking']").val(data.data.ranking || '');

                        // Set radio button
                        if (data.data.jenis_kriteria == "benefit") {
                            $("#benefit_edit").prop("checked", true);
                        } else if (data.data.jenis_kriteria == "cost") {
                            $("#cost_edit").prop("checked", true);
                        }

                        // Hide loading
                        hideLoadingState();

                        // Reset validation and update weight info
                        resetValidation();
                        updateWeightInfo();

                        // Validate current values
                        validateRanking($("input[name='ranking']")[0]);
                        validateBobot($("input[name='bobot']")[0]);
                        validateKriteria($("input[name='kriteria']")[0]);
                    },
                    error: function() {
                        hideLoadingState();
                        showNotification('Gagal memuat data kriteria', 'error');
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
                            error: function(xhr) {
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
            function validateRanking(input) {
                const value = parseInt(input.value);
                const isEdit = $(input).closest('.modal').find('#edit_button').length > 0;
                const maxRanking = isEdit ? {{ $kriteria->count() }} : {{ $kriteria->count() + 1 }};
                const $input = $(input);
                const $formControl = $input.closest('.form-control');

                // Remove previous validation
                $input.removeClass('input-error input-success border-red-500 border-green-500');
                $formControl.find('.validation-message').remove();

                if (!input.value.trim()) {
                    showValidationError($input, 'Ranking wajib diisi');
                    return false;
                }

                if (isNaN(value) || value < 1) {
                    showValidationError($input, 'Ranking minimal adalah 1');
                    return false;
                }

                if (value > maxRanking) {
                    showValidationError($input, `Ranking maksimal adalah ${maxRanking}`);
                    return false;
                }

                // Check for duplicate ranking (only for create mode)
                if (!isEdit) {
                    let isDuplicate = false;
                    @foreach($kriteria as $k)
                        if (value == {{ $k->ranking }}) {
                            isDuplicate = true;
                        }
                    @endforeach

                    if (isDuplicate) {
                        showValidationError($input, 'Ranking sudah digunakan');
                        return false;
                    }
                }

                showValidationSuccess($input);
                input.setCustomValidity('');
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

                // Check total weight
                const currentTotal = {{ $sumBobot }};
                const isEdit = $(input).closest('.modal').find('#edit_button').length > 0;
                let originalWeight = 0;

                if (isEdit) {
                    // Get original weight for edit mode
                    originalWeight = parseFloat($("input[name='bobot']").data('original')) || 0;
                }

                const newTotal = currentTotal - originalWeight + value;

                if (newTotal > 100) {
                    const maxAllowed = 100 - currentTotal + originalWeight;
                    showValidationError($input, `Bobot terlalu besar. Maksimal: ${maxAllowed.toFixed(2)}%`);
                    return false;
                }

                showValidationSuccess($input);
                return true;
            }

            function validateKriteria(input) {
                const value = input.value.trim();
                const $input = $(input);
                const $formControl = $input.closest('.form-control');

                // Remove previous validation
                $input.removeClass('input-error input-success border-red-500 border-green-500');
                $formControl.find('.validation-message').remove();

                if (!value) {
                    showValidationError($input, 'Nama kriteria wajib diisi');
                    return false;
                }

                if (value.length < 3) {
                    showValidationError($input, 'Nama kriteria minimal 3 karakter');
                    return false;
                }

                if (value.length > 100) {
                    showValidationError($input, 'Nama kriteria maksimal 100 karakter');
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
                $('.input').removeClass('input-error input-success border-red-500 border-green-500');
                $('.validation-message').remove();
            }

            // Weight information update
            function updateWeightInfo() {
                const currentBobot = parseFloat($('input[name="bobot"]').val()) || 0;
                const totalBobot = {{ $sumBobot }};
                const isEdit = $('input[name="id"]').val() !== '';

                let originalBobot = 0;
                if (isEdit) {
                    originalBobot = parseFloat($('input[name="bobot"]').data('original')) || 0;
                }

                const remaining = 100 - totalBobot + originalBobot - currentBobot;
                const used = totalBobot - originalBobot + currentBobot;

                // Update weight info in modal
                $('.weight-info').remove();
                const $bobotControl = $('input[name="bobot"]').closest('.form-control');

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

            // Loading state functions
            function showLoadingState() {
                const loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
                for(let i = 1; i <= 5; i++) {
                    $(`#loading_edit${i}`).html(loading);
                }
            }

            function hideLoadingState() {
                for(let i = 1; i <= 5; i++) {
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
            $(document).on('submit', 'form', function(e) {
                const form = this;
                let isValid = true;

                // Validate all required fields
                $(form).find('input[required]').each(function() {
                    if (this.name === 'ranking' && !validateRanking(this)) {
                        isValid = false;
                    }
                    if (this.name === 'bobot' && !validateBobot(this)) {
                        isValid = false;
                    }
                    if (this.name === 'kriteria' && !validateKriteria(this)) {
                        isValid = false;
                    }
                });

                // Check radio button
                if (!$(form).find('input[name="jenis_kriteria"]:checked').length) {
                    showNotification('Pilih jenis kriteria (Benefit atau Cost)', 'error');
                    isValid = false;
                }

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

            // Store original weight for edit mode
            $(document).on('click', '[onclick*="edit_button"]', function() {
                setTimeout(() => {
                    const originalWeight = parseFloat($('input[name="bobot"]').val()) || 0;
                    $('input[name="bobot"]').data('original', originalWeight);
                }, 500);
            });
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