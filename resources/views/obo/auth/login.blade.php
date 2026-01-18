<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Building Officer Portal</title>
    @vite('resources/css/app.css')
</head>

<body
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 font-sans">

    <div
        class="w-full max-w-5xl mx-auto grid md:grid-cols-2 bg-slate-800 text-white rounded-lg overflow-hidden shadow-2xl">

        <!-- Left Section - Branding -->
        <div
            class="flex flex-col items-center justify-center py-20 px-8 border-r border-slate-700 bg-gradient-to-b from-slate-700 to-slate-800">
            <div class="rounded-full mb-6 flex items-center justify-center">
                <img src="{{ asset('asset/icon/logo.png') }}" alt="Building Icon" class="w-32 h-32 object-contain">
            </div>

            <h1 class="text-2xl font-bold tracking-wide text-center">Lagonoy Building Permit </h1>
            <p class="text-slate-300 text-sm mt-2 text-center">Building Official Login</p>

            <div class="mt-12 space-y-6 text-sm text-slate-300">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-400 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Secure authentication</span>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-400 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Real-time permit tracking</span>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-400 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Comprehensive inspections</span>
                </div>
            </div>
        </div>

        <!-- Right Section - Login Form -->
        <div class="flex flex-col items-center justify-center py-20 px-8">
            <div class="w-full max-w-sm">
                <h2 class="text-3xl font-bold mb-2">Welcome Back</h2>
                <p class="text-slate-300 mb-8 text-sm uppercase tracking-wider">
                    Sign in to your officer account
                </p>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-500/20 border border-red-500/50">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p class="text-red-300 text-sm">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login.submit') }}"method="POST" class="space-y-5">
                    @csrf

                    <!-- Hidden role field -->
                    <div class="hidden">
                        <input type="text" name="role" value="obo">
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label class="block text-slate-300 text-sm font-medium mb-2">Email Address</label>
                        <input type="email" name="email" placeholder="officer@buildingdept.gov"
                            class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 ring-2 ring-red-500 @enderror"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label class="block text-slate-300 text-sm font-medium mb-2">Password</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 ring-2 ring-red-500 @enderror"
                            required>
                        @error('password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded bg-slate-700 border-slate-600 text-blue-500 focus:ring-blue-500 cursor-pointer">
                        <label for="remember" class="ml-2 text-slate-300 text-sm cursor-pointer">
                            Remember me
                        </label>
                    </div>

                    <!-- Login Button -->
                    <div>
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v2a2 2 0 01-2 2H7a2 2 0 01-2-2v-2m14-4V7a2 2 0 00-2-2H7a2 2 0 00-2 2v2" />
                            </svg>
                            Sign In
                        </button>
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="text-center pt-2">
                        <a href="{{ route('password.request') }}"
                            class="text-slate-400 hover:text-blue-400 text-sm transition">
                            Forgot your password?
                        </a>
                    </div>
                </form>



                <!-- Support Info -->
                <div class="mt-6 pt-6 border-t border-slate-700 text-center">
                    <p class="text-slate-400 text-xs">
                        Need help? Contact support at
                        <span class="text-blue-400">support@buildingdept.gov</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
