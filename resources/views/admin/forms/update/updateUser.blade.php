@extends('layout.applicant.app')

@section('title', 'Update User Account')

@section('content')
    <div class="flex flex-col md:flex-row justify-center items-center w-full min-h-screen p-6 bg-gray-50">
        <div class="w-full max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 md:p-10">

            <a href="{{ route('admin.user_records') }}" class="text-red-600 hover:text-red-800 flex items-center gap-2 mb-6">
                <i class="fas fa-arrow-left text-sm"></i> Back to User Records
            </a>

            <!-- Header -->
            <div class="text-center mb-10">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 flex items-center justify-center bg-red-100 text-red-600 rounded-full shadow-sm">
                        <i class="fas fa-user-edit text-3xl"></i>
                    </div>
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold text-red-600 tracking-tight">
                    Update User Account
                </h1>
                <p class="text-gray-500 mt-2 text-base">
                    Update the details for this user account below.
                </p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.update_user_submit', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Role -->
                <div class="mt-10">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select name="role" id="role"
                        class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                        <option value="">-- Please choose an option --</option>
                        <option value="applicant" {{ old('role', $user->role) == 'applicant' ? 'selected' : '' }}>Applicant
                        </option>
                        <option value="zoning_officer" {{ old('role', $user->role) == 'zoning_officer' ? 'selected' : '' }}>
                            Zoning Officer</option>
                        <option value="sanitary_officer"
                            {{ old('role', $user->role) == 'sanitary_officer' ? 'selected' : '' }}>Sanitary Officer</option>
                        <option value="obo" {{ old('role', $user->role) == 'obo' ? 'selected' : '' }}>Office of the
                            Building Official</option>
                        <option value="professional" {{ old('role', $user->role) == 'professional' ? 'selected' : '' }}>
                            Professional</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profession -->
                <div id="profession-container"
                    class="mt-6 {{ old('role', $user->role) == 'professional' ? '' : 'hidden' }}">
                    <label for="profession" class="block text-sm font-semibold text-gray-700 mb-2">Profession Type</label>
                    <select name="profession" id="profession"
                        class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                        <option value="">-- Select Profession Type --</option>
                        <option value="architect"
                            {{ old('profession', $user->profession) == 'architect' ? 'selected' : '' }}>Architect</option>
                        <option value="civil_engineer"
                            {{ old('profession', $user->profession) == 'civil_engineer' ? 'selected' : '' }}>Civil Engineer
                        </option>
                        <option value="electrical_engineer"
                            {{ old('profession', $user->profession) == 'electrical_engineer' ? 'selected' : '' }}>
                            Electrical Engineer</option>
                        <option value="sanitary_engineer"
                            {{ old('profession', $user->profession) == 'sanitary_engineer' ? 'selected' : '' }}>Sanitary
                            Engineer</option>
                        <option value="master_plumber"
                            {{ old('profession', $user->profession) == 'master_plumber' ? 'selected' : '' }}>Master Plumber
                        </option>
                        <option value="geodetic_engineer"
                            {{ old('profession', $user->profession) == 'geodetic_engineer' ? 'selected' : '' }}>Geodetic
                            Engineer</option>
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
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                            placeholder="Enter first name"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                        @error('first_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}"
                            placeholder="Enter middle name"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                            placeholder="Enter last name"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Suffix</label>
                        <select name="suffix"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="">-- Select suffix --</option>
                            @foreach (['Jr', 'Sr', 'II', 'III', 'IV', 'V', 'MD', 'PhD', 'Esq'] as $suffix)
                                <option value="{{ $suffix }}"
                                    {{ old('suffix', $user->suffix) == $suffix ? 'selected' : '' }}>{{ $suffix }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Gender & Birth -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Birth Date</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="">-- Select gender --</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Contact -->
                <h2 class="text-lg font-semibold text-red-700 mb-4 pb-2">
                    <i class="fas fa-address-book mr-2"></i> Contact Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            placeholder="Enter your email" disabled
                            class="w-full border border-gray-300 text-gray-500 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            placeholder="Enter phone number"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                </div>

                <!-- Password -->
                <h2 class="text-lg font-semibold text-red-700 mb-4 pb-2">
                    <i class="fas fa-lock mr-2"></i> Password (Optional)
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password"
                            placeholder="Enter new password (leave blank to keep current)"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Confirm new password"
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
                        <input type="text" name="street" value="{{ old('street', $user->street) }}"
                            placeholder="Enter lot, block, or street"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Province</label>
                        <select id="province" name="province"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="">-- Select province --</option>
                            @foreach ($provinces as $provinceName => $provinceData)
                                <option value="{{ $provinceName }}"
                                    {{ old('province', $user->province) == $provinceName ? 'selected' : '' }}>
                                    {{ $provinceName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Municipality / City</label>
                        <select id="municipality" name="municipality"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="{{ old('municipality', $user->municipality) }}">
                                {{ old('municipality', $user->municipality) ?: '-- Select municipality --' }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Barangay</label>
                        <select id="barangay" name="barangay"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="{{ old('barangay', $user->barangay) }}">
                                {{ old('barangay', $user->barangay) ?: '-- Select barangay --' }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full mt-4 bg-red-600 text-white font-semibold py-3 rounded-lg hover:bg-red-700 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
            </form>

        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "User account updated successfully!",
                showConfirmButton: false,
                timer: 2500
            });
            setTimeout(() => window.location.href = "{{ route('admin.user_records') }}", 2500);
        </script>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('asset/js/profileLocation.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const roleSelect = document.getElementById("role");
            const professionContainer = document.getElementById("profession-container");

            function toggleProfessionDropdown() {
                professionContainer.classList.toggle("hidden", roleSelect.value !== "professional");
            }

            toggleProfessionDropdown();
            roleSelect.addEventListener("change", toggleProfessionDropdown);
        });
    </script>
@endsection
