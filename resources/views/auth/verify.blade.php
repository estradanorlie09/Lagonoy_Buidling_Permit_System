@include('partials._header')
@include('components.landing_page_navbar')

<div class="flex items-center justify-center min-h-screen bg-gray-50 p-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Email Verification</h2>
            <p class="text-gray-600 text-sm">Enter the 6-digit verification code sent to your email</p>
        </div>

        <!-- Form -->
        <form method="POST" action="#" class="space-y-4">
            @csrf
            <div>
                <label for="verification_code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                <input type="text" name="verification_code" id="verification_code" maxlength="6"
                    placeholder="Enter 6-digit code"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 text-center text-lg tracking-widest"
                    required>
                @error('verification_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-md transition">
                Verify Code
            </button>
        </form>

        <!-- Resend Code -->
        <p class="text-center text-gray-500 text-sm mt-4">
            Didn't receive the code?
            <button id="resendBtn" disabled class="text-red-500 font-medium hover:underline cursor-pointer">Resend
                (60s)</button>
        </p>
    </div>
</div>

<script>
    const resendBtn = document.getElementById('resendBtn');
    let timer = 60; // seconds

    // Countdown for resend
    const countdown = setInterval(() => {
        if (timer > 0) {
            resendBtn.textContent = `Resend (${timer}s)`;
            timer--;
        } else {
            resendBtn.textContent = 'Resend';
            resendBtn.disabled = false;
            clearInterval(countdown);
        }
    }, 1000);

    // Optional: Handle resend click
    resendBtn.addEventListener('click', () => {
        resendBtn.disabled = true;
        timer = 60;
        // TODO: Send request to backend to resend code
        // Example using fetch:
        fetch("{{ route('verification.resend')}}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => {
            alert('Verification code resent!');
            // Restart countdown
            const newCountdown = setInterval(() => {
                if (timer > 0) {
                    resendBtn.textContent = `Resend (${timer}s)`;
                    timer--;
                } else {
                    resendBtn.textContent = 'Resend';
                    resendBtn.disabled = false;
                    clearInterval(newCountdown);
                }
            }, 1000);
        });
    });

    // Optional: Auto-focus & restrict input to numbers only
    const codeInput = document.getElementById('verification_code');
    codeInput.addEventListener('input', () => {
        codeInput.value = codeInput.value.replace(/\D/g, '').slice(0, 6);
    });
</script>


@include('partials._footer')
