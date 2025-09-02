<aside :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
    class="fixed z-30 inset-y-0 left-0 w-64 bg-black text-white transform transition-transform duration-300 ease-in-out">
    <!-- Close Button (visible on all screen sizes) -->
    <div class="flex justify-end p-4">
        <button @click="sidebarOpen = false" class="text-white text-2xl">
            &times;
        </button>
    </div>

    <!-- Logo -->
    <div class="flex items-center justify-center h-24 border-b border-gray-700">
        <img class="w-15 h-15" src="{{ asset('asset/icon/logo.png') }}" alt="logo">
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('applicant.dashboard') }}"
            class="block py-2 px-4 rounded transition duration-150 flex gap-3
   {{ request()->routeIs('applicant.dashboard') ? 'bg-red-600 text-white' : 'hover:bg-gray-800 text-white' }}">
            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                </svg>

            </span>Overview
        </a>

        <a href="{{ route('applicant.records') }}"
            class="block py-2 px-4 rounded transition duration-150 flex gap-3
   {{ request()->routeIs('applicant.records') ? 'bg-red-600 text-white' : 'hover:bg-gray-800 text-white' }}">
            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                </svg>
            </span>Projects
        </a>




        <a href="{{ route('applicant.calendar.schedule') }}"
            class="block py-2 px-4 rounded transition duration-150 flex gap-3
   {{ request()->routeIs('applicant.calendar.schedule') ? 'bg-red-600 text-white' : 'hover:bg-gray-800 text-white' }}">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                </svg></span>Schedules
        </a>

    </nav>

    <!-- Logout -->
    <div class="p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-2 bg-gray-800 rounded hover:bg-gray-700">
                Logout
            </button>
        </form>
    </div>
</aside>
