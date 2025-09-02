@include('partials._header')

<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    @include('obo.sidebar.sidebar')

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top Bar -->
        <header class="flex items-center justify-between px-4 py-3 bg-white border-b">
            <!-- Hamburger -->
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div id="greeting-container" class="flex w-full justify-between">
                <div class="ml-4">
                    <div class="flex items-center">
                        <h1 id="greeting" class="text-lg text-red-500 font-semibold">Loading greeting...</h1>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        @php
                            $role = Auth::user()->role;
                            $roleNames = [
                                'applicant' => 'Applicant',
                                'obo' => 'Office of the Building Official',
                                'bfp' => 'Buareo of Fire Protection',
                                'staff' => 'Staff Member',
                            ];
                        @endphp

                        <p class="text-sm text-gray-500">
                            {{ $roleNames[strtolower($role)] ?? ucwords($role) }}
                        </p>
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-2 hidden sm:flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                        </svg>

                        <p id="date" class="text-sm text-gray-500">Loading date...</p>
                    </div>
                    <div class="flex items-center gap-2 hidden sm:flex">

                        <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                        <p id="time" class="text-sm text-gray-500">Loading time...</p>
                    </div>


                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <!-- Search -->
            <div class="mb-6">
                <input type="text" placeholder="Search Applicant Records"
                    class="border px-4 py-2 rounded w-full md:w-1/3">
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="col-span-1 sm:col-span-2 bg-white p-6 rounded shadow text-center">
                    <div class="text-3xl font-bold">2</div>
                    <p class="text-gray-600">Apply your building permit</p>
                    <button class="mt-4 bg-red-500 text-white py-2 px-4 rounded">+ Add New Building Permit</button>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Pending Evaluation</p>
                    <div class="text-xl font-bold">5</div>
                    <button class="text-blue-500 text-sm mt-2">View</button>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Approved</p>
                    <div class="text-xl font-bold">10</div>
                    <button class="text-blue-500 text-sm mt-2">View</button>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Disapproved</p>
                    <div class="text-xl font-bold">2</div>
                    <button class="text-blue-500 text-sm mt-2">View</button>
                </div>

            </div>

            <!-- Table -->
            <div class="bg-white p-4 rounded shadow overflow-x-auto">
                <div class="flex justify-between items-center mb-2 flex-wrap gap-2">
                    <div class="flex flex-wrap gap-2">
                        <button class="px-3 py-1 bg-gray-200 rounded">All</button>
                        <button class="px-3 py-1 bg-gray-800 text-white rounded">Pending (1)</button>
                        <button class="px-3 py-1 bg-gray-200 rounded">Approved (5)</button>
                        <button class="px-3 py-1 bg-gray-200 rounded">Disapproved</button>
                        <button class="px-3 py-1 bg-gray-200 rounded">Subject for Reconsideration</button>
                    </div>
                    <span class="text-sm text-gray-500">📅 Today: August 27, 2025</span>
                </div>

                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2">Application No</th>
                            <th class="px-4 py-2">Project Location</th>
                            <th class="px-4 py-2">Project Reg. Evaluation</th>
                            <th class="px-4 py-2">Evaluations</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">123-45678</td>
                            <td class="px-4 py-2">San Ramon, Lapu</td>
                            <td class="px-4 py-2 text-yellow-500">Pending</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <span class="text-green-500">✔</span>
                                <span class="text-green-500">✔</span>
                                <span class="text-green-500">✔</span>
                            </td>
                            <td class="px-4 py-2">
                                <button class="text-blue-600 hover:underline">View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script>
    const firstName = @json(ucwords(Auth::user()->first_name)); // Pass PHP variable into JS

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
        if (hours >= 12 && hours < 17) {
            greeting = "🌤️Good Afternoon";
        } else if (hours >= 17 || hours < 5) {
            greeting = "🌒Good Evening";
        }

        // ✅ Include user's first name in the greeting
        document.getElementById('greeting').textContent = `${greeting}, ${firstName}!`;
        document.getElementById('date').textContent = formattedDate;
        document.getElementById('time').textContent = formattedTime;
    }

    updateGreeting();
    setInterval(updateGreeting, 60000);
</script>
@include('partials._footer')
