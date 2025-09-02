@extends('layout.applicant.app')

@section('title', '📝Form')

@section('form')
    <div class="w-full mx-auto mt-10 p-6 bg-white rounded shadow" x-data="formTabs()">
        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <h1 class="text-3xl font-bold text-red-600 mb-4">Project Registration Form</h1>
            <p class="mb-6">Please fill out the form!</p>

            <!-- Tabs Header -->
            <div class="flex space-x-4 mb-6">
                <template x-for="(tabName, index) in tabs" :key="index">
                    <button type="button" @click="currentTab = index" class="pb-2"
                        :class="currentTab === index ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-600'"
                        x-text="tabName.label">
                    </button>
                </template>
            </div>
            <hr class="mb-5 border border-gray-300">

            <!-- Tab Content -->
            <!-- Personal Details -->
            <div x-show="currentTab === 0" class="space-y-4">
                @php
                    $user = Auth::user();
                @endphp

                <div x-data="{
                    selected: 'owner',
                    firstName: '{{ old('first_name', $user->first_name ?? '') }}',
                    middleName: '{{ old('middle_name', $user->middle_name ?? '') }}',
                    lastName: '{{ old('last_name', $user->last_name ?? '') }}',
                    user_email: '{{ old('email', $user->email ?? '') }}',
                    user_phone: '{{ old('phone', $user->phone ?? '') }}',
                    updateFields() {
                        if (this.selected === 'owner') {
                            this.firstName = '{{ $user->first_name ?? '' }}';
                            this.middleName = '{{ $user->middle_name ?? '' }}';
                            this.lastName = '{{ $user->last_name ?? '' }}';
                            this.email = '{{ $user->email ?? '' }}';
                            this.phone = '{{ $user->phone ?? '' }}';
                        } else {
                            this.firstName = '';
                            this.middleName = '';
                            this.lastName = '';
                            this.email = '';
                            this.phone = '';
                        }
                    }
                }" x-init="updateFields()" class="space-y-4">

                    <!-- Checkbox options -->
                    <div class="flex gap-10">
                        <div>
                            <input type="checkbox" id="owner" name="applicant_type" value="owner" x-model="selected"
                                @change="selected = 'owner'; updateFields()" :checked="selected === 'owner'">
                            <label for="owner">Owner</label>
                        </div>

                        <div>
                            <input type="checkbox" id="authorize" name="applicant_type" value="authorized"
                                x-model="selected" @change="selected = 'authorized'; updateFields()"
                                :checked="selected === 'authorized'">
                            <label for="authorize">Authorized Representative (Attach SPA)</label>
                        </div>
                    </div>

                    <!-- SPA file upload -->
                    <div x-show="selected === 'authorized'" x-transition>
                        <label for="spa_file" class="block font-medium mb-1 text-gray-700">
                            Upload Special Power of Attorney (SPA)
                        </label>
                        <div
                            class="flex items-center justify-between bg-gray-100 rounded-lg overflow-hidden border border-gray-300 hover:border-red-400 transition">
                            <input type="file" id="spa_file" name="spa_file"
                                class="w-full text-sm text-gray-700
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-l-md file:border-0
                       file:text-sm file:font-semibold
                       file:bg-red-500 file:text-white
                       hover:file:bg-red-600
                       cursor-pointer">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Allowed formats: PDF, JPG, PNG. Max size: 2MB.</p>
                    </div>

                    <!-- Owner Information -->
                    <div>
                        <h1 class="text-xl font-bold">Owner Information</h1>
                    </div>

                    <!-- Name fields -->
                    <div class="flex gap-5">
                        <div class="w-full">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="First Name"
                                x-model="firstName"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name"
                                x-model="middleName"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('middle_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name" x-model="lastName"
                                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                    <div class="w-full">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" x-model="email"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" id="phone" name="phone" placeholder="+69" x-model="phone"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div>
                    <h1 class="text-xl font-bold">Owner's Address(No., Street, Barangay, City/Municipality)</h1>
                </div>
                <div class="w-full">
                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                    <input type="text" id="country" name="country" placeholder="Country"
                        value="{{ old('Philippines') }} Philippines" disabled
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                </div>
                <div class="flex sm:flex gap-5  md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                    <div class="w-full">
                        <label for="province">Province</label>
                        <select id="province" name="province"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Province</option>

                            @foreach ($provinces as $provinceName => $provinceData)
                                <option value="{{ $provinceName }}">{{ $provinceName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="municipality">Municipality/City</label>
                        <select id="municipality" name="municipality"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Municipality/City</option>
                        </select>
                    </div>
                    <div class="w-full">
                        {{-- Barangay --}}
                        <label for="barangay">Barangay</label>
                        <select id="barangay" name="barangay"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                    <div class="w-full">
                        <label for="street" class="block text-sm font-medium text-gray-700">Street</label>
                        <input type="text" id="street" name="street" placeholder="Street"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">


                    </div>
                    <div class="w-full">
                        <label for="zipcode" class="block text-sm font-medium text-gray-700">Zip Code</label>
                        <input type="text" id="zipcode" name="zipcode" placeholder="Zip Code"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                    </div>

                </div>

            </div>

            <!-- Project Details -->
            <div x-show="currentTab === 1" class="space-y-4">
                <div>
                    <h1 class="text-xl font-bold">Type of Ownership</h1>
                </div>
                <div class="flex flex-wrap gap-10" x-data="{ ownershipType: 'sole_proprietorship' }">
                    <div>
                        <input type="radio" id="sole_proprietorship" name="ownership_type" value="sole_proprietorship"
                            x-model="ownershipType">
                        <label for="sole_proprietorship">Sole Proprietorship</label>
                    </div>

                    <div>
                        <input type="radio" id="partnership" name="ownership_type" value="partnership"
                            x-model="ownershipType">
                        <label for="partnership">Partnership / Corporation</label>
                    </div>

                    <div>
                        <input type="radio" id="community" name="ownership_type" value="community"
                            x-model="ownershipType">
                        <label for="community">Community Association</label>
                    </div>

                    <div>
                        <input type="radio" id="government" name="ownership_type" value="government"
                            x-model="ownershipType">
                        <label for="government">Government</label>
                    </div>
                </div>
                <div class="mt-5">
                    <h1 class="text-xl font-bold">Project Location (No.,Street,Barangay,City/Municipality)</h1>
                </div>
                <div class="w-full">
                    <label for="street" class="block text-sm font-medium text-gray-700">Lot No./Blk No./Street</label>
                    <input type="text" id="street" name="street" placeholder="Lot No./Blk No./Street"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                </div>
                <div class="flex sm:flex gap-5  md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                    <div class="w-full">
                        <label for="project_province">Province</label>
                        <select id="project_province" name="project_province"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Province</option>

                            @foreach ($provinces as $provinceName => $provinceData)
                                <option value="{{ $provinceName }}">{{ $provinceName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="project_municipality">Municipality/City</label>
                        <select id="project_municipality" name="project_municipality"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Municipality/City</option>
                        </select>
                    </div>
                    <div class="w-full">
                        {{-- Barangay --}}
                        <label for="project_barangay">Barangay</label>
                        <select id="project_barangay" name="project_barangay"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="w-full">
                        <label for="project_cost" class="block text-sm font-medium text-gray-700">Project Cost (₱)</label>
                        <input type="text" id="project_cost" name="project_cost" placeholder="Project Cost💵 "
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                    </div>

                    <div class="w-full">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Proposed Date of
                            Construction</label>
                        <input type="date" id="start_date" name="start_date" placeholder="Start Date"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                    </div>

                    <div class="w-full">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Proposed Date of
                            Completion</label>
                        <input type="date" id="end_date" name="end_date" placeholder="End Date"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                    </div>
                </div>

            </div>


            <!-- Other Info -->
            <div x-show="currentTab === 2" class="space-y-4">
                <div>
                    <h1 class="text-xl font-bold">Profession</h1>
                </div>
                <div class="flex flex-wrap gap-10" x-data="{ profession_type: 'architech' }">
                    <div>
                        <input type="radio" id="architech" name="ownership_type" value="architech"
                            x-model="profession_type">
                        <label for="architech">Architech</label>
                    </div>
                    <div>
                        <input type="radio" id="engineer" name="engineer" value="engineer"
                            x-model="profession_type">
                        <label for="engineer">Civil Engineer</label>
                    </div>
                </div>
                <div class="mt-5">
                    <h1 class="text-xl font-bold">Full Name of Your Architech / Engineer</h1>
                </div>
                <div class="flex gap-3">
                    <div class="w-full">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="first_name_pr" name="first_name_pr" placeholder="First Name"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                    </div>

                    <div class="w-full">
                        <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                    </div>

                    <div class="w-full">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Last Name"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                    </div>
                    <div class="w-1/4">
                        <label for="sufix" class="block text-sm font-medium text-gray-700">Sufix</label>
                        <input type="text" id="sufix" name="sufix" placeholder="Sufix"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                    </div>
                </div>
                <div class="mt-5">
                    <h1 class="text-xl font-bold">Address of Your Architech / Engineer</h1>
                </div>
                <div class="w-full">
                    <label for="street" class="block text-sm font-medium text-gray-700">Lot No./Blk No./Street</label>
                    <input type="text" id="street" name="street" placeholder="Lot No./Blk No./Street"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                </div>
                <div class="flex sm:flex gap-5  md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                    <div class="w-full">
                        <label for="project_province_pr">Province</label>
                        <select id="project_province_pr" name="project_province_pr"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Province</option>

                            @foreach ($provinces as $provinceName => $provinceData)
                                <option value="{{ $provinceName }}">{{ $provinceName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="project_municipality_pr">Municipality/City</label>
                        <select id="project_municipality_pr" name="project_municipality_pr"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Municipality/City</option>
                        </select>
                    </div>
                    <div class="w-full">
                        {{-- Barangay --}}
                        <label for="project_barangay_pr">Barangay</label>
                        <select id="project_barangay_pr" name="project_barangay_pr"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 mb-6">
                    <div class="w-full">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" id="phone" name="phone" placeholder="+69"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-5">
                    <h1 class="text-xl font-bold">License 🪪</h1>
                </div>
                <div class="flex flex-col md:flex-row md:space-x-5">
                    <!-- Left side: Form fields -->
                    <div class="w-full md:w-1/2 space-y-6">
                        <!-- PRC Number and Validity -->
                        <div class="flex flex-col md:flex-row md:space-x-5">
                            <div class="w-full md:w-1/2">
                                <label for="prc_number" class="block text-sm font-medium text-gray-700">PRC Number</label>
                                <input type="text" id="prc_number" name="prc_number" placeholder="0000-0000-0000"
                                    class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" />
                            </div>
                            <div class="w-full md:w-1/2 mt-4 md:mt-0">
                                <label for="validity" class="block text-sm font-medium text-gray-700">Validity</label>
                                <input type="date" id="validity" name="validity"
                                    class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" />
                            </div>
                        </div>

                        <!-- PTR Number and Date Issued -->
                        <div class="flex flex-col md:flex-row md:space-x-5">
                            <div class="w-full md:w-1/2">
                                <label for="ptr_number" class="block text-sm font-medium text-gray-700">PTR Number</label>
                                <input type="text" id="ptr_number" name="ptr_number" placeholder="0000-0000-0000"
                                    class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" />
                            </div>
                            <div class="w-full md:w-1/2 mt-4 md:mt-0">
                                <label for="date_issued" class="block text-sm font-medium text-gray-700">Date
                                    Issued</label>
                                <input type="date" id="date_issued" name="date_issued"
                                    class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" />
                            </div>
                        </div>

                        <!-- Place Issued and TIN ID -->
                        <div class="flex flex-col md:flex-row md:space-x-5">
                            <div class="w-full md:w-1/2">
                                <label for="place_issued" class="block text-sm font-medium text-gray-700">Place
                                    Issued</label>
                                <input type="text" id="place_issued" name="place_issued" placeholder="Place Issued"
                                    class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" />
                            </div>
                            <div class="w-full md:w-1/2 mt-4 md:mt-0">
                                <label for="tin_id" class="block text-sm font-medium text-gray-700">TIN ID</label>
                                <input type="text" id="tin_id" name="tin_id" placeholder="XXXX-XXXX-XXXX"
                                    class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" />
                            </div>
                        </div>
                    </div>

                    <!-- Right side: File upload -->
                    <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <!-- File icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                            </svg>
                            Upload Documents (PRC ID and PTR (recent) with 3 signature specimen)
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-1" class="hidden" multiple
                            onchange="handleFiles(this, 'file-info-1')" />


                        <!-- Styled label acting as button -->
                        <label for="documents-1"
                            class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Choose Files
                        </label>

                        <!-- File names list and preview button container -->
                        <div id="file-info-1" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                    </div>
                </div>

            </div>
            <div x-show="currentTab === 3" class="space-y-4">
                <div class="mt-5">
                    <h1 class="text-xl font-bold">Building Plan 🏢</h1>
                </div>
                <div class="flex flex-col md:flex-row md:space-x-5">
                    <!-- Left side: Form fields -->
                    <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <!-- File icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                            </svg>
                            Upload Documents (Site Development Plans)
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-2" class="hidden" multiple
                            onchange="handleFiles(this, 'file-info-2')" />

                        <!-- Styled label acting as button -->
                        <label for="documents-2"
                            class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Choose Files
                        </label>

                        <!-- File names list and preview button container -->
                        <div id="file-info-2" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                    </div>

                    <!-- Right side: File upload -->
                    <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <!-- File icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                            </svg>
                            Upload Documents (Floor Plans)
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-3" class="hidden" multiple
                            onchange="handleFiles(this, 'file-info-3')" />

                        <!-- Styled label acting as button -->
                        <label for="documents-3"
                            class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Choose Files
                        </label>

                        <!-- File names list and preview button container -->
                        <div id="file-info-3" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row md:space-x-5">
                    <!-- Left side: Form fields -->
                    <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <!-- File icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                            </svg>
                            Upload Documents (4-Elevations )
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-4" class="hidden" multiple
                            onchange="handleFiles(this, 'file-info-4')" />

                        <!-- Styled label acting as button -->
                        <label for="documents-4"
                            class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Choose Files
                        </label>

                        <!-- File names list and preview button container -->
                        <div id="file-info-4" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                    </div>

                    <!-- Right side: File upload -->
                    <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <!-- File icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                            </svg>
                            Upload Documents (2-Sections)
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-5" class="hidden" multiple
                            onchange="handleFiles(this, 'file-info-5')" />
                        <!-- Styled label acting as button -->
                        <label for="documents-5"
                            class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Choose Files
                        </label>

                        <!-- File names list and preview button container -->
                        <div id="file-info-5" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row md:space-x-5">
                    <!-- Left side: Form fields -->
                    <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <!-- File icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                            </svg>
                            Upload Documents (Sketch Plans)
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-6" class="hidden" multiple
                            onchange="handleFiles(this, 'file-info-6')" />

                        <!-- Styled label acting as button -->
                        <label for="documents-6"
                            class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Choose Files
                        </label>

                        <!-- File names list and preview button container -->
                        <div id="file-info-6" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                    </div>

                    <!-- Right side: File upload -->
                    <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <!-- File icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                            </svg>
                            Upload Documents (Perspective)
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-7" class="hidden" multiple
                            onchange="handleFiles(this, 'file-info-7')" />

                        <!-- Styled label acting as button -->
                        <label for="documents-7"
                            class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Choose Files
                        </label>

                        <!-- File names list and preview button container -->
                        <div id="file-info-7" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                    </div>
                </div>
            </div>
            <!-- Navigation Buttons -->
            <div class="mt-6 flex justify-between">
                <button type="button" class="text-gray-600 hover:underline" @click="previousTab"
                    x-show="currentTab > 0">←
                    Previous</button>

                <div class="ml-auto">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                        @click="nextTab" x-show="currentTab < tabs.length - 1">Next →</button>

                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700"
                        x-show="currentTab === tabs.length - 1">Submit</button>
                </div>
            </div>

        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function handleFiles(inputElement, containerId) {
            const fileInfo = document.getElementById(containerId);
            fileInfo.innerHTML = '';

            const files = inputElement.files;
            if (files.length === 0) {
                fileInfo.textContent = 'No files selected';
                return;
            }

            Array.from(files).forEach(file => {
                const fileDiv = document.createElement('div');
                fileDiv.classList.add('flex', 'items-center', 'justify-between', 'gap-3');

                const fileNameSpan = document.createElement('span');
                fileNameSpan.textContent = file.name;
                fileNameSpan.classList.add('truncate', 'max-w-xs');

                const previewButton = document.createElement('button');
                previewButton.textContent = 'Preview';
                previewButton.className = 'text-red-500 underline text-sm hover:text-red-700 focus:outline-none';
                previewButton.type = 'button';

                previewButton.onclick = () => {
                    const fileURL = URL.createObjectURL(file);
                    window.open(fileURL);
                };

                fileDiv.appendChild(fileNameSpan);
                fileDiv.appendChild(previewButton);
                fileInfo.appendChild(fileDiv);
            });
        }
    </script>
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

    {{-- for project address --}}
    <script>
        $('#project_province').on('change', function() {
            let province = $(this).val();

            $('#project_municipality').html('<option>Loading...</option>');
            $('#project_barangay').html('<option>Select Barangay</option>');

            $.post('/location/municipalities', {
                province: province,
                _token: '{{ csrf_token() }}'
            }, function(data) {
                console.log('Municipalities data:', data);

                $('#project_municipality').html('<option value="">Select Municipality/City</option>');
                $.each(data, function(key, value) {
                    // Support both object or string arrays
                    let optionValue = typeof value === 'object' ? value.name || key : value;
                    let optionText = typeof value === 'object' ? value.name || key : value;

                    $('#project_municipality').append(
                        `<option value="${optionValue}">${optionText}</option>`);
                });
            }).fail(function(xhr) {
                alert('Failed to load municipalities.');
                $('#project_municipality').html('<option>Select Municipality/City</option>');
            });
        });

        $('#project_municipality').on('change', function() {
            let province = $('#project_province').val();
            let municipality = $(this).val();

            $('#project_barangay').html('<option>Loading...</option>');

            $.post('/location/barangays', {
                province: province,
                municipality: municipality,
                _token: '{{ csrf_token() }}'
            }, function(data) {
                console.log('Barangays data:', data);

                $('#project_barangay').html('<option value="">Select Barangay</option>');
                $.each(data, function(index, barangay) {
                    // Support object or string arrays
                    let optionValue = typeof barangay === 'object' ? barangay.name || index :
                        barangay;
                    let optionText = typeof barangay === 'object' ? barangay.name || index :
                        barangay;

                    $('#project_barangay').append(
                        `<option value="${optionValue}">${optionText}</option>`);
                });
            }).fail(function(xhr) {
                alert('Failed to load barangays.');
                $('#project_barangay').html('<option>Select Barangay</option>');
            });
        });
    </script>

    {{-- for engineer address --}}
    <script>
        $('#project_province_pr').on('change', function() {
            let province = $(this).val();

            $('#project_municipality_pr').html('<option>Loading...</option>');
            $('#project_barangay_pr').html('<option>Select Barangay</option>');

            $.post('/location/municipalities', {
                province: province,
                _token: '{{ csrf_token() }}'
            }, function(data) {
                console.log('Municipalities data:', data);

                $('#project_municipality_pr').html('<option value="">Select Municipality/City</option>');
                $.each(data, function(key, value) {
                    // Support both object or string arrays
                    let optionValue = typeof value === 'object' ? value.name || key : value;
                    let optionText = typeof value === 'object' ? value.name || key : value;

                    $('#project_municipality_pr').append(
                        `<option value="${optionValue}">${optionText}</option>`);
                });
            }).fail(function(xhr) {
                alert('Failed to load municipalities.');
                $('#project_municipality_pr').html('<option>Select Municipality/City</option>');
            });
        });

        $('#project_municipality_pr').on('change', function() {
            let province = $('#project_province_pr').val();
            let municipality = $(this).val();

            $('#project_barangay_pr').html('<option>Loading...</option>');

            $.post('/location/barangays', {
                province: province,
                municipality: municipality,
                _token: '{{ csrf_token() }}'
            }, function(data) {
                console.log('Barangays data:', data);

                $('#project_barangay_pr').html('<option value="">Select Barangay</option>');
                $.each(data, function(index, barangay) {
                    // Support object or string arrays
                    let optionValue = typeof barangay === 'object' ? barangay.name || index :
                        barangay;
                    let optionText = typeof barangay === 'object' ? barangay.name || index :
                        barangay;

                    $('#project_barangay_pr').append(
                        `<option value="${optionValue}">${optionText}</option>`);
                });
            }).fail(function(xhr) {
                alert('Failed to load barangays.');
                $('#project_barangay_pr').html('<option>Select Barangay</option>');
            });
        });
    </script>
    <script>
        function formTabs() {
            return {
                currentTab: 0,
                tabs: [{
                        label: 'Owner Information'
                    },
                    {
                        label: 'Project Details'
                    },
                    {
                        label: 'Designing Eng. / Architech Info.'
                    },
                    {
                        label: 'Documents'
                    },

                ],
                nextTab() {
                    if (this.currentTab < this.tabs.length - 1) {
                        this.currentTab++;
                    }
                },
                previousTab() {
                    if (this.currentTab > 0) {
                        this.currentTab--;
                    }
                }
            };
        }
    </script>
@endsection
