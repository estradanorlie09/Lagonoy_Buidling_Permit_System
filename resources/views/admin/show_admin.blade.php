@extends('layout.applicant.app')

@section('title', 'Admin | Show Admin Details')

@section('content')
    <div class="bg-white max-w-10xl mx-auto">

        <div
            class="bg-gradient-to-r from-red-100 via-rose-100 to-red-200 border border-red-100 shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-center gap-6 mb-8">

            <!-- Left Section: Avatar & User Info -->
            <div class="flex items-center gap-6">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($records->first_name . ' ' . $records->last_name) }}&background=random&color=fff&size=128"
                    alt="Avatar of {{ $records->first_name }} {{ $records->last_name }}"
                    class="w-16 h-16 rounded-full shadow-md border border-white" />

                <div class="text-center md:text-left">
                    <h1 class="text-2xl font-bold text-gray-800">
                        {{ ucwords("{$records->first_name} {$records->middle_name} {$records->last_name}") }}
                    </h1>
                    <p class="text-gray-600 mt-1 flex items-center justify-center md:justify-start gap-2">
                        <i class="fas fa-envelope text-red-500"></i> {{ $records->email }}
                    </p>
                    <p class="text-gray-600 flex items-center justify-center md:justify-start gap-2">
                        <i class="fas fa-phone text-red-500"></i> {{ $records->phone }}
                    </p>
                </div>
            </div>

            <!-- Right Section: Back Button -->
            <div class="w-full md:w-auto text-center md:text-right">
                <a href="{{ route('admin.admin_accounts') }}"
                    class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg shadow-sm transition duration-200">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <!-- PERSONAL INFORMATION -->
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100 mb-8">
            <!-- Header -->
            <div class="flex items-center gap-3 mb-6 border-b pb-3">
                <i class="fas fa-id-card text-red-600 text-xl"></i>
                <h3 class="text-xl font-semibold text-gray-800">Personal Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Full Name -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    <i class="fas fa-user text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Full Name</p>
                        <p class="font-semibold text-gray-800">
                            {{ ucwords("{$records->first_name} {$records->middle_name} {$records->last_name}") }}
                        </p>
                    </div>
                </div>

                <!-- Gender -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    @if (strtolower($records->gender) == 'male')
                        <i class="fas fa-mars text-blue-500 text-lg mt-1"></i>
                    @else
                        <i class="fas fa-venus text-pink-500 text-lg mt-1"></i>
                    @endif
                    <div>
                        <p class="text-gray-500 text-sm">Gender</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $records->gender }}</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    <i class="fas fa-envelope text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Email</p>
                        <p class="font-semibold text-gray-800">{{ $records->email }}</p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    <i class="fas fa-phone text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Phone Number</p>
                        <p class="font-semibold text-gray-800">{{ $records->phone }}</p>
                    </div>
                </div>

                <!-- Birthdate -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    <i class="fas fa-calendar-day text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Birthdate</p>
                        <p class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($records->birthdate)->format('F d, Y') }}
                        </p>
                    </div>
                </div>

                <!-- Role -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    <i class="fas fa-user-shield text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Role</p>
                        <p class="font-semibold text-gray-800 capitalize">
                            @switch($records->role)
                                @case('admin')
                                    <span class="text-gray-700 font-semibold">
                                        <i class="fas fa-user-shield text-gray-500 mr-1"></i> Admin
                                    </span>
                                @break

                                @case('applicant')
                                    <span class="text-green-700 font-semibold">
                                        <i class="fas fa-user text-green-500 mr-1"></i> Applicant
                                    </span>
                                @break

                                @case('obo')
                                    <span class="text-violet-700 font-semibold">
                                        <i class="fas fa-hard-hat text-violet-500 mr-1"></i> Building Officer
                                    </span>
                                @break

                                @case('zoning_officer')
                                    <span class="text-blue-700 font-semibold">
                                        <i class="fas fa-map-marked-alt text-blue-500 mr-1"></i> Zoning Officer
                                    </span>
                                @break

                                @case('sanitary_officer')
                                    <span class="text-yellow-700 font-semibold">
                                        <i class="fas fa-hand-holding-water text-yellow-500 mr-1"></i> Sanitary Officer
                                    </span>
                                @break

                                @case('professional')
                                    <span class="text-pink-700 font-semibold">
                                        <i class="fas fa-user-tie text-pink-500 mr-1"></i> Professional
                                    </span>
                                @break

                                @default
                                    <span class="text-gray-500">Unknown</span>
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADDRESS INFORMATION -->
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100">
            <div class="flex items-center gap-3 mb-6 border-b pb-3">
                <i class="fas fa-map-marked-alt text-red-600 text-xl"></i>
                <h3 class="text-xl font-semibold text-gray-800">Address Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Street -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    <i class="fas fa-map-marker-alt text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Street</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $records->street }}</p>
                    </div>
                </div>

                <!-- Province -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    <i class="fas fa-flag text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Province</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $records->province }}</p>
                    </div>
                </div>

                <!-- Municipality / City -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    <i class="fas fa-city text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Municipality / City</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $records->municipality }}</p>
                    </div>
                </div>

                <!-- Barangay -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border hover:shadow-md transition">
                    <i class="fas fa-map-pin text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Barangay</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $records->barangay }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
