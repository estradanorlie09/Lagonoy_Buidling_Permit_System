{{-- <nav class="bg-gray-700 shadow-md sticky top-0 z-100">
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
</nav> --}}
{{-- TOP INFO BAR --}} <div class="bg-gradient-to-r from-blue-800 to-red-600 text-white text-xs sm:text-sm">
    <div class="max-w-7xl mx-auto px-4 py-2 flex flex-col sm:flex-row sm:justify-between gap-1">
        <span>Lagonoy Building Permit Management System</span>
        <span>Hotline: 1234 | Email: buildingpermit@gov.ph</span>
    </div>
    </div>

    {{-- HEADER --}}
    <header class="bg-white shadow sticky top-0 z-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">

            {{-- LEFT: LOGO + TITLE --}}
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 sm:w-16 sm:h-16  rounded-full overflow-hidden">
                    <img src="{{ asset('asset/icon/logo.png') }}" alt="LGU Logo" class="w-full h-full object-cover">
                </div>

                <div class="hidden sm:block">
                    <h1 class="text-lg sm:text-xl font-bold text-blue-800">
                        Lagonoy Building Permit Application Portal
                    </h1>
                    <p class="text-sm text-gray-600">
                        Office of the Building Official – Local Government Unit
                    </p>
                </div>
            </div>

            {{-- DESKTOP ACTIONS --}}
            @guest
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-lg border border-blue-700 text-blue-700
                       font-semibold text-sm hover:bg-blue-50 transition">
                        Login
                    </a>

                    <a href="{{ route('signup') }}"
                        class="px-4 py-2 rounded-lg bg-blue-700 text-white
                       font-semibold text-sm hover:bg-blue-800 transition">
                        Pre-Register
                    </a>
                </div>
            @endguest

            {{-- HAMBURGER (MOBILE) --}}
            <button onclick="toggleMenu()" class="md:hidden">
                <svg class="w-7 h-7 text-blue-800" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    {{-- DESKTOP NAV --}}
    <nav class="bg-blue-800 hidden md:block">
        <div class="max-w-7xl mx-auto flex justify-center">
            <a href="{{ route('homepage') }}" class="px-6 py-4 text-white hover:bg-blue-900">Home</a>
            <a href="#" class="px-6 py-4 text-white hover:bg-blue-900">Guide</a>
            <a href="#" class="px-6 py-4 text-white hover:bg-blue-900">Track Application</a>
            <a href="#" class="px-6 py-4 text-white hover:bg-blue-900">Requirements</a>
            <a href="#" class="px-6 py-4 text-white hover:bg-blue-900">Contact Us</a>
        </div>
    </nav>

    {{-- MOBILE MENU --}}
    <div id="mobile-menu" class="hidden md:hidden bg-blue-800 text-white">
        <div class="flex flex-col divide-y divide-blue-700">
            <a href="{{ route('homepage') }}" class="px-4 py-3 hover:bg-blue-900">Home</a>
            <a href="#" class="px-4 py-3 hover:bg-blue-900">Guide</a>
            <a href="#" class="px-4 py-3 hover:bg-blue-900">Track Application</a>
            <a href="#" class="px-4 py-3 hover:bg-blue-900">Requirements</a>
            <a href="#" class="px-4 py-3 hover:bg-blue-900">Contact Us</a>

            @guest
                <div class="p-4 space-y-2">
                    <a href="{{ route('login') }}" class="block text-center border border-white py-2 rounded">
                        Login
                    </a>

                    <a href="{{ route('signup') }}"
                        class="block text-center bg-white text-blue-800 py-2 rounded font-semibold">
                        Pre-Register
                    </a>
                </div>
            @endguest
        </div>
    </div>

    {{-- MOBILE MENU SCRIPT --}}
    <script>
        function toggleMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
