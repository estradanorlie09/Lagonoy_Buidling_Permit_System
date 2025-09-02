@include('partials._header')
@include('components.landing_page_navbar')
<div class="fixed inset-0 bg-gray-900 opacity-10 z-0"></div>

{{-- login form --}}
<div class="flex flex-col md:flex-row justify-center items-center w-full min-h-screen p-4 rounded">

    <div class="w-full md:w-1/3 bg-white shadow-md p-6 z-50" style="height: 650px;">
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="flex justify-center mb-4">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-14 h-15 text-red-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg> --}}

                <img class="w-15 h-15" src="{{ asset('asset/icon/images.ico') }}" alt="logo">
            </div>
            <h1 class="text-2xl font-bold mb-4 text-center">Lagonoy Permit Management System</h1>
            <p class="text-gray-700 text-sm text-center">Please login your account</p>

            <div class="mt-10">
                <label for="#" class="#">Role</label><br />
                <select name="role" id="role"
                    class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">

                    <option value="">-- Please choose an option --</option>

                    <option value="applicant" {{ old('role') == 'applicant' ? 'selected' : '' }}>Applicant</option>
                    <option value="obo" {{ old('role') == 'obo' ? 'selected' : '' }}>Office of the Building Official
                    </option>
                    <option value="do" {{ old('role') == 'do' ? 'selected' : '' }}>Division Office</option>
                    <option value="bfp" {{ old('role') == 'bfp' ? 'selected' : '' }}>Bureau of Fire Protection
                    </option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>
            <div class="mt-3">
                <label for="email" class="text-gray-600">Email</label><br>
                <div class="relative">
                    <input type="text" id="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        class=" p-2 border border-gray-300 w-full  text-gray-500 font-normal focus:outline-none focus:ring-1 focus:ring-red-500">
                    <i class="fa-solid fa-user fa-sm mt-5 absolute top-0 right-0 mr-3 text-gray-400 cursor-pointer"
                        id="email"></i>
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3">
                <label for="password" class="text-gray-600">Password</label><br>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Password"
                        value="{{ old('password') }}"
                        class=" p-2 border border-gray-300 w-full  text-gray-500 font-normal focus:outline-none focus:ring-1 focus:ring-red-500">
                    <i class="fa-solid fa-eye-slash fa-sm mt-5 absolute top-0 right-0 mr-3 text-gray-400 cursor-pointer"
                        id="togglePassword"></i>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end mt-2">
                <a href="#" class="text-gray-400">Forget password?</a>
            </div>

            {{-- button login/signup --}}
            <div>
                <button type="submit" class="w-full mt-5 bg-red-600 text-white p-3">login</button>
                <div class="flex justify-center items-center">
                    <div class="w-1/2  border border-gray-300 bg-gray-300"></div>
                    <span class="p-2 text-gray-400">Or</span>
                    <div class="w-1/2  border border-gray-300 bg-gray-300"></div>
                </div>
                {{-- <button class="w-full mt-1 bg-gray-600 text-white p-3">SignUp</button> --}}
                <div class="flex flex-row justify-center gap-1">
                    <span>Don't have an account?</span>
                    <a href="{{ route('signup') }}" class="text-red-500">SignUp</a>
                </div>

            </div>
        </form>
    </div>



    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function() {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.classList.toggle("fa-eye");
        });


        // img slider
        const sliderImages = document.getElementById('slider-images');
        const prevBtn = document.getElementById('prev');
        const nextBtn = document.getElementById('next');

        let currentIndex = 0;
        const totalImages = sliderImages.children.length;

        function updateSlider() {
            const offset = -currentIndex * 100;
            sliderImages.style.transform = `translateX(${offset}%)`;
        }

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex === 0) ? totalImages - 1 : currentIndex - 1;
            updateSlider();
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex === totalImages - 1) ? 0 : currentIndex + 1;
            updateSlider();
        });
    </script>



    @include('partials._footer')
