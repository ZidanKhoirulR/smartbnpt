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
            $(document).on('change', 'select[name="sub_kriteria_id[]"]', function () {
                validateSubKriteria(this);
            });

            // Auto-validate on modal open
            $(document).on('change', '#create_button, #edit_button', function () {
                if ($(this).is(':checked')) {
                    setTimeout(() => {
                        resetValidation();
                    }, 100);
                }
            });

            // Form submission validation
            $(document).on('submit', 'form', function (e) {
                const form = this;
                let isValid = true;

                // Validate all select fields are selected
                    $(form).find('select[required]').each(function () {
                        if (!this.value || this.value === 'Pilih Sub Kriteria!' || this.value === '') {
                            isValid = false;
                            validateSubKriteria(this);
                        } else {
                            validateSubKriteria(this);
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        showNotification('Pastikan semua kriteria telah dipilih', 'error');
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
            });

            function create_button(alternatif_id) {
                // Reset form
                $("input[name='alternatif_id']").val(alternatif_id);

                // Reset all selects
                $("select[name='sub_kriteria_id[]']").val('');
                $("select[name='sub_kriteria_id[]']").prop('selectedIndex', 0);

                // Reset validation styling
                resetValidation();

                // Auto focus on first select
                setTimeout(() => {
                    $("#create_button").closest('.modal').find("select[name='sub_kriteria_id[]']").first().focus();
                }, 200);
            }

            function edit_button(alternatif_id) {
                // Show loading
                showLoadingState();

                $.ajax({
                    type: "get",
                    url: "{{ route("penilaian.edit") }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "alternatif_id": alternatif_id
                    },
                    success: function (data) {
                        // Populate form
                        $("input[name='alternatif_id']").val(data[0].alternatif_id);
                        @foreach ($kriteria as $value => $item)
                            $("input[id='kriteria_id_{{ $item->id }}']").val(data[{{ $value }}].kriteria_id);
                            $("select[id='sub_kriteria_id_{{ $item->id }}']").val(data[{{ $value }}].sub_kriteria_id);
                        @endforeach

                        // Hide loading
                        hideLoadingState();

                        // Reset validation and validate current values
                        resetValidation();
                        $("select[name='sub_kriteria_id[]']").each(function () {
                            validateSubKriteria(this);
                        });
                    },
                    error: function () {
                        hideLoadingState();
                        showNotification('Gagal memuat data penilaian', 'error');
                    }
                });
            }

            // Enhanced validation functions
            function validateSubKriteria(select) {
                const value = select.value;
                const $select = $(select);
                const $formControl = $select.closest('.form-control');

                // Remove previous validation
                $select.removeClass('select-error select-success border-red-500 border-green-500');
                $formControl.find('.validation-message').remove();

                if (!value || value === 'Pilih Sub Kriteria!' || value === '') {
                    showValidationError($select, 'Kriteria wajib dipilih');
                    return false;
                }

                showValidationSuccess($select);
                return true;
            }

            // Validation helper functions
            function showValidationError($select, message) {
                $select.addClass('select-error border-red-500');
                const $formControl = $select.closest('.form-control');

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

            function showValidationSuccess($select) {
                $select.addClass('select-success border-green-500');
                const $formControl = $select.closest('.form-control');
                $formControl.find('.validation-message').remove();
            }

            function resetValidation() {
                $('select').removeClass('select-error select-success border-red-500 border-green-500');
                $('.validation-message').remove();
            }

            // Loading state functions
            function showLoadingState() {
                const loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
                @foreach ($kriteria as $item)
                    $("#loading_edit_{{ $item->id }}").html(loading);
                @endforeach
                                                                }

            function hideLoadingState() {
                @foreach ($kriteria as $item)
                    $("#loading_edit_{{ $item->id }}").html('');
                @endforeach
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

        /* Table alignment and styling */
        #myTable td,
        #myTable th {
            text-align: center !important;
            vertical-align: middle !important;
            min-height: 50px;
            padding: 12px 8px !important;
        }

        /* First column (Nama Alternatif) left aligned */
        #myTable td:first-child,
        #myTable th:first-child {
            text-align: left !important;
            padding-left: 16px !important;
        }

        /* Pastikan paragraf dalam sel mengikuti alignment */
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

        /* Header styling */
        #myTable thead th {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 12px 8px !important;
        }

        /* Select error and success styling */
        .select-error {
            border-color: #f87171 !important;
            box-shadow: 0 0 0 1px #f87171 !important;
        }

        .select-success {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 1px #10b981 !important;
        }

        /* Keterangan table styling */
        .table-xs td {
            padding: 4px 8px !important;
        }
    </style>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Alert untuk Penilaian --}}
            <div class="mb-4 rounded-lg p-4 text-sm text-white" role="alert"
                style="background: linear-gradient(135deg, #3b82f6, #6366f1); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
                <span class="font-medium">Info Penilaian:</span>
                Pastikan setiap alternatif memiliki nilai untuk semua kriteria. Penilaian yang tidak lengkap akan
                mempengaruhi hasil analisis.
            </div>

            {{-- Modal Create - Clean Version --}}
            <input type="checkbox" id="create_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box max-w-2xl">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Tambah Penilaian</h3>
                        <label for="create_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <form action="{{ route("penilaian.update") }}" method="POST">
                        @csrf
                        <input type="hidden" name="alternatif_id">

                        @foreach ($kriteria as $item)
                            <label class="form-control w-full mb-4">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>{{ $item->kriteria }}</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt text-xs text-gray-500">
                                        {{ $item->jenis_kriteria == 'benefit' ? 'Semakin besar semakin baik' : 'Semakin kecil semakin baik' }}
                                    </span>
                                </div>

                                <!-- Hidden input untuk kriteria_id -->
                                <input type="hidden" name="kriteria_id[]" value="{{ $item->id }}" />

                                <!-- Hanya select yang terlihat -->
                                <select name="sub_kriteria_id[]" class="select select-bordered w-full text-primary-color"
                                    required>
                                    <option value="" disabled selected>Pilih Sub Kriteria!</option>
                                    @foreach ($subKriteria->where("kriteria_id", $item->id) as $value)
                                        <option value="{{ $value->id }}">{{ $value->sub_kriteria }}</option>
                                    @endforeach
                                </select>
                            </label>
                        @endforeach

                        <button type="submit"
                            class="mt-4 w-full text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 hover:opacity-90"
                            style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                            <i class="ri-save-line"></i>
                            Simpan Penilaian
                        </button>
                    </form>
                </div>
            </div>
        </div>
        {{-- Akhir Modal Create --}}

        {{-- Modal Edit - Clean Version --}}
        <input type="checkbox" id="edit_button" class="modal-toggle" />
        <div class="modal" role="dialog">
            <div class="modal-box max-w-2xl">
                <div class="mb-3 flex justify-between">
                    <h3 class="text-lg font-bold">Ubah Penilaian</h3>
                    <label for="edit_button" class="cursor-pointer">
                        <i class="ri-close-large-fill"></i>
                    </label>
                </div>
                <form action="{{ route("penilaian.update") }}" method="POST">
                    @csrf
                    <input type="hidden" name="alternatif_id">

                    @foreach ($kriteria as $item)
                        <label class="form-control w-full mb-4">
                            <div class="label">
                                <span class="label-text font-semibold">
                                    <x-label-input-required>{{ $item->kriteria }}</x-label-input-required>
                                </span>
                                <span class="label-text-alt" id="loading_edit_{{ $item->id }}"></span>
                            </div>

                            <!-- Hidden input untuk kriteria_id -->
                            <input type="hidden" name="kriteria_id[]" id="kriteria_id_{{ $item->id }}"
                                value="{{ $item->id }}" />

                            <!-- Hanya select yang terlihat -->
                            <select name="sub_kriteria_id[]" id="sub_kriteria_id_{{ $item->id }}"
                                class="select select-bordered w-full text-primary-color" required>
                                <option value="" disabled selected>Pilih Sub Kriteria!</option>
                                @foreach ($subKriteria->where("kriteria_id", $item->id) as $value)
                                    <option value="{{ $value->id }}">{{ $value->sub_kriteria }}</option>
                                @endforeach
                            </select>
                        </label>
                    @endforeach

                    <button type="submit"
                        class="mt-4 w-full text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 hover:opacity-90"
                        style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                        <i class="ri-refresh-line"></i>
                        Perbarui Penilaian
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- Akhir Modal Edit --}}

    {{-- Awal Tabel Penilaian --}}
    <div
        class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
        <div
            class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
            <h6 class="font-bold text-primary-color dark:text-primary-color-dark">Tabel {{ $title }}</h6>
        </div>
        <div class="flex-auto px-0 pb-2 pt-0">
            <div class="overflow-x-auto p-0 px-6 pb-6">
                <table id="myTable"
                    class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top text-center"
                    style="width: 100%;">
                    <thead class="align-bottom">
                        <tr class="text-xs font-bold uppercase text-white text-center"
                            style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e293b 100%);">
                            <th class="rounded-tl text-left py-4 px-3 border-r border-gray-600">Nama Alternatif</th>
                            @foreach ($kriteria as $item)
                                <th class="text-center py-4 px-3 border-r border-gray-600">
                                    {{ $item->kriteria }}
                                </th>
                            @endforeach
                            <th class="rounded-tr text-center py-4 px-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alternatif as $item)
                            <tr class="border-b border-gray-200 bg-transparent hover:bg-gray-50 transition-colors duration-200">
                                <!-- Nama Alternatif -->
                                <td class="py-4 px-3 border-r border-gray-200 align-middle text-left">
                                    <span class="font-semibold text-gray-800">
                                        {{ $item->alternatif }}
                                    </span>
                                </td>

                                <!-- Nilai Kriteria -->
                                @foreach ($penilaian->where("alternatif_id", $item->id) as $value)
                                    <td class="py-4 px-3 border-r border-gray-200 align-middle text-center">
                                        @if ($value->sub_kriteria_id == null)
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                style="background: linear-gradient(135deg, #6b7280, #4b5563);">
                                                Belum Dinilai
                                            </span>
                                        @else
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                                                style="background: linear-gradient(135deg, #059669, #047857);">
                                                {{ $value->subKriteria->sub_kriteria }}
                                            </span>
                                        @endif
                                    </td>
                                @endforeach

                                <!-- Aksi -->
                                <td class="py-4 px-3 align-middle text-center">
                                    <div class="flex justify-center gap-2">
                                        @if ($penilaian->where("alternatif_id", $item->id)->where("sub_kriteria_id", null)->count() > 0)
                                            <label for="create_button"
                                                class="px-3 py-2 rounded-lg text-white font-semibold cursor-pointer transition-all duration-200 hover:opacity-90 text-sm inline-flex items-center"
                                                onclick="return create_button('{{ $item->id }}')"
                                                style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                                                <i class="ri-add-fill text-base"></i>
                                            </label>
                                        @endif
                                        <label for="edit_button"
                                            class="px-3 py-2 rounded-lg text-white font-semibold cursor-pointer transition-all duration-200 hover:opacity-90 text-sm inline-flex items-center"
                                            onclick="return edit_button('{{ $item->id }}')"
                                            style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                                            <i class="ri-pencil-fill text-base"></i>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Keterangan Table --}}
                <div class="mt-6 rounded-lg p-4"
                    style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border: 1px solid #cbd5e1;">
                    <div class="w-fit overflow-x-auto">
                        <table class="table table-xs">
                            <tr>
                                <td class="text-base font-semibold text-gray-700">
                                    <i class="ri-information-line mr-2"></i>Keterangan:
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pl-6">
                                    • Pastikan setiap alternatif terisi semua kriteria
                                </td>
                                <td class="text-sm text-gray-600"></td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pl-6">
                                    • Data yang belum dinilai akan ditampilkan sebagai "Belum Dinilai"
                                </td>
                                <td class="text-sm text-gray-600"></td>
                            </tr>
                            <tr>
                                <td class="text-sm text-gray-600 pl-6">
                                    • Gunakan tombol hijau untuk menambah penilaian baru, dan tombol ungu untuk
                                    mengedit
                                </td>
                                <td class="text-sm text-gray-600"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Akhir Tabel Penilaian --}}
    </div>
    </div>
@endsection