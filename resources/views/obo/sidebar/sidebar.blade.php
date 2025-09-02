<aside :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
    class="fixed z-30 inset-y-0 left-0 w-64 bg-black text-white transform md:translate-x-0 md:static md:inset-0 transition-transform duration-300 ease-in-out">
    <!-- Close Button (visible only on mobile) -->
    <div class="flex justify-end md:hidden p-4">
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
        <a href="#" class="block py-2 px-4 bg-red-600 rounded text-white">Overview</a>
        <a href="#" class="block py-2 px-4 hover:bg-gray-800 rounded">All Records</a>
        <a href="#" class="block py-2 px-4 hover:bg-gray-800 rounded">Schedules</a>
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
