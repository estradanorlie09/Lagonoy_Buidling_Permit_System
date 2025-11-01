<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin.</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center bg-[#012d2d] font-sans">

    <div
        class="w-full max-w-5xl mx-auto grid md:grid-cols-2 bg-[#012d2d] text-white rounded-lg overflow-hidden shadow-2xl">

        <div class="flex flex-col items-center justify-center py-20 border-r border-gray-700">
            <img src="{{ asset('asset/icon/logo.png') }}" alt="Logo" class="w-20 h-20 mb-6">
            <h1 class="text-2xl font-light tracking-wide">Lagonoy Building Permit System Admin</h1>
        </div>
        <div class="flex flex-col items-center justify-center py-20 px-8">
            <h2 class="text-3xl font-light mb-2">Welcome</h2>
            <p class="text-gray-300 mb-8 text-sm uppercase tracking-wider">
                Please login to admin dashboard.
            </p>

            <form action="{{ route('login.submit_admin') }}" method="POST" class="w-full max-w-sm space-y-5">
                @csrf
                <div class="hidden">
                    <input type="text" name="role" value="admin"
                        class="w-full px-4 py-3 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email"
                        class="w-full px-4 py-3 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required>
                </div>

                <div>
                    <input type="password" name="password" placeholder="Password"
                        class="w-full px-4 py-3 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-md transition">
                        Login
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="text-gray-300 hover:text-orange-400 text-sm">
                        Forgotten your password?
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
