<nav class="bg-gray-700 shadow-md z-50 sticky top-0 z-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-24">
            <!-- logo -->
            <div class="flex items-center gap-3">
                <a href="{{ route('homepage') }}"> <img class="w-15 h-15" src="{{ asset('asset/icon/logo.png') }}"
                        alt="logo">
                </a>
                <a href="{{ route('homepage') }}"><span class="text-x1 font-bold text-white">Epermit</span></a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('homepage') }}" class="text-white hover:text-red-600 transition">Home</a>
                <a href="#" class="text-white hover:text-red-600 transition">Product</a>
                <a href="#" class="text-white hover:text-red-600 transition">Services</auto>
                    <a href="#" class="text-white hover:text-red-600 transition">About</a>
                    <a href="#" class="text-white hover:text-red-600 transition">Contact</a>
            </div>


            @unless (Request::routeIs('login') || Request::routeIs('signup'))
                <div class="flex gap-4 sm:flex hidden lg:flex hidden">
                    <a href="{{ route('signup') }}"
                        class="p-2.5 border border-white rounded text-white w-25 text-center">Signup</a>
                    <a href="{{ route('login') }}" class="p-2.5 bg-red-600 rounded text-white w-25 text-center">Login</a>
                </div>
            @endunless


            <!-- Hamburger Icon -->
            <div class="md:hidden flex items-center">
                <button onclick="toggleMenu()" aria-label="Toggle menu">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>

                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 space-y-2">
        <href="#" class="block text-white hover:text-red-600 transition">Home</a>
        <a href="#" class="block text-white hover:text-red-600 transition">Product</a>
        <a href="#" class="block text-white hover:text-red-600 transition">Services</a>
        <a href="#" class="block text-white hover:text-red-600 transition">About</a>
        <a href="#" class="block text-white hover:text-red-600 transition">Contact</a>
        <hr />
        @unless (Request::routeIs('login') || Request::routeIs('signup'))
            <a href="{{ route('signup') }}" class="block text-white hover:text-red-600 transition">Sign Up</a>
            <a href="{{ route('login') }}"
                class="block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition mt-2">Login</a>
        @endunless


    </div>
</nav>

<script>
    function toggleMenu() {
        const menu = document.getElementById("mobile-menu");
        menu.classList.toggle("hidden");

    }
</script>
