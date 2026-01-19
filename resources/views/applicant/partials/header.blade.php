<!-- Top Bar with Country and Contact Info -->
<div class="bg-gradient-to-r from-blue-700 via-purple-600 to-purple-700 text-white py-2 px-4 lg:px-8">
    <div class="flex justify-between items-center text-sm">
        <span class="font-medium">Republic of the Philippines</span>
        <div class="hidden sm:flex items-center gap-2">
            <span>Hotline: 1234</span>
            <span class="text-white/60">|</span>
            <span>Email: buildingpermit@gov.ph</span>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="bg-white shadow-md">
    <div class="px-4 lg:px-8 py-4">
        <div class="flex items-center justify-between">
            <!-- Left Section: Hamburger + Logo + Title -->
            <div class="flex items-center gap-4">
                <!-- Hamburger Menu (Mobile) -->
                {{-- <button @click="sidebarOpen = !sidebarOpen"
                    class="text-slate-600 hover:text-slate-900 focus:outline-none lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button> --}}

                <!-- Logo and Title -->
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

            </div>

            <!-- Right Section: User Profile and Logout -->
            <div class="flex items-center gap-3">
                <!-- User Profile Circle -->
                <div class="flex items-center gap-2 bg-slate-50 rounded-full pl-1 pr-3 py-1 border border-slate-200">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                    </div>

                    <span class="text-sm font-semibold text-slate-700 hidden sm:inline">
                        {{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }}
                    </span>
                </div>


                {{-- <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-800 transition-colors shadow-md">
                        Logout
                    </button>
                </form> --}}
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->

    @if (Auth::check() && Auth::user()->role === 'applicant')
        <nav class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-700 text-white">
            <div class="px-4 lg:px-8">
                <ul class="flex justify-center items-center gap-1 overflow-x-auto">
                    <li>
                        <a href="{{ route('applicant.dashboard') }}"
                            class="block px-6 py-3.5 hover:bg-blue-600 transition-colors font-medium whitespace-nowrap {{ request()->routeIs('applicant.dashboard') ? 'bg-blue-800' : '' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('applicant.dashboard') }}"
                            class="block px-6 py-3.5 hover:bg-blue-600 transition-colors font-medium whitespace-nowrap {{ request()->routeIs('applicant.dashboard') ? 'bg-blue-800' : '' }}">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('applicant.buildingPermit') }}"
                            class="block px-6 py-3.5 hover:bg-blue-600 transition-colors font-medium whitespace-nowrap {{ request()->routeIs('applicant.buildingPermit') ? 'bg-blue-800' : '' }}">
                            New Application
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-6 py-3.5 hover:bg-blue-600 transition-colors font-medium whitespace-nowrap">
                            Track Application
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-6 py-3.5 hover:bg-blue-600 transition-colors font-medium whitespace-nowrap">
                            Requirements
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    @endif
</header>

<!-- Alternative: Simple Dashboard Header with Hamburger -->
<header class="bg-white border-b border-slate-200 shadow-sm">
    <div class="flex items-center justify-between px-4 lg:px-8 py-3">
        <!-- Hamburger -->
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-600 hover:text-slate-900 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- User Greeting and Info -->
        <div class="flex-1 ml-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <!-- Left: Greeting and Role -->
                <div>
                    <h1 id="greeting" class="text-lg font-bold text-blue-700">
                        Good Morning!
                    </h1>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span>
                            {{ Auth::user()->role === 'zoning_officer' ? 'Zoning Officer' : ucwords(Auth::user()->role) }}
                            | {{ ucwords(Auth::user()->profession) }}
                        </span>
                    </div>
                </div>

                <!-- Right: Date and Time -->
                <div class="hidden sm:block">
                    <div class="flex items-center gap-2 text-sm text-slate-600 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                        </svg>
                        <span id="date">Loading date...</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span id="time">Loading time...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Greeting based on time of day
    function updateGreeting() {
        const hour = new Date().getHours();
        const greetingEl = document.getElementById('greeting');

        if (!greetingEl) return;

        if (hour < 12) {
            greetingEl.textContent = 'Good Morning!';
        } else if (hour < 18) {
            greetingEl.textContent = 'Good Afternoon!';
        } else {
            greetingEl.textContent = 'Good Evening!';
        }
    }

    // Update date
    function updateDate() {
        const dateEl = document.getElementById('date');
        if (!dateEl) return;

        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const date = new Date().toLocaleDateString('en-US', options);
        dateEl.textContent = date;
    }

    // Update time
    function updateTime() {
        const timeEl = document.getElementById('time');
        if (!timeEl) return;

        const time = new Date().toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        timeEl.textContent = time;
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        updateGreeting();
        updateDate();
        updateTime();

        // Update time every second
        setInterval(updateTime, 1000);
    });
</script>
