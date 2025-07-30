<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Urbanist', sans-serif;
            background: linear-gradient(135deg, #f107a3, #7b2ff7, #00ffe7);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .glass {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0.05));
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35), inset 0 0 0 1px rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease-in-out;
        }

        .glass:hover {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.45), inset 0 0 0 1px rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }

        .btn-fancy {
            background: linear-gradient(to right, #ffcc70, #ff7eb3);
            color: black;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
        }

        .btn-fancy:hover {
            transform: scale(1.05);
            background: linear-gradient(to right, #ff7eb3, #ffcc70);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">
    <div class="glass w-full max-w-md p-8 space-y-6 text-white relative border border-white/40">
        <div class="flex justify-center">
            <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Avatar"
                class="w-20 h-20 rounded-full border-4 border-white shadow-lg">
        </div>

        <div class="text-center">
            <h1 class="text-3xl font-extrabold">Selamat Datang</h1>
            <p class="text-sm text-white/80 mt-2">Silakan masuk untuk melanjutkan ke SMART SPK</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Notifikasi session error --}}
            @if(session('error'))
                <div id="errorAlert"
                    class="flex items-center justify-between gap-2 p-3 border border-red-300 bg-red-100 text-red-700 text-sm rounded-md shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-9 4h2v2H9v-2zm0-8h2v6H9V6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="document.getElementById('errorAlert').remove()"
                        class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif


            {{-- Validasi --}}
            @if($errors->any())
                <div id="loginErrorAlert"
                    class="flex items-start justify-between gap-2 p-3 border border-red-300 bg-red-100 text-red-700 text-sm rounded-md shadow-sm">
                    <div class="flex gap-2">
                        {{-- Alert Icon --}}
                        <svg class="w-5 h-5 mt-0.5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-9 4h2v2H9v-2zm0-8h2v6H9V6z"
                                clip-rule="evenodd" />
                        </svg>

                        {{-- Error Message(s) --}}
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Close Button --}}
                    <button onclick="document.getElementById('loginErrorAlert').remove()"
                        class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif


            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 rounded-md bg-white/90 text-black focus:outline-none focus:ring-2 focus:ring-pink-400">
                <p id="email-error" class="text-red-500 text-sm mt-1 hidden">Email harus mengandung simbol '@'.</p>
            </div>

            {{-- Password --}}
            <div class="relative">
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 rounded-md bg-white/90 text-black focus:outline-none focus:ring-2 focus:ring-pink-400 pr-10">
                <span class="absolute right-3 bottom-2 cursor-pointer" onclick="togglePassword()">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeOff" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 012.588-4.263m3.105-2.106A9.969 9.969 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.134 5.129M15 12a3 3 0 01-3 3m0 0a3 3 0 01-3-3m6 0a3 3 0 01-6 0m12 0c0-1.045-.162-2.05-.462-3M3 3l18 18" />
                    </svg>
                </span>
            </div>

            {{-- Remember Me --}}
            <div class="flex justify-between items-center">
                <label class="flex items-center text-sm">
                    <input type="checkbox" name="remember" class="mr-2">
                    Ingat saya
                </label>
            </div>

            {{-- Tombol Login --}}
            <button id="login-btn" type="submit" class="btn-fancy w-full flex items-center justify-center gap-2">
                <span id="btn-text">Masuk</span>
                <svg id="loading-spinner" class="w-4 h-4 animate-spin hidden" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeOff = document.getElementById('eyeOff');

            const isVisible = passwordInput.type === 'text';
            passwordInput.type = isVisible ? 'password' : 'text';
            eyeOpen.classList.toggle('hidden', !isVisible);
            eyeOff.classList.toggle('hidden', isVisible);
        }

        const emailInput = document.getElementById('email');
        const errorElement = document.getElementById('email-error');
        emailInput.addEventListener('input', () => {
            if (!emailInput.value.includes('@')) {
                errorElement.classList.remove('hidden');
            } else {
                errorElement.classList.add('hidden');
            }
        });

        const rememberCheckbox = document.querySelector('input[name="remember"]');
        document.addEventListener("DOMContentLoaded", () => {
            const savedEmail = localStorage.getItem('rememberedEmail');
            if (savedEmail) {
                emailInput.value = savedEmail;
                rememberCheckbox.checked = true;
            }
        });

        document.querySelector('form').addEventListener('submit', (e) => {
            const btn = document.getElementById('login-btn');
            const spinner = document.getElementById('loading-spinner');
            const text = document.getElementById('btn-text');

            btn.disabled = true;
            spinner.classList.remove('hidden');
            text.textContent = 'Memproses...';

            if (rememberCheckbox.checked) {
                localStorage.setItem('rememberedEmail', emailInput.value);
            } else {
                localStorage.removeItem('rememberedEmail');
            }
        });
    </script>
</body>

</html>