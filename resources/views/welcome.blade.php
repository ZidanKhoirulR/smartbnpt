<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BPNT - Bantuan Pangan Non Tunai</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-gray-900">BPNT</h1>
                        <span class="ml-2 text-sm text-gray-600">Bantuan Pangan Non Tunai</span>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Login Admin
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Hero Section -->
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Cek Status Bantuan BPNT
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Masukkan NIK Anda untuk mengecek status penerimaan Bantuan Pangan Non Tunai (BPNT).
                        Sistem menentukan <span class="font-semibold text-blue-600">150 penerima bantuan</span> berdasarkan prioritas kebutuhan.
                    </p>
                </div>

                <!-- Search Form -->
                <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6 mb-8">
                    <form action="{{ route('search.nik') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                Masukkan NIK Anda
                            </label>
                            <input 
                                type="text" 
                                id="nik" 
                                name="nik" 
                                maxlength="16"
                                placeholder="Contoh: 3201234567890001"
                                class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center tracking-wider"
                                value="{{ old('nik') }}"
                                required
                                autocomplete="off"
                            >
                            @error('nik')
                                <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 text-center">
                                Masukkan 16 digit NIK sesuai KTP Anda
                            </p>
                        </div>
                        <button 
                            type="submit" 
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors text-lg font-medium"
                        >
                            🔍 Cek Status Bantuan BPNT
                        </button>
                    </form>
                </div>

                <!-- Error Message -->
                @if(session('error'))
                    <div class="max-w-md mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-8">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Results -->
                @if(session('success') && session('result'))
                    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6 mb-8">
                        <div class="text-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-900">Hasil Pencarian</h3>
                        </div>

                        @php $result = session('result'); @endphp

                        <div class="space-y-4">
                            <div class="text-center">
                                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium mb-2
                                    {{ $result->status == 'Diterima' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $result->status == 'Diterima' ? '✅ DITERIMA' : '❌ TIDAK DITERIMA' }}
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">NIK:</span>
                                    <span class="text-sm font-mono text-gray-900">{{ $result->nik }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Nama:</span>
                                    <span class="text-sm text-gray-900 font-medium">{{ $result->alternatif }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Peringkat:</span>
                                    <span class="text-sm font-bold text-blue-600">{{ $result->ranking }} dari {{ \App\Models\Alternatif::count() }} kandidat</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Skor Total:</span>
                                    <span class="text-sm text-gray-900">{{ number_format($result->nilai, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        @if($result->status == 'Diterima')
                            <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg text-center">
                                <div class="text-green-600 text-2xl mb-2">🎉</div>
                                <h4 class="text-green-800 font-semibold mb-2">Selamat!</h4>
                                <p class="text-green-700 text-sm">
                                    Anda masuk dalam <strong>150 penerima bantuan BPNT</strong>.<br>
                                    Silakan tunggu informasi lebih lanjut dari petugas desa/kelurahan.
                                </p>
                            </div>
                        @else
                            <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg text-center">
                                <div class="text-red-600 text-2xl mb-2">💪</div>
                                <h4 class="text-red-800 font-semibold mb-2">Tetap Semangat!</h4>
                                <p class="text-red-700 text-sm">
                                    Anda belum masuk dalam 150 penerima bantuan BPNT periode ini.<br>
                                    Jangan berkecil hati, masih ada kesempatan di periode berikutnya.
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Info Section -->
                <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Program BPNT</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Kriteria Penerima:</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Pendapatan keluarga rendah</li>
                                <li>• Jumlah tanggungan keluarga</li>
                                <li>• Kondisi tempat tinggal</li>
                                <li>• Status kepemilikan rumah</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Metode Seleksi:</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Menggunakan metode SMARTER</li>
                                <li>• Penilaian objektif berdasarkan data</li>
                                <li>• Ranking berdasarkan total skor</li>
                                <li>• Maksimal 150 penerima per periode</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <p class="text-center text-sm text-gray-500">
                    © 2025 Sistem BPNT. Semua hak dilindungi.
                </p>
            </div>
        </footer>
    </div>

    <!-- JavaScript untuk validasi NIK -->
    <script>
        document.getElementById('nik').addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Hanya izinkan angka
            value = value.replace(/[^0-9]/g, '');
            
            // Batasi 16 karakter
            if (value.length > 16) {
                value = value.substring(0, 16);
            }
            
            e.target.value = value;
            
            // Update placeholder untuk menunjukkan progress
            const remaining = 16 - value.length;
            if (value.length > 0 && value.length < 16) {
                e.target.style.borderColor = '#f59e0b';
                e.target.style.backgroundColor = '#fffbeb';
            } else if (value.length === 16) {
                e.target.style.borderColor = '#10b981';
                e.target.style.backgroundColor = '#f0fdf4';
            } else {
                e.target.style.borderColor = '#d1d5db';
                e.target.style.backgroundColor = '#ffffff';
            }
        });

        // Format NIK saat mengetik untuk kemudahan membaca
        document.getElementById('nik').addEventListener('keyup', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = '';
            
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            
            // Hanya update jika berbeda untuk menghindari cursor jump
            if (e.target.value !== formattedValue) {
                const cursorPos = e.target.selectionStart;
                e.target.value = formattedValue;
                
                // Restore cursor position
                let newPos = cursorPos;
                if (formattedValue.length > value.length) {
                    newPos = cursorPos + (formattedValue.length - value.length);
                }
                e.target.setSelectionRange(newPos, newPos);
            }
        });

        // Remove spaces before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const nikInput = document.getElementById('nik');
            nikInput.value = nikInput.value.replace(/\s/g, '');
        });
    </script>
</body>
</html>