@extends('layout.applicant.app')

@section('title', 'User Record Dashboard')

@section('content')
    <div x-data="{ open: false }" class="max-w-10xl bg-white rounded-xl mx-auto px-6 py-8">

        <h1 class="text-xl font-semibold text-gray-800  inline-block pb-1 mb-6">
            User's Account Overview
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="flex items-center gap-4 bg-red-50 rounded-xl p-5 shadow-sm border border-red-100">
                <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $records->count() }}</h3>
                </div>
            </div>

            <!-- Applicant -->
            <div class="flex items-center gap-4 bg-green-50 rounded-xl p-5 shadow-sm border border-green-100">
                <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                    <i class="fas fa-user-edit text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Applicant</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $records->where('role', 'applicant')->count() }}
                    </h3>
                </div>
            </div>

            <!-- Zoning Officer -->
            <div class="flex items-center gap-4 bg-blue-50 rounded-xl p-5 shadow-sm border border-blue-100">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                    <i class="fas fa-map-marked-alt text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Zoning Officer</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $records->where('role', 'zoning_officer')->count() }}
                    </h3>
                </div>
            </div>

            <!-- Sanitary Officer -->
            <div class="flex items-center gap-4 bg-yellow-50 rounded-xl p-5 shadow-sm border border-yellow-100">
                <div class="p-3 bg-yellow-100 text-yellow-700 rounded-lg">
                    <i class="fas fa-hand-holding-water text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Sanitary Officer</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $records->where('role', 'sanitary_officer')->count() }}
                    </h3>
                </div>
            </div>

            <!-- Building Official -->
            <div class="flex items-center gap-4 bg-violet-50 rounded-xl p-5 shadow-sm border border-violet-100">
                <div class="p-3 bg-violet-100 text-violet-600 rounded-lg">
                    <i class="fas fa-hard-hat text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Building Official</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $records->where('role', 'obo')->count() }}
                    </h3>
                </div>
            </div>

            <!-- Professional -->
            <div class="flex items-center gap-4 bg-pink-50 rounded-xl p-5 shadow-sm border border-pink-100">
                <div class="p-3 bg-pink-100 text-pink-600 rounded-lg">
                    <i class="fas fa-user-tie text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Professional</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $records->where('role', 'professional')->count() }}
                    </h3>
                </div>
            </div>

            {{-- <!-- Admin -->
            <div class="flex items-center gap-4 bg-gray-50 rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="p-3 bg-gray-100 text-gray-600 rounded-lg">
                    <i class="fas fa-user-shield text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Admin</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $records->where('role', 'admin')->count() }}
                    </h3>
                </div>
            </div> --}}
        </div>
        <div class="bg-gray-50 p-4 sm:p-6 overflow-x-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center px-6 py-6 border-b border-gray-200 gap-4">
                <div class="w-full sm:w-1/2">
                    <h1 class="text-xl font-semibold text-red-800">User Accounts</h1>
                    <p class="text-sm text-gray-500">Manage user accounts.</p>
                </div>

                <div class="w-full sm:w-1/2 flex flex-col sm:flex-row justify-end items-center gap-3">
                    <!-- Search -->
                    <div class="relative w-full sm:w-3/4"> <!-- ⬅ made wider here -->
                        <input type="search" id="customSearch" placeholder="Search applications..."
                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:ring-2 focus:ring-red-500 focus:outline-none transition">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <a href="{{ route('admin.addUser') }}"
                        class="w-full sm:w-auto px-5 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm shadow-md flex items-center justify-center gap-2 transition">
                        <i class="fa-solid fa-user-plus"></i>
                    </a>

                </div>
            </div>
            <table id="example"
                class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-lg overflow-hidden shadow-sm"
                id="example">
                <!-- Table Header -->
                <thead class="bg-gray-100 border-b border-gray-200 text-gray-700 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-center w-10 font-bold">#</th>
                        <th class="px-6 py-3 text-center font-bold">Full Name</th>
                        <th class="px-6 py-3 text-center font-bold">Birthdate</th>
                        <th class="px-6 py-3 text-center font-bold">Gender</th>
                        <th class="px-6 py-3 text-center font-bold">Email</th>
                        <th class="px-6 py-3 text-center font-bold">Phone Number</th>
                        <th class="px-6 py-3 text-center font-bold">Role</th>
                        <th class="px-6 py-3 text-center font-bold">Action</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($records as $index => $record)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <!-- Row Number -->
                            <td class="px-6 py-4 text-center font-semibold text-gray-800">
                                {{ $index + 1 }}
                            </td>

                            <!-- Full Name -->
                            <td class="px-6 py-4 text-center text-gray-700">
                                {{ $record->first_name }} {{ $record->last_name }}
                            </td>

                            <!-- Birthdate -->
                            <td class="px-6 py-4 text-center text-gray-700">
                                {{ \Carbon\Carbon::parse($record->birthdate)->format('M d, Y') }}
                            </td>

                            <!-- Gender -->
                            <td class="px-6 py-4 text-center text-gray-700">
                                @if (strtolower($record->gender) == 'male')
                                    <span
                                        class="inline-flex items-center gap-1 text-blue-700 bg-blue-50 px-3 py-1 rounded-full text-xs font-semibold">
                                        Male
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 text-pink-700 bg-pink-50 px-3 py-1 rounded-full text-xs font-semibold">
                                        Female
                                    </span>
                                @endif
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4 text-center text-gray-700">
                                {{ $record->email }}
                            </td>

                            <!-- Phone -->
                            <td class="px-6 py-4 text-center text-gray-700">
                                {{ $record->phone }}
                            </td>

                            <!-- Role -->
                            <td class="px-6 py-4 text-center capitalize">
                                @switch($record->role)
                                    @case('applicant')
                                        <span
                                            class="inline-flex items-center gap-1 text-green-700 bg-green-50 px-3 py-1 rounded-full text-xs font-semibold">
                                            Applicant
                                        </span>
                                    @break

                                    @case('zoning_officer')
                                        <span
                                            class="inline-flex items-center gap-1 text-blue-700 bg-blue-50 px-3 py-1 rounded-full text-xs font-semibold">
                                            Zoning
                                        </span>
                                    @break

                                    @case('sanitary_officer')
                                        <span
                                            class="inline-flex items-center gap-1 text-yellow-700 bg-yellow-50 px-3 py-1 rounded-full text-xs font-semibold">
                                            Sanitary
                                        </span>
                                    @break

                                    @case('obo')
                                        <span
                                            class="inline-flex items-center gap-1 text-violet-700 bg-violet-50 px-3 py-1 rounded-full text-xs font-semibold">
                                            Building
                                        </span>
                                    @break

                                    @case('professional')
                                        <span
                                            class="inline-flex items-center gap-1 text-pink-700 bg-pink-50 px-3 py-1 rounded-full text-xs font-semibold">
                                            Professional
                                        </span>
                                    @break

                                    @case('admin')
                                        <span
                                            class="inline-flex items-center gap-1 text-gray-700 bg-gray-50 px-3 py-1 rounded-full text-xs font-semibold">
                                            Admin
                                        </span>
                                    @break

                                    @default
                                        <span class="text-gray-500">Unknown</span>
                                @endswitch
                            </td>

                            <!-- Action Buttons -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-3">
                                    <!-- View -->
                                    <a href="{{ route('admin.show_user', $record->id) }}"
                                        class="text-blue-500 hover:text-blue-700 transition-colors" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.updateUser', $record->id) }}" class="text-yellow-500 hover:text-yellow-600 transition-colors"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Delete (only show if not admin) -->
                                    @if (strtolower($record->role) !== 'admin')
                                        <form action="{{ route('users.destroy', $record->id) }}" method="POST"
                                            class="inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="text-red-500 hover:text-red-700 transition-colors delete-btn"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "User Deleted!",
                showConfirmButton: false,
                timer: 2500
            });
            setTimeout(function() {}, 2500);
        </script>
    @endif

    <script src="{{ asset('asset/js/datatable.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach to all delete buttons
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        background: '#fff',
                        customClass: {
                            popup: 'rounded-xl shadow-lg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
