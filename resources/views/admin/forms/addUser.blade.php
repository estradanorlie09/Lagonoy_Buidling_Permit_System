@extends('layout.applicant.app')

@section('title', 'Add User Account')

@section('content')
    <div class="flex flex-col md:flex-row justify-center items-center w-full min-h-screen p-6 bg-gray-50">
        <div class="w-full max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 md:p-10">

            <a href="{{ route('admin.user_records') }}" class="text-red-600 hover:text-red-800 flex items-center gap-2 mb-6">
                <i class="fas fa-arrow-left text-sm"></i> Back to Settings
            </a>

            <!-- Header -->
            <div class="text-center mb-10">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 flex items-center justify-center bg-red-100 text-red-600 rounded-full shadow-sm">
                        <i class="fas fa-user-plus text-3xl"></i>
                    </div>
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold text-red-600 tracking-tight">
                    Add New User
                </h1>
                <p class="text-gray-500 mt-2 text-base">
                    Fill out the form below to create a new account.
                </p>
            </div>

            <!-- Form -->
            <form action="{{ route('user_register.store') }}" method="POST">
                @csrf

                <!-- Role -->
                <div class="mt-10">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select name="role" id="role"
                        class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                        <option value="">-- Please choose an option --</option>
                        <option value="applicant" {{ old('role') == 'applicant' ? 'selected' : '' }}>Applicant</option>
                        <option value="zoning_officer" {{ old('role') == 'zoning_officer' ? 'selected' : '' }}>Zoning
                            Officer</option>
                        <option value="sanitary_officer" {{ old('role') == 'sanitary_officer' ? 'selected' : '' }}>Sanitary
                            Officer</option>
                        <option value="obo" {{ old('role') == 'obo' ? 'selected' : '' }}>Office of the Building Official
                        </option>
                        <option value="professional" {{ old('role') == 'professional' ? 'selected' : '' }}>Professional
                        </option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profession -->
                <div id="profession-container" class="mt-6 {{ old('role') == 'professional' ? '' : 'hidden' }}">
                    <label for="profession" class="block text-sm font-semibold text-gray-700 mb-2">Profession Type</label>
                    <select name="profession" id="profession"
                        class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                        <option value="">-- Select Profession Type --</option>
                        <option value="architect" {{ old('profession') == 'architect' ? 'selected' : '' }}>Architect
                        </option>
                        <option value="civil_engineer" {{ old('profession') == 'civil_engineer' ? 'selected' : '' }}>Civil
                            Engineer</option>
                        <option value="electrical_engineer"
                            {{ old('profession') == 'electrical_engineer' ? 'selected' : '' }}>Electrical Engineer</option>
                        <option value="sanitary_engineer" {{ old('profession') == 'sanitary_engineer' ? 'selected' : '' }}>
                            Sanitary Engineer</option>
                        <option value="master_plumber" {{ old('profession') == 'master_plumber' ? 'selected' : '' }}>Master
                            Plumber</option>
                        <option value="geodetic_engineer" {{ old('profession') == 'geodetic_engineer' ? 'selected' : '' }}>
                            Geodetic Engineer</option>
                        <option value="mechanical_engineer"
                            {{ old('profession') == 'mechanical_engineer' ? 'selected' : '' }}>
                            Mechanical Engineer</option>
                    </select>
                    @error('profession')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Personal Info -->
                <h2 class="text-lg font-semibold text-red-700 mt-5 mb-4 pb-2">
                    <i class="fas fa-user mr-2"></i> Personal Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                            placeholder="Enter first name"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        @error('first_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                            placeholder="Enter middle name"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        @error('middle_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Enter last name"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        @error('last_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Suffix</label>
                        <select name="suffix"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="">-- Select suffix --</option>
                            @foreach (['Jr', 'Sr', 'II', 'III', 'IV', 'V', 'MD', 'PhD', 'Esq'] as $suffix)
                                <option value="{{ $suffix }}" {{ old('suffix') == $suffix ? 'selected' : '' }}>
                                    {{ $suffix }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Gender & Birth -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Birth Date</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                            placeholder="Select birth date"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        @error('birth_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="">-- Select gender --</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contact -->
                <h2 class="text-lg font-semibold text-red-700 mb-4 pb-2">
                    <i class="fas fa-address-book mr-2"></i> Contact Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                            class="w-full border border-gray-300 text-gray-500 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <h2 class="text-lg font-semibold text-red-700 mb-4 pb-2">
                    <i class="fas fa-lock mr-2"></i> Account Credentials
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" placeholder="Enter password"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Re-enter password"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                </div>

                <!-- Address -->
                <h2 class="text-lg font-semibold text-red-700 mb-4 pb-2">
                    <i class="fas fa-map-marker-alt mr-2"></i> Address
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="md:col-span-3">
                        <label class="text-sm font-medium text-gray-700">Lot / Blk / Street</label>
                        <input type="text" name="street" value="{{ old('street') }}"
                            placeholder="Enter lot, block, or street"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        @error('street')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Province</label>
                        <select id="province" name="province"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="">-- Select province --</option>
                            @foreach ($provinces as $provinceName => $provinceData)
                                <option value="{{ $provinceName }}"
                                    {{ old('province') == $provinceName ? 'selected' : '' }}>
                                    {{ $provinceName }}
                                </option>
                            @endforeach
                        </select>
                        @error('province')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Municipality / City</label>
                        <select id="municipality" name="municipality"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="{{ old('municipality') }}">
                                {{ old('municipality') ?: '-- Select municipality --' }}</option>
                        </select>
                        @error('municipality')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Barangay</label>
                        <select id="barangay" name="barangay"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="{{ old('barangay') }}">{{ old('barangay') ?: '-- Select barangay --' }}
                            </option>
                        </select>
                        @error('barangay')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full mt-4 bg-red-600 text-white font-semibold py-3 rounded-lg hover:bg-red-700 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Save
                </button>
            </form>

        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "User account created!",
                showConfirmButton: false,
                timer: 2500
            });
            setTimeout(function() {
                window.location.href = "{{ route('admin.user_records') }}";
            }, 2500);
        </script>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('asset/js/location.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const roleSelect = document.getElementById("role");
            const professionContainer = document.getElementById("profession-container");

            function toggleProfessionDropdown() {
                if (roleSelect.value === "professional") {
                    professionContainer.classList.remove("hidden");
                } else {
                    professionContainer.classList.add("hidden");
                }
            }

            toggleProfessionDropdown();
            roleSelect.addEventListener("change", toggleProfessionDropdown);
        });
    </script>
@endsection
