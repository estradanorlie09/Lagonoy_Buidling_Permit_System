@extends('layout.applicant.app')

@section('title', 'Update Profile')

@section('content')
    <div class="flex flex-col md:flex-row justify-center items-center w-full min-h-screen p-6 bg-gray-50">
        <div class="w-full max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 md:p-10">

            <a href="{{ route('applicant.setting') }}" class="text-red-600 hover:text-red-800 flex items-center gap-2 mb-6">
                <i class="fas fa-arrow-left text-sm"></i> Back to Settings
            </a>

            <!-- Header -->
            <div class="text-center mb-10">
                <div class="flex justify-center mb-3">
                    <div class="w-16 h-16 flex items-center justify-center bg-red-100 text-red-600 rounded-full">
                        <i class="fas fa-user-cog text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold text-red-500">Profile Settings</h1>
                <p class="text-gray-500 mt-1 text-sm">Update your personal information below</p>
            </div>

            <!-- Form -->
            <form action="{{ route('update_user_profile') }}" method="POST">
                @csrf

                <!-- Role -->
                <div class="mb-8">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Account Type</label>
                    <select id="role" name="role" disabled
                        class="w-full border border-gray-300 rounded-lg px-3 py-3 text-gray-600 bg-gray-50 focus:ring-2 focus:ring-red-500 focus:outline-none">
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

                <!-- Name Section -->
                <h2 class="text-lg font-semibold text-red-700 mb-4 pb-2">
                    <i class="fas fa-user mr-2"></i> Personal Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name"
                            value="{{ old('first_name') ?? auth()->user()->first_name }}"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Middle Name</label>
                        <input type="text" name="middle_name"
                            value="{{ old('middle_name') ?? auth()->user()->middle_name }}"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') ?? auth()->user()->last_name }}"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Suffix</label>
                        <select name="suffix"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
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

                <!-- Gender & Birth -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Birth Date</label>
                        <input type="date" name="birth_date"
                            value="{{ old('birth_date') ?? auth()->user()->birth_date }}"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            <option value="male" {{ old('gender', auth()->user()->gender) == 'male' ? 'selected' : '' }}>
                                Male</option>
                            <option value="female"
                                {{ old('gender', auth()->user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
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
                        <input type="email" name="email" value="{{ old('email') ?? auth()->user()->email }}" disabled
                            class="w-full border border-gray-300 bg-gray-50 text-gray-500 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') ?? auth()->user()->phone }}"
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
                        <input type="text" name="street" value="{{ old('street') ?? auth()->user()->street }}"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Province</label>
                        <select id="province" name="province"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
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
                        <label class="text-sm font-medium text-gray-700">Municipality / City</label>
                        <select id="municipality" name="municipality"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            @foreach ($municipalities as $key => $value)
                                <option value="{{ $key }}"
                                    {{ strtoupper(old('municipality', auth()->user()->municipality)) === strtoupper($key) ? 'selected' : '' }}>
                                    {{ ucwords(strtolower($key)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Barangay</label>
                        <select id="barangay" name="barangay"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mt-1 focus:ring-2 focus:ring-red-500 focus:outline-none">
                            @foreach ($barangays as $barangay)
                                <option value="{{ $barangay }}"
                                    {{ strtoupper(old('barangay', auth()->user()->barangay)) === strtoupper($barangay) ? 'selected' : '' }}>
                                    {{ ucwords(strtolower($barangay)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit"
                    class="w-full mt-4 bg-red-600 text-white font-semibold py-3 rounded-lg hover:bg-red-700 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Update Profile
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
