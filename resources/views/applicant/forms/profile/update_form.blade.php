    @extends('layout.applicant.app')

    @section('title', 'Update Profile')

    @section('content')
        <div class="flex flex-col md:flex-row justify-center items-center w-full min-h-screen p-4 rounded">

            <div class="w-full max-w-4xl mx-auto bg-white shadow-md p-6 md:p-10 z-50 rounded-lg">
                <a href="{{ route('applicant.setting') }}">Back</a>
                <form action="{{ route('update_user_profile') }}" method="POST">
                    @csrf
                    <!-- Logo Section -->
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                    </div>

                    <!-- Header Text -->
                    <h1 class="text-2xl font-bold mb-2 text-center">Profile Settings</h1>
                    <p class="text-gray-700 text-sm text-center mb-6">Please update your profile</p>

                    <!-- Role Dropdown -->
                    <div class="mb-6">
                        {{-- <input type="text" value="{{ auth()->user()->id }}"> --}}
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="role" disabled
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500 ">

                            <option value="">-- Please choose an option --</option>

                            <option value="applicant"
                                {{ (old('role') ?? auth()->user()->role) == 'applicant' ? 'selected' : '' }}>Applicant
                            </option>

                            <option value="obo" {{ (old('role') ?? auth()->user()->role) == 'obo' ? 'selected' : '' }}>
                                Office
                                of the Building Official</option>
                            <option value="do" {{ (old('role') ?? auth()->user()->role) == 'do' ? 'selected' : '' }}>
                                Division Office</option>
                            <option value="bfp" {{ (old('role') ?? auth()->user()->role) == 'bfp' ? 'selected' : '' }}>
                                Beauro of Fire Protection</option>
                        </select>

                    </div>


                    <!-- Name Inputs: Responsive Row -->
                    <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                        <div class="w-full">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="First Name"
                                value="{{ old('first_name') ?? auth()->user()->first_name }}"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name"
                                value="{{ old('middle_name') ?? auth()->user()->middle_name }}"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('middle_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name"
                                value="{{ old('last_name') ?? auth()->user()->last_name }}"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/4">
                            <label for="suffix" class="block text-sm font-medium text-gray-700">Suffix</label>
                            <select name="suffix" id="suffix"
                                class="w-full border border-gray-300 text-sm rounded mt-1 px-3 py-2.5 focus:outline-none focus:ring-1 focus:ring-red-500">
                                <option value="">-- Select Suffix --</option>
                                <option value="Jr"
                                    {{ old('suffix', auth()->user()->suffix) == 'Jr' ? 'selected' : '' }}>Jr.</option>
                                <option value="Sr"
                                    {{ old('suffix', auth()->user()->suffix) == 'Sr' ? 'selected' : '' }}>Sr.</option>
                                <option value="II"
                                    {{ old('suffix', auth()->user()->suffix) == 'II' ? 'selected' : '' }}>II</option>
                                <option value="III"
                                    {{ old('suffix', auth()->user()->suffix) == 'III' ? 'selected' : '' }}>III</option>
                                <option value="IV"
                                    {{ old('suffix', auth()->user()->suffix) == 'IV' ? 'selected' : '' }}>IV</option>
                                <option value="V"
                                    {{ old('suffix', auth()->user()->suffix) == 'V' ? 'selected' : '' }}>V</option>
                                <option value="MD"
                                    {{ old('suffix', auth()->user()->suffix) == 'MD' ? 'selected' : '' }}>M.D.</option>
                                <option value="PhD"
                                    {{ old('suffix', auth()->user()->suffix) == 'PhD' ? 'selected' : '' }}>Ph.D.</option>
                                <option value="Esq"
                                    {{ old('suffix', auth()->user()->suffix) == 'Esq' ? 'selected' : '' }}>Esq.</option>
                            </select>
                            @error('suffix')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>
                    <div class="flex items-center flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                        <div class="w-full">
                            <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                            <input type="date" id="birth_date" name="birth_date" placeholder="Birth Date"
                                value="{{ old('birth_date') ?? auth()->user()->birth_date }}"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('birth_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender" id="gender"
                                class="w-full border border-gray-300 text-sm rounded mt-1 px-3 py-2.5 focus:outline-none focus:ring-1 focus:ring-red-500">

                                <option value="male"
                                    {{ old('gender' ?? auth()->user()->gender) == 'male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="female"
                                    {{ old('gender' ?? auth()->user()->gender) == 'female' ? 'selected' : '' }}>Female
                                </option>

                            </select>

                            @error('gender')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                        <div class="w-full">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" placeholder="Email" disabled
                                value="{{ old('email') ?? auth()->user()->email }}"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                    <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                        <div class="w-full">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" id="phone" name="phone" placeholder="+69"
                                value="{{ old('phone') ?? auth()->user()->phone }}"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                    <!-- Address Section -->
                    <div class="flex flex-col gap-4 md:flex-row mb-6">
                        <!-- Street -->
                        <div class="w-full">
                            <label for="street" class="block text-sm font-medium text-gray-700">Lot No./Blk
                                No./Street</label>
                            <input type="text" id="street" name="street" placeholder="Street"
                                value="{{ old('street') ?? auth()->user()->street }}"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('street')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row flex-wrap gap-4 mb-6">
                        <!-- Province -->
                        <div class="w-full md:flex-1">
                            <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                            <select id="province" name="province"
                                class="w-full border border-gray-300 rounded mt-2 px-3 py-2.5 focus:outline-none focus:ring-1 focus:ring-red-500">
                                <option value="">Select Province</option>
                                @foreach ($provinces as $provinceName => $provinceData)
                                    <option value="{{ $provinceName }}"
                                        {{ old('province', auth()->user()->province) == $provinceName ? 'selected' : '' }}>
                                        {{ $provinceName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('province')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Municipality / City -->
                        <div class="w-full md:flex-1">
                            <label for="municipality" class="block text-sm font-medium text-gray-700">Municipality /
                                City</label>
                            <select id="municipality" name="municipality"
                                class="w-full border border-gray-300 rounded mt-2 px-3 py-2.5 focus:outline-none focus:ring-1 focus:ring-red-500">
                                @foreach ($municipalities as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ strtoupper(old('municipality', auth()->user()->municipality)) === strtoupper($key) ? 'selected' : '' }}>
                                        {{ ucwords(strtolower($key)) }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <!-- Barangay -->
                        <div class="w-full md:flex-1">
                            <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
                            <select id="barangay" name="barangay"
                                class="w-full border border-gray-300 rounded mt-2 px-3 py-2.5 focus:outline-none focus:ring-1 focus:ring-red-500">
                                @foreach ($barangays as $barangay)
                                    <option value="{{ $barangay }}"
                                        {{ strtoupper(old('barangay', auth()->user()->barangay)) === strtoupper($barangay) ? 'selected' : '' }}>
                                        {{ ucwords(strtolower($barangay)) }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>


                    <!-- Login & Signup Buttons -->
                    <div>
                        <button type="submit"
                            class="w-full mt-4 bg-red-600 text-white p-3 rounded hover:bg-red-700 transition">
                            Update Profile
                        </button>

                        {{-- <!-- Divider -->
                        <div class="flex items-center my-4">
                            <div class="flex-grow border-t border-gray-300"></div>
                            <span class="mx-2 text-gray-400">or</span>
                            <div class="flex-grow border-t border-gray-300"></div>
                        </div>

                        <!-- Sign Up Button -->
                        <div class="flex flex-row justify-center gap-1">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}" class="text-red-500">Login</a>
                        </div> --}}
                    </div>

                    @if (session('success'))
                        <script>
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Account Successfully Update!",
                                showConfirmButton: false,
                                timer: 2500
                            });
                            setTimeout(function() {
                                window.location.href = "{{ route('applicant.setting') }}";
                            }, 2500);
                        </script>
                    @endif

                    {{-- @if ($errors->any())
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: `{!! implode('<br>', $errors->all()) !!}`,
                            confirmButtonColor: '#e3342f'
                        });
                    </script>
                @endif --}}
                </form>
            </div>
            <script>
                $('#province').on('change', function() {
                    let province = $(this).val();

                    $('#municipality').html('<option>Loading...</option>');
                    $('#barangay').html('<option>Select Barangay</option>');

                    $.post('/location/municipalities', {
                        province: province,
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        console.log('Municipalities data:', data);

                        $('#municipality').html('<option value="">Select Municipality/City</option>');
                        $.each(data, function(key, value) {
                            // Support both object or string arrays
                            let optionValue = typeof value === 'object' ? value.name || key : value;
                            let optionText = typeof value === 'object' ? value.name || key : value;

                            $('#municipality').append(
                                `<option value="${optionValue}">${optionText}</option>`);
                        });
                    }).fail(function(xhr) {
                        alert('Failed to load municipalities.');
                        $('#municipality').html('<option>Select Municipality/City</option>');
                    });
                });

                $('#municipality').on('change', function() {
                    let province = $('#province').val();
                    let municipality = $(this).val();

                    $('#barangay').html('<option>Loading...</option>');

                    $.post('/location/barangays', {
                        province: province,
                        municipality: municipality,
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        console.log('Barangays data:', data);

                        $('#barangay').html('<option value="">Select Barangay</option>');
                        $.each(data, function(index, barangay) {
                            // Support object or string arrays
                            let optionValue = typeof barangay === 'object' ? barangay.name || index :
                                barangay;
                            let optionText = typeof barangay === 'object' ? barangay.name || index :
                                barangay;

                            $('#barangay').append(`<option value="${optionValue}">${optionText}</option>`);
                        });
                    }).fail(function(xhr) {
                        alert('Failed to load barangays.');
                        $('#barangay').html('<option>Select Barangay</option>');
                    });
                });
            </script>


        @endsection
