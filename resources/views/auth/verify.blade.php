@include('partials._header')
@include('components.landing_page_navbar')

<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800">Email Verification Required</h2>
            <p class="mt-2 text-sm text-gray-600">
                Please verify your email address before continuing.
            </p>
        </div>

        @if (session('message'))
            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="mt-6" id="resend-form">
            @csrf
            <button type="submit" id="resend-button"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
                Resend Verification Email
            </button>
            <p id="countdown-text" class="text-sm text-gray-500 text-center mt-2 hidden">
                Please wait <span id="countdown">60</span> seconds to resend.
            </p>
        </form>

        <p class="mt-4 text-sm text-gray-500 text-center">
            Didn’t receive the email? Check your spam folder or try resending.
        </p>
    </div>
</div>

@if (Auth::check() && Auth::user()->hasVerifiedEmail())
    <script>
        window.location.href = "{{ route('login') }}";
    </script>
@endif

<script>
    const form = document.getElementById('resend-form');
    const button = document.getElementById('resend-button');
    const countdownText = document.getElementById('countdown-text');
    const countdown = document.getElementById('countdown');

    form.addEventListener('submit', function(e) {
        // Prevent the form from instantly resubmitting
        button.disabled = true;
        button.classList.add('opacity-50', 'cursor-not-allowed');
        countdownText.classList.remove('hidden');

        let seconds = 60;
        countdown.innerText = seconds;

        const interval = setInterval(() => {
            seconds--;
            countdown.innerText = seconds;

            if (seconds <= 0) {
                clearInterval(interval);
                button.disabled = false;
                countdownText.classList.add('hidden');
                button.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }, 1000);
    });
</script>

@include('partials._footer')
