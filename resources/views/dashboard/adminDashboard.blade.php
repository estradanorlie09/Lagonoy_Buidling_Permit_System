@include('partials._header')
{{-- @include('components.landing_page_navbar') --}}

<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-black text-white flex flex-col">
        <div class="flex items-center justify-center h-24 border-b border-gray-700">
            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
            </svg> --}}
            <img class="w-15 h-15" src="{{ asset('asset/icon/logo.png') }}" alt="logo">
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="#" class="block py-2 px-4 bg-red-600 rounded text-white">Overview</a>
            <a href="#" class="block py-2 px-4 hover:bg-gray-800 rounded">All Records</a>
            <a href="#" class="block py-2 px-4 hover:bg-gray-800 rounded">Schedules</a>
        </nav>
        <div class="p-4">
            <button class="w-full py-2 bg-gray-800 rounded hover:bg-gray-700">Logout</button>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6 overflow-y-auto">
        <!-- Top bar -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-xl font-bold">Good Morning!</h1>
                <p class="text-sm text-gray-500">Monday, August 25, 2025</p>
            </div>
            <input type="text" placeholder="Search Applicant Records" class="border px-4 py-2 rounded w-1/3">
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-5 gap-4 mb-6">
            <div class="col-span-2 bg-white p-6 rounded shadow text-center">
                <div class="text-3xl font-bold">54,123</div>
                <p class="text-gray-600">Total Registered Building Establishment</p>
                <button class="mt-4 bg-red-500 text-white py-2 px-4 rounded">+ Add New Applicant</button>
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
            <div class="bg-white p-4 rounded shadow">
                <p class="text-sm text-gray-500">Subject for Reconsideration</p>
                <div class="text-xl font-bold">1</div>
                <button class="text-blue-500 text-sm mt-2">View</button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center mb-2">
                <div class="flex space-x-4">
                    <button class="px-3 py-1 bg-gray-200 rounded">All</button>
                    <button class="px-3 py-1 bg-gray-800 text-white rounded">Pending (1)</button>
                    <button class="px-3 py-1 bg-gray-200 rounded">Approved (5)</button>
                    <button class="px-3 py-1 bg-gray-200 rounded">Disapproved</button>
                    <button class="px-3 py-1 bg-gray-200 rounded">Subject for Reconsideration</button>
                </div>
                <span class="text-sm text-gray-500">📅 Today: March, 2024</span>
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

@include('partials._footer')