<aside :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
    class="fixed inset-y-0 left-0 w-72 bg-gradient-to-b from-slate-900 to-slate-800 shadow-2xl transform transition-transform duration-300 ease-in-out z-50">

    <!-- Header Section -->
    <div class="relative bg-slate-800/50 border-b border-slate-700">
        <!-- Close Button -->
        <button @click="sidebarOpen = false"
            class="absolute top-4 right-4 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg p-2 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Logo and Title -->
        <div class="flex flex-col items-center py-6 px-6">
            <div class="w-16 h-16 rounded-xl flex items-center justify-center shadow-lg mb-3">
                <img class="w-16 h-16" src="{{ asset('asset/icon/logo.png') }}" alt="Logo">
            </div>

            @if (Auth::check() && Auth::user()->role === 'applicant')
                <h2 class="text-white font-semibold text-lg">Applicant Portal</h2>
                <p class="text-slate-400 text-xs mt-1">
                    Lagonoy Building Permit System
                </p>
            @elseif (Auth::check() && Auth::user()->role === 'obo')
                <h2 class="text-white font-semibold text-lg">Building Official Portal</h2>
                <p class="text-slate-400 text-xs mt-1">
                    Office of the Building Official
                </p>
            @endif
        </div>

    </div>

    <!-- Navigation Section -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        @if (Auth::user()->role === 'applicant')
            <a href="{{ route('applicant.dashboard') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('applicant.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-tachometer-alt w-5 text-center {{ request()->routeIs('applicant.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Overview</span>
            </a>

            <a href="{{ route('applicant.buildingPermit') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('applicant.buildingPermit') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-building w-5 text-center {{ request()->routeIs('applicant.buildingPermit') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Building Permit</span>
            </a>

            <a href="{{ route('applicant.calendar.schedule') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('applicant.calendar.schedule') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-calendar-alt w-5 text-center {{ request()->routeIs('applicant.calendar.schedule') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Schedules</span>
            </a>

            <a href="{{ route('applicant.setting') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('applicant.setting') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-cog w-5 text-center {{ request()->routeIs('applicant.setting') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Settings</span>
            </a>
        @elseif (Auth::user()->role === 'obo')
            <a href="{{ route('obo.dashboard') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('obo.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-tachometer-alt w-5 text-center {{ request()->routeIs('obo.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <a href="{{ route('obo.buildingApplicantRecord') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('obo.buildingApplicantRecord') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fa-solid fa-user-shield w-5 text-center {{ request()->routeIs('obo.buildingApplicantRecord') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Applicant Verification</span>
            </a>

            <a href="{{ route('obo.buildingApplicationRecord') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('obo.buildingApplicationRecord') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-folder-open w-5 text-center {{ request()->routeIs('obo.buildingApplicationRecord') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Building Applications</span>
            </a>

            <a href="{{ route('obo.obo_visitation') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('obo.obo_visitation') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-calendar w-5 text-center {{ request()->routeIs('obo.obo_visitation') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Visitation Scheduler</span>
            </a>

            <a href="{{ route('applicant.setting') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('applicant.setting') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-cog w-5 text-center {{ request()->routeIs('applicant.setting') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Settings</span>
            </a>
        @elseif (Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-tachometer-alt w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.user_records') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('admin.user_records') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-users w-5 text-center {{ request()->routeIs('admin.user_records') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Users</span>
            </a>

            <a href="{{ route('admin.admin_accounts') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                {{ request()->routeIs('admin.admin_accounts') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/50' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <i
                    class="fas fa-user-shield w-5 text-center {{ request()->routeIs('admin.admin_accounts') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                <span class="font-medium text-sm">Admin Accounts</span>
            </a>
        @endif
    </nav>

    <!-- Logout Section -->
    @auth
        <div class="p-4 border-t border-slate-700 bg-slate-800/30">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-slate-700/50 hover:bg-blue-900 text-slate-300 hover:text-white rounded-lg transition-all duration-200 font-medium text-sm group">
                    <i class="fas fa-sign-out-alt text-slate-400 group-hover:text-white"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    @endauth

</aside>
