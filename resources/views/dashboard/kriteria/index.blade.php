@extends("dashboard.layouts.main")

@section("js")
    <script>
        // Global variable untuk menyimpan ID yang akan dihapus
            let kriteriaToDelete = null;

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
                $(document).on('input', 'input[name="ranking"]', function () {
                    const isEditMode = $(this).closest('form').find("input[name='id']").val() !== '';
                    if (!isEditMode) {
                        validateRanking(this);
                    }
                });

                $(document).on('input', 'input[name="kriteria"]', function () {
                    validateKriteria(this);
                });
            });

            function create_button() {
                // Reset form
                $("input[name='id']").val("");
                $("input[name='kriteria']").val("");
                $("input[name='ranking']").val("");
                $("input[name='kode']").val("{{ $kode }}");

                // Reset radio buttons
                $("input[name='jenis_kriteria']").prop('checked', false);
                $("#benefit_create").prop("checked", true);

                // Reset validation styling
                resetValidation();

                // Auto focus on first input
                setTimeout(() => {
                    $("#create_button").closest('.modal').find("input[name='ranking']").focus();
                }, 200);
            }

            function edit_button(kriteria_id) {
                console.log('Editing kriteria ID:', kriteria_id);

                // Show loading
                showLoadingState();

                $.ajax({
                    type: "GET",
                    url: "{{ route("kriteria.edit") }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "kriteria_id": kriteria_id
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        console.log('Sending AJAX request to edit kriteria');
                    },
                    success: function (response) {
                        console.log('Edit response received:', response);

                        // Handle both resource wrapper and direct response
                        const data = response.data || response;

                        if (data && data.id) {
                            // Populate form
                            $("input[name='id']").val(data.id);
                            $("input[name='kode']").val(data.kode);
                            $("input[name='kriteria']").val(data.kriteria);

                            // Set ranking - pastikan ada ranking
                            if (data.ranking) {
                                $("#ranking_display").text(data.ranking);
                                $("#ranking_hidden").val(data.ranking);
                            } else {
                                $("#ranking_display").text('-');
                                $("#ranking_hidden").val('');
                            }

                            // Set radio button - reset first
                            $("input[name='jenis_kriteria']").prop('checked', false);

                            if (data.jenis_kriteria == "benefit") {
                                $("#benefit_edit").prop("checked", true);
                            } else if (data.jenis_kriteria == "cost") {
                                $("#cost_edit").prop("checked", true);
                            }

                            // Hide loading
                            hideLoadingState();

                            // Reset validation
                            resetValidation();

                            // Validate current values
                            if ($("input[name='kriteria']").length > 0) {
                                validateKriteria($("input[name='kriteria']")[0]);
                            }

                            showNotification('Data kriteria berhasil dimuat', 'success');
                        } else {
                            hideLoadingState();
                            showNotification('Data tidak lengkap dari server', 'error');
                            console.error('Incomplete data from server:', response);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error details:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status,
                            url: "{{ route("kriteria.edit") }}"
                        });

                        hideLoadingState();

                        let errorMessage = 'Gagal memuat data kriteria';

                        try {
                            const errorResponse = JSON.parse(xhr.responseText);
                            errorMessage = errorResponse.error || errorResponse.message || errorMessage;
                        } catch (e) {
                            console.error('Failed to parse error response');
                        }

                        if (xhr.status === 404) {
                            errorMessage = 'Data kriteria tidak ditemukan';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Terjadi kesalahan server';
                        } else if (xhr.status === 403) {
                            errorMessage = 'Tidak memiliki akses';
                        } else if (xhr.status === 422) {
                            errorMessage = 'Data tidak valid';
                        }

                        showNotification(errorMessage, 'error');
                    }
                });
            }

            function delete_button(kriteria_id, kriteria_name) {
                console.log('Preparing to delete kriteria ID:', kriteria_id);

                // Simpan ID yang akan dihapus
                kriteriaToDelete = kriteria_id;

                // Update nama kriteria di modal
                document.getElementById('delete_kriteria_name').textContent = kriteria_name || 'Kriteria ini';

                // Buka modal
                document.getElementById('delete_modal').checked = true;
            }

            // Fungsi untuk konfirmasi penghapusan
            function confirmDelete() {
                if (!kriteriaToDelete) {
                    showNotification('Tidak ada data yang dipilih untuk dihapus', 'error');
                    return;
                }

                console.log('Confirming delete for kriteria ID:', kriteriaToDelete);

                // Tutup modal
                document.getElementById('delete_modal').checked = false;

                // Show loading notification
                showNotification('Menghapus data kriteria...', 'info');

                $.ajax({
                    type: "POST",
                    url: "{{ route('kriteria.delete') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "DELETE",
                        "kriteria_id": kriteriaToDelete
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log('Delete response received:', response);

                        // Reset variable
                        kriteriaToDelete = null;

                        // Show success notification
                        showNotification('Data kriteria berhasil dihapus', 'success');

                        // Reload page to update the table
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    },
                    error: function (xhr, status, error) {
                        console.error('Delete AJAX Error:', xhr.responseText);

                        // Reset variable
                        kriteriaToDelete = null;

                        let errorMessage = 'Gagal menghapus data kriteria';

                        try {
                            const errorResponse = JSON.parse(xhr.responseText);
                            errorMessage = errorResponse.error || errorResponse.message || errorMessage;
                        } catch (e) {
                            console.error('Failed to parse error response');
                        }

                        if (xhr.status === 404) {
                            errorMessage = 'Data kriteria tidak ditemukan';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Terjadi kesalahan server';
                        } else if (xhr.status === 403) {
                            errorMessage = 'Tidak memiliki akses untuk menghapus';
                        } else if (xhr.status === 422) {
                            errorMessage = 'Data tidak dapat dihapus (mungkin masih digunakan)';
                        }

                        showNotification(errorMessage, 'error');
                    }
                });
            }

            // Update validasi form submission - hapus validasi ranking untuk mode edit
            $(document).on('submit', 'form', function (e) {
                const form = this;
                let isValid = true;
                const isEditMode = $(form).find("input[name='id']").val() !== '';

                console.log('Form submission - Edit mode:', isEditMode);

                // Validate all required fields
                $(form).find('input[required]').each(function () {
                    // Hanya validasi ranking jika bukan mode edit
                    if (this.name === 'ranking' && !isEditMode && !validateRanking(this)) {
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

                // Debug: log form data
                console.log('Form data being submitted:', $(form).serialize());

                // Show loading on submit button
                const $submitBtn = $(form).find('button[type="submit"]');
                const originalText = $submitBtn.html();
                $submitBtn.html('<span class="loading loading-spinner loading-sm"></span> Menyimpan...').prop('disabled', true);

                // Restore button after 10 seconds (fallback)
                setTimeout(() => {
                    $submitBtn.html(originalText).prop('disabled', false);
                }, 10000);
            });

            // Validation functions
            function validateRanking(input) {
                const value = parseInt(input.value);
                const $input = $(input);
                const $formControl = $input.closest('.form-control');
                const isEditMode = $input.closest('form').find("input[name='id']").val() !== '';

                // Remove previous validation
                $input.removeClass('input-error input-success border-red-500 border-green-500');
                $formControl.find('.validation-message').remove();

                // Skip validasi ranking untuk edit mode
                if (isEditMode) {
                    return true;
                }

                if (!input.value.trim()) {
                    showValidationError($input, 'Ranking wajib diisi');
                    return false;
                }

                if (isNaN(value) || value < 1) {
                    showValidationError($input, 'Ranking minimal adalah 1');
                    return false;
                }

                const maxRanking = {{ $kriteria->count() + 1 }};
                if (value > maxRanking) {
                    showValidationError($input, `Ranking maksimal adalah ${maxRanking}`);
                    return false;
                }

                showValidationSuccess($input);
                return true;
            }

            function validateKriteria(input) {
                const $input = $(input);
                const $formControl = $input.closest('.form-control');

                // Remove previous validation
                $input.removeClass('input-error input-success border-red-500 border-green-500');
                $formControl.find('.validation-message').remove();

                if (!input.value.trim()) {
                    showValidationError($input, 'Nama kriteria wajib diisi');
                    return false;
                }

                if (input.value.trim().length < 3) {
                    showValidationError($input, 'Nama kriteria minimal 3 karakter');
                    return false;
                }

                showValidationSuccess($input);
                return true;
            }

            function showValidationError($input, message) {
                $input.addClass('input-error border-red-500');
                const $formControl = $input.closest('.form-control');
                $formControl.append(`<div class="validation-message text-red-500 text-xs mt-1">${message}</div>`);
            }

            function showValidationSuccess($input) {
                $input.addClass('input-success border-green-500');
            }

            function resetValidation() {
                $('input').removeClass('input-error input-success border-red-500 border-green-500');
                $('.validation-message').remove();
            }

            // Loading state functions
            function showLoadingState() {
                const loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
                for (let i = 1; i <= 2; i++) {
                    $(`#loading_edit${i}`).html(loading);
                }
            }

            function hideLoadingState() {
                for (let i = 1; i <= 2; i++) {
                    $(`#loading_edit${i}`).html('');
                }
            }

            // Enhanced notification with auto-dismiss and better styling
            function showNotification(message, type = 'info') {
                // Remove existing notifications
                document.querySelectorAll('.toast-notification').forEach(toast => toast.remove());

                const toast = document.createElement('div');
                toast.className = `toast-notification alert alert-${type} fixed top-4 right-4 w-auto max-w-sm z-50 shadow-lg animate-pulse`;

                const iconMap = {
                    'success': 'ri-checkbox-circle-line',
                    'error': 'ri-error-warning-line',
                    'warning': 'ri-alert-line',
                    'info': 'ri-information-line'
                };

                toast.innerHTML = `
                                                        <div class="flex items-center gap-2">
                                                            <i class="${iconMap[type] || iconMap.info}"></i>
                                                            <span class="text-sm">${message}</span>
                                                            <button class="btn btn-ghost btn-xs ml-2" onclick="this.parentElement.parentElement.remove()">
                                                                <i class="ri-close-line"></i>
                                                            </button>
                                                        </div>
                                                    `;

                document.body.appendChild(toast);

                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateX(100%)';
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 5000);
            }
        </script>
@endsection

@section("css")
    <style>
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

        /* Semua kolom termasuk Nama Kriteria rata tengah */
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

        /* Pastikan span badge center */
        #myTable td span {
            display: inline-block;
            text-align: center;
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

        /* UPDATE BAGIAN CSS DI INDEX.BLADE.PHP - SECTION CSS */

        /* Konsistensi lebar kolom - kembali ke layout tanpa kolom bobot */
        #myTable th:nth-child(1),
        #myTable td:nth-child(1) {
            width: 8%;
        }

        /* No */

        #myTable th:nth-child(2),
        #myTable td:nth-child(2) {
            width: 12%;
        }

        /* Kode */

        #myTable th:nth-child(3),
        #myTable td:nth-child(3) {
            width: 12%;
        }

        /* Ranking */

        #myTable th:nth-child(4),
        #myTable td:nth-child(4) {
            width: 50%;
        }

        /* Nama Kriteria */

        #myTable th:nth-child(5),
        #myTable td:nth-child(5) {
            width: 12%;
        }

        /* Jenis */

        #myTable th:nth-child(6),
        #myTable td:nth-child(6) {
            width: 6%;
        }

        /* Aksi */
    </style>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Alert untuk ranking --}}
            <div class="mb-4 rounded-lg p-4 text-sm text-white" role="alert"
                style="background: linear-gradient(135deg, #3b82f6, #6366f1); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
                <span class="font-medium">Info Ranking:</span>
                Ranking menentukan tingkat kepentingan kriteria (1 = Paling Penting, 2 = Kedua Paling Penting, dst).
                Pastikan tidak ada ranking yang duplikat dan berurutan mulai dari 1.
            </div>

            {{-- Awal Modal Create --}}
            <input type="checkbox" id="create_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box w-80 max-w-xs">
                    <div class="mb-2 flex justify-between items-center">
                        <h3 class="text-sm font-bold">Tambah {{ $title }}</h3>
                        <label for="create_button" class="cursor-pointer">
                            <i class="ri-close-large-fill text-sm"></i>
                        </label>
                    </div>
                    <div>
                        <form action="{{ route("kriteria.store") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" hidden>

                            <div class="space-y-1">
                                {{-- Kode dan Ranking dalam satu baris --}}
                                <div class="grid grid-cols-2 gap-2">
                                    {{-- Kode --}}
                                    <label class="form-control w-full">
                                        <div class="label py-0.5">
                                            <span class="label-text text-xs font-semibold">
                                                <x-label-input-required>Kode</x-label-input-required>
                                            </span>
                                        </div>
                                        <input type="text" name="kode"
                                            class="input input-bordered input-xs w-full cursor-default bg-slate-100 text-primary-color text-xs"
                                            value="{{ old("kode") }}" required readonly />
                                    </label>

                                    {{-- Ranking Kepentingan --}}
                                    <label class="form-control w-full">
                                        <div class="label py-0.5">
                                            <span class="label-text text-xs font-semibold">
                                                <x-label-input-required>Ranking</x-label-input-required>
                                            </span>
                                        </div>
                                        <input type="number" min="1" max="{{ $kriteria->count() + 1 }}" step="1"
                                            name="ranking"
                                            class="input input-bordered input-xs w-full text-primary-color text-xs"
                                            value="{{ old("ranking") }}" placeholder="1, 2, 3..." required />
                                    </label>
                                </div>

                                {{-- Kriteria --}}
                                <label class="form-control w-full">
                                    <div class="label py-0.5">
                                        <span class="label-text text-xs font-semibold">
                                            <x-label-input-required>Nama Kriteria</x-label-input-required>
                                        </span>
                                    </div>
                                    <input type="text" name="kriteria"
                                        class="input input-bordered input-xs w-full text-primary-color text-xs"
                                        value="{{ old("kriteria") }}" placeholder="Pendapatan per Bulan" required />
                                </label>

                                {{-- Jenis Kriteria --}}
                                <label class="form-control w-full">
                                    <div class="label py-0.5">
                                        <span class="label-text text-xs font-semibold">
                                            <x-label-input-required>Jenis Kriteria</x-label-input-required>
                                        </span>
                                    </div>
                                    <div class="flex gap-2">
                                        <label class="label cursor-pointer p-1 flex-1">
                                            <input type="radio" value="benefit" name="jenis_kriteria" id="benefit_create"
                                                class="radio-primary radio radio-xs" checked />
                                            <span class="label-text text-xs ml-1">Benefit</span>
                                        </label>
                                        <label class="label cursor-pointer p-1 flex-1">
                                            <input type="radio" value="cost" name="jenis_kriteria"
                                                class="radio-primary radio radio-xs" />
                                            <span class="label-text text-xs ml-1">Cost</span>
                                        </label>
                                    </div>
                                </label>
                            </div>

                            <button type="submit"
                                class="mt-2 w-full text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 hover:opacity-90"
                                style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                                <i class="ri-save-line"></i>
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Create --}}

            {{-- Awal Modal Edit --}}
            <input type="checkbox" id="edit_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box w-80 max-w-xs">
                    <div class="mb-2 flex justify-between items-center">
                        <h3 class="text-sm font-bold">Ubah {{ $title }}</h3>
                        <label for="edit_button" class="cursor-pointer">
                            <i class="ri-close-large-fill text-sm"></i>
                        </label>
                    </div>
                    <div>
                        <form action="{{ route("kriteria.update") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" hidden>

                            <div class="space-y-1">
                                {{-- Kode dan Ranking dalam satu baris --}}
                                <div class="grid grid-cols-2 gap-2">
                                    {{-- Kode --}}
                                    <label class="form-control w-full">
                                        <div class="label py-0.5">
                                            <span class="label-text text-xs font-semibold">
                                                <x-label-input-required>Kode</x-label-input-required>
                                            </span>
                                            <span class="label-text-alt" id="loading_edit1"></span>
                                        </div>
                                        <input type="text" name="kode"
                                            class="input input-bordered input-xs w-full cursor-default bg-slate-100 text-primary-color text-xs"
                                            required readonly />
                                    </label>

                                    {{-- Ranking (Display Only) --}}
                                    <label class="form-control w-full">
                                        <div class="label py-0.5">
                                            <span class="label-text text-xs font-semibold">Ranking</span>
                                        </div>
                                        <div
                                            class="input input-bordered input-xs w-full cursor-default bg-slate-100 text-primary-color flex items-center justify-center text-xs">
                                            <span id="ranking_display"
                                                class="px-1.5 py-0.5 rounded-full text-xs font-semibold text-white"
                                                style="background: linear-gradient(135deg, #3b82f6, #6366f1);"></span>
                                        </div>
                                        <input type="hidden" name="ranking" id="ranking_hidden">
                                    </label>
                                </div>

                                {{-- Kriteria --}}
                                <label class="form-control w-full">
                                    <div class="label py-0.5">
                                        <span class="label-text text-xs font-semibold">
                                            <x-label-input-required>Nama Kriteria</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt" id="loading_edit2"></span>
                                    </div>
                                    <input type="text" name="kriteria"
                                        class="input input-bordered input-xs w-full text-primary-color text-xs"
                                        placeholder="Pendapatan per Bulan" required />
                                </label>

                                {{-- Jenis Kriteria --}}
                                <label class="form-control w-full">
                                    <div class="label py-0.5">
                                        <span class="label-text text-xs font-semibold">
                                            <x-label-input-required>Jenis Kriteria</x-label-input-required>
                                        </span>
                                    </div>
                                    <div class="flex gap-2">
                                        <label class="label cursor-pointer p-1 flex-1">
                                            <input type="radio" value="benefit" name="jenis_kriteria" id="benefit_edit"
                                                class="radio-primary radio radio-xs" />
                                            <span class="label-text text-xs ml-1">Benefit</span>
                                        </label>
                                        <label class="label cursor-pointer p-1 flex-1">
                                            <input type="radio" value="cost" name="jenis_kriteria" id="cost_edit"
                                                class="radio-primary radio radio-xs" />
                                            <span class="label-text text-xs ml-1">Cost</span>
                                        </label>
                                    </div>
                                </label>

                                {{-- Info tambahan untuk edit --}}
                                <div class="text-xs text-gray-400 mt-1">
                                    <i class="ri-information-line mr-1"></i>
                                    Untuk mengubah ranking, hapus dan buat ulang kriteria
                                </div>
                            </div>

                            <button type="submit"
                                class="mt-2 w-full text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 hover:opacity-90"
                                style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                                <i class="ri-refresh-line"></i>
                                Perbarui
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Edit --}}

            {{-- Awal Modal Delete --}}
            <input type="checkbox" id="delete_modal" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box w-80 max-w-xs">
                    <div class="mb-2 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-red-600">Hapus Kriteria</h3>
                        <label for="delete_modal" class="cursor-pointer">
                            <i class="ri-close-large-fill text-sm"></i>
                        </label>
                    </div>
                    <div class="py-4">
                        <div class="text-center">
                            <i class="ri-delete-bin-line text-4xl text-red-500 mb-3"></i>
                            <p class="text-sm text-gray-600 mb-2">Apakah Anda yakin ingin menghapus kriteria ini?</p>
                            <p class="text-xs text-red-500 mb-4 font-semibold" id="delete_kriteria_name"></p>
                            <p class="text-xs text-gray-400">Data yang dihapus tidak dapat dikembalikan!</p>
                        </div>

                        <div class="flex gap-2 mt-6">
                            <label for="delete_modal"
                                class="flex-1 text-center px-3 py-2 rounded-lg text-gray-600 font-semibold cursor-pointer transition-all duration-200 hover:opacity-90 text-xs border border-gray-300">
                                Batal
                            </label>
                            <button onclick="confirmDelete()"
                                class="flex-1 text-white px-3 py-2 rounded-lg font-semibold transition-all duration-200 hover:opacity-90 text-xs"
                                style="background: linear-gradient(135deg, #e11d48, #be185d); box-shadow: 0 4px 15px rgba(225, 29, 72, 0.3);">
                                <i class="ri-delete-bin-line mr-1"></i>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Delete --}}

            {{-- Awal Tabel Kriteria --}}
            <div
                class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div
                    class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel {{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        <label for="create_button"
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
                        <table id="myTable"
                            class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-toptext-center"
                            style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="text-xs font-bold uppercase text-white text-center"
                                    style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                                    <th class="rounded-tl text-center py-4 px-3 border-r border-gray-600">No.</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Kode</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Ranking</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Nama Kriteria</th>
                                    <th class="text-center py-4 px-3 border-r border-gray-600">Jenis</th>
                                    <th class="rounded-tr text-center py-4 px-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria->sortBy('ranking') as $value => $item)
                                    <tr
                                        class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                        <!-- No. -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            {{ $value + 1 }}.
                                        </td>

                                        <!-- Kode -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            {{ $item->kode }}
                                        </td>

                                        <!-- Ranking -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                style="background: linear-gradient(135deg, #3b82f6, #6366f1);">
                                                {{ $item->ranking ?? '-' }}
                                            </span>
                                        </td>

                                        <!-- Nama Kriteria -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            {{ $item->kriteria }}
                                        </td>

                                        <!-- Jenis -->
                                        <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                            @if($item->jenis_kriteria == 'benefit')
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                    style="background: linear-gradient(135deg, #10b981, #059669);">BENEFIT</span>
                                            @else
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                    style="background: linear-gradient(135deg, #f59e0b, #d97706);">COST</span>
                                            @endif
                                        </td>

                                        <!-- Aksi -->
                                        <td class="py-4 px-3 align-middle text-center">
                                            <label for="edit_button"
                                                class="px-3 py-2 rounded-lg text-white font-semibold cursor-pointer transition-all duration-200 hover:opacity-90 text-sm inline-flex items-center mr-2"
                                                onclick="return edit_button('{{ $item->id }}')"
                                                style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                                                <i class="ri-pencil-line text-base"></i>
                                            </label>
                                            <label for="delete_modal"
                                                class="px-3 py-2 rounded-lg text-white font-semibold cursor-pointer transition-all duration-200 hover:opacity-90 text-sm inline-flex items-center"
                                                onclick="return delete_button('{{ $item->id }}', '{{ $item->kriteria }}')"
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
            {{-- Akhir Tabel Kriteria --}}
        </div>
    </div>
@endsection