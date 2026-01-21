@extends('layout.applicant.app')

@section('title', 'Update Profile')

@section('content')
    <div
        class="flex flex-col md:flex-row justify-center items-center w-full min-h-screen p-4 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="w-full max-w-full mx-auto bg-white shadow-xl rounded-xl p-6 md:p-8">

            <a href="{{ route('applicant.setting') }}"
                class="text-blue-600 hover:text-blue-800 flex items-center gap-2 mb-4 font-medium transition-colors">
                <i class="fas fa-arrow-left text-sm"></i> Back to Settings
            </a>

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-3">
                    <div
                        class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600 rounded-full shadow-md">
                        <i class="fas fa-user-cog text-3xl"></i>
                    </div>
                </div>
                <h1
                    class="text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Profile Settings</h1>
                <p class="text-gray-500 mt-2 text-sm">Update your personal information below</p>
            </div>

            <!-- Form -->
            <form action="{{ route('update_user_profile') }}" method="POST">
                @csrf

                <!-- Role -->
                <div class="mb-6">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Account Type</label>
                    <select id="role" name="role" disabled
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-600 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all text-sm">
                        <option value="applicant"
                            {{ (old('role') ?? auth()->user()->role) == 'applicant' ? 'selected' : '' }}>Applicant</option>
                        <option value="obo" {{ (old('role') ?? auth()->user()->role) == 'obo' ? 'selected' : '' }}>Office
                            of the Building Official</option>
                        <option value="do" {{ (old('role') ?? auth()->user()->role) == 'do' ? 'selected' : '' }}>
                            Division Office</option>
                        <option value="bfp" {{ (old('role') ?? auth()->user()->role) == 'bfp' ? 'selected' : '' }}>Bureau
                            of Fire Protection</option>
                    </select>
                </div>

                <!-- Personal Information Section -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-100">
                    <h2 class="text-lg font-semibold text-blue-800 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        Personal Information
                    </h2>

                    <!-- Name Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">First Name</label>
                            <input type="text" name="first_name"
                                value="{{ old('first_name') ?? auth()->user()->first_name }}"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Middle Name</label>
                            <input type="text" name="middle_name"
                                value="{{ old('middle_name') ?? auth()->user()->middle_name }}"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Last Name</label>
                            <input type="text" name="last_name"
                                value="{{ old('last_name') ?? auth()->user()->last_name }}"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Suffix</label>
                            <select name="suffix"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                                <option value="">-- Select --</option>
                                @foreach (['Jr', 'Sr', 'II', 'III', 'IV', 'V', 'MD', 'PhD', 'Esq'] as $suffix)
                                    <option value="{{ $suffix }}"
                                        {{ old('suffix', auth()->user()->suffix) == $suffix ? 'selected' : '' }}>
                                        {{ $suffix }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Gender & Birth Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Birth Date</label>
                            <input type="date" name="birth_date"
                                value="{{ old('birth_date') ?? auth()->user()->birth_date }}"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Gender</label>
                            <select name="gender"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                                <option value="male"
                                    {{ old('gender', auth()->user()->gender) == 'male' ? 'selected' : '' }}>
                                    Male</option>
                                <option value="female"
                                    {{ old('gender', auth()->user()->gender) == 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-100">
                    <h2 class="text-lg font-semibold text-blue-800 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-address-book text-blue-600"></i>
                        </div>
                        Contact Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Email</label>
                            <input type="email" name="email" value="{{ old('email') ?? auth()->user()->email }}"
                                disabled
                                class="w-full border border-gray-300 bg-gray-50 text-gray-500 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone') ?? auth()->user()->phone }}"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-100">
                    <h2 class="text-lg font-semibold text-blue-800 mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-blue-600"></i>
                        </div>
                        Address
                    </h2>

                    <!-- Street -->
                    <div class="mb-5">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Lot / Block / Street</label>
                        <input type="text" name="street" value="{{ old('street') ?? auth()->user()->street }}"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                    </div>

                    <!-- Province, City, Barangay -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Province</label>
                            <select id="province" name="province"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                                <option value="">Select Province</option>
                                @foreach ($provinces as $provinceName => $provinceData)
                                    <option value="{{ $provinceName }}"
                                        {{ old('province', auth()->user()->province) == $provinceName ? 'selected' : '' }}>
                                        {{ $provinceName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Municipality / City</label>
                            <select id="municipality" name="municipality"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                                @foreach ($municipalities as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ strtoupper(old('municipality', auth()->user()->municipality)) === strtoupper($key) ? 'selected' : '' }}>
                                        {{ ucwords(strtolower($key)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Barangay</label>
                            <select id="barangay" name="barangay"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-all">
                                @foreach ($barangays as $barangay)
                                    <option value="{{ $barangay }}"
                                        {{ strtoupper(old('barangay', auth()->user()->barangay)) === strtoupper($barangay) ? 'selected' : '' }}>
                                        {{ ucwords(strtolower($barangay)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full mt-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Update Profile
                </button>

                @if (session('success'))
                    <script>
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Account Successfully Updated!",
                            showConfirmButton: false,
                            timer: 2500
                        });
                        setTimeout(function() {
                            window.location.href = "{{ route('applicant.setting') }}";
                        }, 2500);
                    </script>
                @endif
            </form>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('asset/js/profileLocation.js') }}"></script>

@endsection
