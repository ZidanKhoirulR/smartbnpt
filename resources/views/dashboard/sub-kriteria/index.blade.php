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
            // Reset form
            resetValidation();

            // Ambil data sub kriteria berdasarkan ID
            $.get("{{ route('sub-kriteria.edit') }}", { id: id }, function (data) {
                $("input[name='id']").val(data.id);
                $("input[name='kriteria_id']").val(data.kriteria_id);
                $("input[name='kriteria_nama']").val(data.kriteria.kriteria);
                $("input[name='sub_kriteria']").val(data.sub_kriteria);
                $("input[name='bobot']").val(data.bobot);

                // Simpan bobot asli untuk perhitungan weight info
                $('input[name="bobot"]').data('original', data.bobot);

                updateWeightInfo();
            }).fail(function () {
                alert("Gagal mengambil data sub kriteria");
            });
        }

        function updateWeightInfo() {
            const currentBobot = parseFloat($('input[name="bobot"]').val()) || 0;
            const totalBobot = {{ $sumBobot ?? 0 }};
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

        // Tambahan fungsi validasi yang missing
        function resetValidation() {
            $('.input-error').removeClass('input-error');
            $('.select-error').removeClass('select-error');
            $('.text-error').hide();
        }

        function validateSubKriteria(input) {
            const $input = $(input);
            const value = $input.val().trim();
            
            if (value.length < 2) {
                $input.addClass('input-error');
                return false;
            } else {
                $input.removeClass('input-error');
                return true;
            }
        }

        function validateBobot(input) {
            const $input = $(input);
            const value = parseFloat($input.val());
            
            if (isNaN(value) || value < 0 || value > 100) {
                $input.addClass('input-error');
                return false;
            } else {
                $input.removeClass('input-error');
                return true;
            }
        }

        function validateKriteria(select) {
            const $select = $(select);
            const value = $select.val();
            
            if (!value) {
                $select.addClass('select-error');
                return false;
            } else {
                $select.removeClass('select-error');
                return true;
            }
        }
    </script>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Alert info --}}
            <div class="mb-4 rounded-lg bg-blue-50 p-4 text-sm text-blue-800 dark:bg-gray-800 dark:text-blue-400"
                role="alert">
                <span class="font-medium">Info Sub Kriteria:</span>
                Sub kriteria digunakan untuk memberikan nilai detail pada setiap kriteria utama.
                Pastikan bobot sub kriteria sesuai dengan tingkat kepentingannya.
            </div>

            {{-- Awal Modal Create --}}
            <input type="checkbox" id="create_sub_kriteria" class="modal-toggle" />
            <div class="modal modal-middle fixed inset-0 z-50 flex items-center justify-center" role="dialog" style="align-items: flex-start; padding-top: 150px;">
                <div class="modal-box max-w-2xl relative mx-auto">
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

                            <button type="submit" class="btn btn-success mt-4 w-full text-white">
                                <i class="ri-save-line"></i>
                                Simpan Sub Kriteria
                            </button>
                        </form>
                    </div>
                </div>
                <label class="modal-backdrop" for="create_sub_kriteria"></label>
            </div>
            {{-- Akhir Modal Create --}}

            {{-- Awal Modal Edit --}}
            <input type="checkbox" id="edit_sub_kriteria" class="modal-toggle" />
            <div class="modal modal-middle fixed inset-0 z-50 flex items-center justify-center" role="dialog" style="align-items: flex-start; padding-top: 150px;">
                <div class="modal-box max-w-2xl relative mx-auto">
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
                            @method('PUT')
                            <input type="hidden" name="id">
                            <input type="hidden" name="kriteria_id">

                            {{-- Kriteria (read-only) --}}
                            <label class="form-control w-full mb-4">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        Kriteria
                                    </span>
                                    <span class="label-text-alt text-xs text-gray-500">Tidak dapat diubah</span>
                                </div>
                                <input type="text" name="kriteria_nama"
                                    class="input input-bordered w-full cursor-default bg-slate-100 text-primary-color"
                                    readonly />
                            </label>

                            {{-- Sub Kriteria (read-only) --}}
                            <label class="form-control w-full mb-4">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        Sub Kriteria
                                    </span>
                                    <span class="label-text-alt text-xs text-gray-500">Tidak dapat diubah</span>
                                </div>
                                <input type="text" name="sub_kriteria" 
                                    class="input input-bordered w-full cursor-default bg-slate-100 text-primary-color"
                                    readonly />
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
                                    placeholder="0-100" required />
                                @error('bobot')
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
                <label class="modal-backdrop" for="edit_sub_kriteria"></label>
            </div>
            {{-- Akhir Modal Edit --}}

            {{-- Script untuk membuka modal jika ada error --}}
            @if($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Jika ada error, buka modal edit
                        @if(old('id') && old('id') != '')
                            document.getElementById('edit_sub_kriteria').checked = true;
                            // Populate form dengan old data
                            setTimeout(function() {
                                $("input[name='id']").val("{{ old('id') }}");
                                $("input[name='kriteria_id']").val("{{ old('kriteria_id') }}");
                                $("input[name='kriteria_nama']").val("{{ old('kriteria_nama') }}");
                                $("input[name='sub_kriteria']").val("{{ old('sub_kriteria') }}");
                                $("input[name='bobot']").val("{{ old('bobot') }}");
                            }, 100);
                        @else
                            document.getElementById('create_sub_kriteria').checked = true;
                        @endif
                    });
                </script>
            @endif

            {{-- Tombol Aksi --}}
            <div role="alert"
                class="alert mb-5 flex items-center justify-between border-0 bg-secondary-color shadow-xl dark:bg-secondary-color-dark dark:shadow-secondary-color-dark/20">
                <h6 class="font-bold text-primary-color dark:text-white">Tabel-Tabel {{ $title }}</h6>
                <div>
                    <label for="create_sub_kriteria"
                        class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-white/70 px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2"
                        onclick="return create_button()">
                        <i class="ri-add-fill"></i>
                        Tambah
                    </label>
                    <label for="import_button"
                        class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-white/70 px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2">
                        <i class="ri-file-excel-2-line"></i>
                        Impor
                    </label>
                </div>
            </div>

            {{-- Tabel Sub Kriteria --}}
            <div
                class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                @foreach ($kriteria as $kri)
                    <div class="mb-5">
                        <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                            <h6 class="font-semibold text-primary-color dark:text-primary-color-dark">
                                Tabel {{ $title }}
                                <span class="font-bold text-primary-color-dark dark:text-primary-color">{{ $kri->kriteria }}</span>
                            </h6>
                        </div>
                        <div class="flex-auto px-0 pb-2 pt-0">
                            <div class="overflow-x-auto p-0 px-6 pb-6">
                                <table id="{{ 'myTable_' . $kri->id }}"
                                    class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                                    <thead class="align-bottom">
                                        <tr
                                            class="bg-primary-color text-xs font-bold uppercase text-white dark:bg-primary-color-dark dark:text-white">
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
                                                    <p
                                                        class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                        {{ $key + 1 }}.
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        class="text-left align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                        {{ $item->sub_kriteria }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        class="text-center align-middle text-base font-semibold leading-tight text-primary-color dark:text-primary-color-dark">
                                                        {{ $item->bobot }}%
                                                    </p>
                                                </td>
                                                <td>
                                                    <div class="text-center align-middle">
                                                        <label for="edit_sub_kriteria" class="btn btn-outline btn-warning btn-sm"
                                                            onclick="return edit_button('{{ $item->id }}')">
                                                            <i class="ri-pencil-line text-base"></i>
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
                @endforeach
            </div>
        </div>
    </div>
@endsection