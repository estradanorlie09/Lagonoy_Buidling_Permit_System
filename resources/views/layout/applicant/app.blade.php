<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    
    {{-- alpine --}}
    <script src="//unpkg.com/alpinejs" defer></script>
   
    {{-- alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
    {{-- calendar --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    {{-- tailwind --}}
    @vite('resources/css/app.css')
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Adjust as needed --}}
  
    {{-- data table --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    {{-- for tooltip --}}
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/flowbite/dist/flowbite.min.js"></script>
</head>

<body x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">

    {{-- Sidebar --}}
    @include('applicant.sidebar.sidebar')

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}

        @include('applicant.partials.header')

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
            @yield('form')
            @yield('zoning_form')
            @yield('schedule')
            @yield('permit')
            @yield('setting')
            @yield('update_profile')
            @yield('safety_clarance')
        </main>

        {{-- Optional Footer --}}
        @include('partials._footer')
    </div>

    {{-- Greeting Script --}}
    <script>
        const firstName = @json(ucwords(Auth::user()->first_name));

        function updateGreeting() {
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            const ampm = hours < 12 ? 'AM' : 'PM';
            const formattedHours = ((hours + 11) % 12 + 1);
            const formattedMinutes = minutes.toString().padStart(2, '0');
            const formattedTime = `${formattedHours}:${formattedMinutes} ${ampm}`;
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString(undefined, options);

            let greeting = "🌤️Good Morning";
            if (hours >= 12 && hours < 17) greeting = "🌤️Good Afternoon";
            else if (hours >= 17 || hours < 5) greeting = "🌒Good Evening";

            document.getElementById('greeting').textContent = `${greeting}, ${firstName}!`;
            document.getElementById('date').textContent = formattedDate;
            document.getElementById('time').textContent = formattedTime;
        }

        updateGreeting();
        setInterval(updateGreeting, 60000);
    </script>
</body>

</html>
