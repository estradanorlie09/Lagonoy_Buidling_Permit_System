@include('partials._header')
@include('components.landing_page_navbar')

<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800">Forgot Your Password?</h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter your email and we'll send you a link to reset your password.
            </p>
        </div>

        @if (session('status'))
            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="mt-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" id="email" required autofocus value="{{ old('email') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
                    Send Password Reset Link
                </button>
            </div>

            <div class="mt-4 text-center text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Back to Login</a>
            </div>
        </form>
    </div>
</div>

@include('partials._footer')
