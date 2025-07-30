<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BPNT Cirebon</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body
    class="bg-gradient-to-tr from-blue-400 via-purple-500 to-indigo-500 min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full max-w-5xl grid grid-cols-1 md:grid-cols-2">
        <!-- Form Side -->
        <div class="p-10 flex flex-col justify-center">
            <div class="mb-6">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/Niagahoster_logo_2021.svg/512px-Niagahoster_logo_2021.svg.png"
                    alt="Logo" class="h-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Login Member Area</h2>
            </div>
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm text-gray-600">E-mail</label>
                    <input type="email" name="email"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="e.g. john.doe@gmail.com" required>
                </div>
                <div>
                    <label class="block text-sm text-gray-600">Password</label>
                    <input type="password" name="password"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">Forgot Password?</a>
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white py-2 rounded-lg hover:opacity-90 transition duration-200">Login</button>
            </form>
            <p class="text-sm text-center text-gray-500 mt-6">Don't have an account? <a href="{{ route('register') }}"
                    class="text-blue-500 hover:underline">Sign Up</a></p>
        </div>

        <!-- Illustration Side -->
        <div class="hidden md:block relative">
            <img src="{{ asset('assets/images/login-illustration.jpeg') }}" alt="Illustration"
                class="object-cover w-full h-full">
            <div class="absolute inset-0 bg-black opacity-10"></div>
        </div>
    </div>

</body>

</html>