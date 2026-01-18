@include('partials._header')
@include('components.landing_page_navbar')
{{-- <div class="fixed inset-0 bg-gray-900 opacity-10 z-0"></div> --}}

{{-- signup form --}}
<div class="flex flex-col md:flex-row justify-center items-center w-full min-h-screen p-4 rounded">


    <div class="w-full max-w-4xl mx-auto bg-white shadow-md p-6 md:p-10 z-50 rounded-lg">

        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Logo Section -->
            <div class="flex justify-center mb-4">
                <img class="w-16 h-16" src="{{ asset('asset/icon/images.ico') }}" alt="logo">
            </div>

            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-blue-800 mb-1">Lagonoy Building Permit Management System</h1>
                <h2 class="text-xl font-semibold text-blue-800 mb-2 border-b-2 border-gray-300 inline-block pb-1">
                    Pre-Registration Form</h2>
                <p class="text-gray-500 text-sm">Please fill out the details below to create your account</p>
            </div>

            <!-- Role Dropdown -->
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role"
                    class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-blue-500">

                    {{-- <option value="">-- Please choose an option --</option> --}}

                    <option value="applicant" {{ old('role') == 'applicant' ? 'selected' : '' }}>Applicant</option>
                    {{-- <option value="obo" {{ old('role') == 'obo' ? 'selected' : '' }}>Office of the Building Official
                    </option>
                    <option value="do" {{ old('role') == 'do' ? 'selected' : '' }}>Division Office</option>
                    <option value="bfp" {{ old('role') == 'bfp' ? 'selected' : '' }}>Bureau of Fire Protection
                    </option> --}}
                </select>

                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Name Inputs: Responsive Row -->
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                <div class="w-full">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="First Name"
                        value="{{ old('first_name') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full">
                    <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name"
                        value="{{ old('middle_name') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('middle_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Last Name"
                        value="{{ old('last_name') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex items-center flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                <div class="w-full">
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                    <input type="date" id="birth_date" name="birth_date" placeholder="Birth Date"
                        value="{{ old('birth_date') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('birth_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" id="gender"
                        class="w-full border border-gray-300 text-sm rounded mt-1 px-3 py-[11px] focus:outline-none focus:ring-1 focus:ring-blue-500">

                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>

                    </select>
                    @error('birth_date')
                        <p class="text-white text-sm mt-1">-</p>
                    @enderror
                </div>

            </div>

            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                <div class="w-full">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full relative">
                    <!-- add relative here -->
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password"
                        value="{{ old('password') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <i class="fa-solid fa-eye-slash fa-sm absolute top-11 right-3 text-gray-400 cursor-pointer"
                        id="togglePassword"></i>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full relative">
                    <!-- add relative here -->
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confirm Password" value="{{ old('password') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <i class="fa-solid fa-eye-slash fa-sm absolute top-11 right-3 text-gray-400 cursor-pointer"
                        id="togglePassword1"></i>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                <div class="w-full">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="+69"
                        value="{{ old('phone') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <!-- Pre-Registration Fields -->
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                <div class="w-full">
                    <label for="tin_number" class="block text-sm font-medium text-gray-700">TIN Number</label>
                    <input type="text" id="tin_number" name="tin_number" placeholder="123-456-789"
                        value="{{ old('tin_number') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('tin_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full">
                    <label for="gov_id_file" class="block text-sm font-medium text-gray-700">Government ID
                        Upload</label>
                    <input type="file" id="gov_id_file" name="gov_id_file"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <span class="text-gray-500 text-xs">Accepted formats: JPG, PNG, PDF</span>
                    @error('gov_id_file')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                <div class="w-full">
                    <label for="tax_declaration_file" class="block text-sm font-medium text-gray-700">Tax Declaration
                        Upload</label>
                    <input type="file" id="tax_declaration_file" name="tax_declaration_file"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <span class="text-gray-500 text-xs">Accepted formats: JPG, PNG, PDF</span>
                    @error('tax_declaration_file')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full">
                    <label for="tax_declaration_no" class="block text-sm font-medium text-gray-700">Tax Declaration
                        Number</label>
                    <input type="text" id="tax_declaration_no" name="tax_declaration_no"
                        placeholder="Enter Tax Declaration Number" value="{{ old('tax_declaration_no') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('tax_declaration_no')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <!-- Disclaimer Message -->
            <div class="mb-4 p-3 bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 text-sm rounded">
                <strong>Disclaimer:</strong> By signing up, you confirm that you are 18 years or older,
                and the information and documents you provide (TIN, Government ID, Tax Declaration)
                are legitimate and accurate. Misrepresentation may result in account suspension.
            </div>
            <!-- Login & Signup Buttons -->
            <div>
                <button type="submit"
                    class="w-full mt-4 bg-red-600 text-white p-3 rounded hover:bg-red-700 transition">
                    Pre-Register
                </button>

                <!-- Divider -->
                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-2 text-gray-400">or</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Sign Up Button -->
                <div class="flex flex-row justify-center gap-1">
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}" class="text-blue-500 font-extrabold">Login</a>
                </div>
            </div>

            @if (session('success'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Account Created!",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function() {
                        window.location.href = "{{ route('login') }}";
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
        const togglePassword = document.querySelector("#togglePassword");
        const togglePassword1 = document.querySelector("#togglePassword1");
        const password = document.querySelector("#password");
        const password1 = document.querySelector("#password_confirmation");

        togglePassword.addEventListener("click", function() {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.classList.toggle("fa-eye");
        });

        togglePassword1.addEventListener("click", function() {
            const type = password1.getAttribute("type") === "password" ? "text" : "password";
            password1.setAttribute("type", type);
            this.classList.toggle("fa-eye");
        });
    </script>

    @include('partials._footer')
