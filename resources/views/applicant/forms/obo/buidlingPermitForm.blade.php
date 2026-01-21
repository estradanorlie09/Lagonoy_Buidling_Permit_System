@extends('layout.applicant.app')

@section('title', 'Building Permit Form')

@section('content')
    <div class="w-full mx-auto p-6 bg-white rounded shadow" x-data="formTabs()">
        <form id="buildingForm" method="POST" action="{{ route('building_application.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 mb-6 shadow-md overflow-hidden">
                <!-- Subtle Background Pattern -->
                <div class="absolute right-0 top-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>

                <!-- Back Button -->
                <a href="{{ route('applicant.buildingPermit') }}"
                    class="absolute top-4 right-4 inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs font-semibold rounded-lg backdrop-blur-sm transition-all duration-200 z-10">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <!-- Content -->
                <div class="relative z-10 pr-24">
                    <!-- Header -->
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                            <i class="fa-solid fa-building text-white text-xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-white">
                            Building Permit Application
                        </h1>
                    </div>

                    <!-- Description -->
                    <p class="text-blue-100 text-sm mb-3">
                        Submit your building permit application. Ensure all information is accurate for review by the Office
                        of the Building Official (OBO).
                    </p>

                    <!-- Quick Info -->
                    <div class="flex flex-wrap gap-4 text-xs">
                        <div class="flex items-center gap-2 text-blue-50">
                            <i class="fas fa-clock text-blue-200"></i>
                            <span>Processing: 3–5 working days</span>
                        </div>
                        <div class="flex items-center gap-2 text-blue-50">
                            <i class="fas fa-check-circle text-blue-200"></i>
                            <span>Secure & Verified</span>
                        </div>
                    </div>
                </div>
            </div>


            <input type="text" value="submitted" name="status" hidden>
            <!-- Tabs Header -->
            <div class="flex space-x-4 mb-6">
                <template x-for="(tabName, index) in tabs" :key="index">
                    <button type="button" @click="setTab(index)" class="pb-2"
                        :class="currentTab === index ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600'"
                        x-text="tabName.label">
                    </button>
                </template>
            </div>

            <hr class="mb-5 border border-gray-300">
            @if ($errors->any())
                <div id="validation-errors" class="mb-6 border-l-4 border-red-500 bg-red-50 rounded-lg p-5 shadow-md">
                    <!-- Header -->
                    <div class="flex items-start gap-3 mb-3">
                        <div class="p-2 bg-red-100 rounded-lg flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-red-800 text-base">Validation Error</h3>
                            <p class="text-red-700 text-sm mt-0.5">Please review and correct the following issues:</p>
                        </div>
                    </div>

                    <!-- Error List -->
                    <div class="bg-white rounded-lg p-4 border border-red-200">
                        <ul class="space-y-2">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2 text-sm text-gray-700">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Action Hint -->
                    <div class="mt-3 flex items-center gap-2 text-xs text-red-600">
                        <i class="fas fa-lightbulb"></i>
                        <span>Scroll up to find and correct the highlighted fields</span>
                    </div>
                </div>

            @endif


            <!-- Personal Details -->
            <div x-show="currentTab === 0" class="space-y-4">
                <div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-gray-100">
                    <!-- Header -->
                    <div class="flex items-center gap-3 mb-5">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fa-solid fa-list-check text-blue-600 text-lg"></i>
                        </div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Submission Checklist
                        </h2>
                    </div>

                    <!-- Quick Description -->
                    <p class="text-sm text-gray-600 mb-5">
                        Ensure all documents comply with <strong>PD 1096 (National Building Code)</strong> for safe and
                        compliant construction projects.
                    </p>

                    <!-- Steps in Compact Format -->
                    <div class="space-y-3 mb-6">
                        <div class="flex gap-3 items-start">
                            <div
                                class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white text-xs font-bold rounded-full">
                                1</div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Prepare Required Documents</p>
                                <p class="text-xs text-gray-500 mt-1">Building Permit Form • Proof of Ownership • Barangay
                                    Clearance • Zoning Clearance • Technical Plans (signed by licensed professionals) • Bill
                                    of Materials • Fire Safety Certificate</p>
                            </div>
                        </div>

                        <div class="flex gap-3 items-start">
                            <div
                                class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white text-xs font-bold rounded-full">
                                2</div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Open Building Permit Record</p>
                                <p class="text-xs text-gray-500 mt-1">Log in and locate your application in the system</p>
                            </div>
                        </div>

                        <div class="flex gap-3 items-start">
                            <div
                                class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white text-xs font-bold rounded-full">
                                3</div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Upload Documents</p>
                                <p class="text-xs text-gray-500 mt-1">Go to Building Permit Documents section and upload all
                                    files (PDF or image format)</p>
                            </div>
                        </div>

                        <div class="flex gap-3 items-start">
                            <div
                                class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white text-xs font-bold rounded-full">
                                4</div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Submit Application</p>
                                <p class="text-xs text-gray-500 mt-1">Click Submit to send documents for review by the
                                    Office of Building Official (OBO)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fa-solid fa-lightbulb text-amber-500 text-base"></i>
                            <h3 class="text-sm font-semibold text-gray-800">Important Notes</h3>
                        </div>
                        <ul class="space-y-2 text-xs text-gray-700">
                            <li class="flex gap-2">
                                <span class="text-blue-600 font-bold">•</span>
                                <span>All technical plans must be <strong>signed and sealed by licensed
                                        professionals</strong></span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-blue-600 font-bold">•</span>
                                <span>Documents must be <strong>clear, complete, and properly labeled</strong></span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-blue-600 font-bold">•</span>
                                <span>Incomplete submissions may <strong>delay processing</strong></span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-blue-600 font-bold">•</span>
                                <span>You'll receive <strong>system notifications</strong> about review status and
                                    revisions</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <!-- Project Details -->
            <div x-show="currentTab === 1" class="space-y-6">

                <!-- Section Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-5 mb-6 shadow-md text-white">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-clipboard-list text-xl"></i>
                        <div>
                            <h1 class="text-xl font-bold">Project Information</h1>
                            <p class="text-blue-100 text-xs mt-0.5">Fields marked with <span class="font-bold">*</span> are
                                required</p>
                        </div>
                    </div>
                </div>

                <!-- Application Type -->
                <div class="mb-5">
                    <label for="type_of_application" class="block text-sm font-semibold text-gray-700 mb-2">
                        Type of Application <span class="text-blue-600">*</span>
                    </label>
                    <select id="type_of_application" name="type_of_application"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="" disabled selected>Select application type</option>
                        <option value="new">New</option>
                        <option value="renewal">Renewal</option>
                        <option value="amendatory">Amendatory</option>
                    </select>
                </div>

                <!-- Occupancy & Classification Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="occupancy_type" class="block text-sm font-semibold text-gray-700 mb-2">
                            Type of Occupancy <span class="text-blue-600">*</span>
                        </label>
                        <select id="occupancy_type" name="occupancy_type"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="">Select occupancy type</option>
                            <option value="residential">Residential</option>
                            <option value="commercial">Commercial</option>
                            <option value="industrial">Industrial</option>
                            <option value="institutional">Institutional</option>
                            <option value="agricultural">Agricultural</option>
                            <option value="recreational">Recreational</option>
                            <option value="mixed_use">Mixed Use</option>
                        </select>
                    </div>

                    <div>
                        <label for="classified_as" class="block text-sm font-semibold text-gray-700 mb-2">
                            Classification <span class="text-blue-600">*</span>
                        </label>
                        <select id="classified_as" name="classified_as"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="">Select classification</option>
                            <option value="group_a">Group A – Residential Dwellings</option>
                            <option value="group_b">Group B – Apartments / Dormitories</option>
                            <option value="group_c">Group C – Educational / Recreational</option>
                            <option value="group_d">Group D – Institutional</option>
                            <option value="group_e">Group E – Business & Mercantile</option>
                            <option value="group_f">Group F – Industrial</option>
                            <option value="group_g">Group G – Storage & Hazardous</option>
                            <option value="group_h">Group H – Assembly (Load &lt; 1000)</option>
                            <option value="group_i">Group I – Assembly (Load ≥ 1000)</option>
                            <option value="group_j">Group J – Accessory Structures</option>
                        </select>
                    </div>
                </div>

                <!-- Project Details Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                    <div>
                        <label for="project_title" class="block text-sm font-semibold text-gray-700 mb-2">
                            Project Title <span class="text-blue-600">*</span>
                        </label>
                        <input type="text" id="project_title" name="project_title"
                            placeholder="e.g., Two-Storey House"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="number_of_floor" class="block text-sm font-semibold text-gray-700 mb-2">
                            Number of Floors <span class="text-blue-600">*</span>
                        </label>
                        <input type="number" id="number_of_floor" name="number_of_floor" placeholder="e.g., 2"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="estimated_cost" class="block text-sm font-semibold text-gray-700 mb-2">
                            Estimated Cost <span class="text-blue-600">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">₱</span>
                            <input type="text" id="estimated_cost" name="estimated_cost" placeholder="1,200,000"
                                class="w-full pl-7 border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Area Information Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="floor_area" class="block text-sm font-semibold text-gray-700 mb-2">
                            Floor Area (sq.m.) <span class="text-blue-600">*</span>
                        </label>
                        <input type="text" id="floor_area" name="floor_area" placeholder="e.g., 150"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="lot_area" class="block text-sm font-semibold text-gray-700 mb-2">
                            Lot Area (sq.m.) <span class="text-blue-600">*</span>
                        </label>
                        <input type="text" id="lot_area" name="lot_area" placeholder="e.g., 200"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- FAR (Auto-calculated) -->
                <div class="mb-5 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-calculator text-blue-600 mt-0.5"></i>
                        <div class="flex-1">
                            <label for="floor_area_ratio" class="block text-sm font-semibold text-gray-700 mb-1">
                                Floor Area Ratio (FAR)
                            </label>
                            <input type="text" id="floor_area_ratio" name="floor_area_ratio"
                                placeholder="Auto-calculated" readonly
                                class="w-full border border-blue-300 bg-white rounded-lg p-2 text-sm text-gray-700 focus:outline-none">
                            <p class="text-xs text-gray-500 mt-1">Computed automatically: Floor Area ÷ Lot Area</p>
                        </div>
                    </div>
                </div>

                <!-- Title & Certificate Info Row -->


                <!-- Additional Notes -->
                <div class="mb-5">
                    <label for="comments" class="block text-sm font-semibold text-gray-700 mb-2">
                        Additional Notes (Optional)
                    </label>
                    <textarea id="comments" name="comments" rows="3" maxlength="500"
                        placeholder="Add any special considerations or remarks"
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Max 500 characters</p>
                </div>
            </div>
            <div x-show="currentTab === 2" class="space-y-6">
                <!-- Location Selection Row -->
                <!-- Location Header -->
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-200 rounded-lg p-4 mb-5 mt-8">
                    <h2 class="text-lg font-bold text-indigo-700 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot"></i> Location of Property
                    </h2>
                    <p class="text-xs text-gray-600 mt-1">Provide complete address and select province, city, and barangay
                    </p>
                </div>

                <!-- Full Address -->
                <div class="mb-5">
                    <label for="property_address" class="block text-sm font-semibold text-gray-700 mb-2">
                        Property Address <span class="text-blue-600">*</span>
                    </label>
                    <input type="text" id="property_address" name="property_address"
                        placeholder="House No., Street, Subdivision"
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                    <div>
                        <label for="project_province" class="block text-sm font-semibold text-gray-700 mb-2">
                            Province <span class="text-blue-600">*</span>
                        </label>
                        <select id="project_province" name="province"
                            class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Province</option>
                            @foreach ($provinces as $provinceName => $provinceData)
                                <option value="{{ $provinceName }}"
                                    {{ old('province') == $provinceName ? 'selected' : '' }}>
                                    {{ $provinceName }}
                                </option>
                            @endforeach
                        </select>
                        @error('province')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="project_municipality" class="block text-sm font-semibold text-gray-700 mb-2">
                            City / Municipality <span class="text-blue-600">*</span>
                        </label>
                        <select id="project_municipality" name="municipality"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select City / Municipality</option>
                        </select>
                        @error('municipality')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="project_barangay" class="block text-sm font-semibold text-gray-700 mb-2">
                            Barangay <span class="text-blue-600">*</span>
                        </label>
                        <select id="project_barangay" name="barangay"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Barangay</option>
                        </select>
                        @error('barangay')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div x-show="currentTab === 3" class="space-y-6">
                <!-- Legal & Scope Section Header -->
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-200 rounded-lg p-4 mb-5 mt-8">
                    <h2 class="text-lg font-bold text-indigo-700 flex items-center gap-2">
                        <i class="fa-solid fa-file-contract"></i> Legal & Project Scope
                    </h2>
                    <p class="text-xs text-gray-600 mt-1">Provide TCT, Fire Safety Certificate, and project scope
                        information</p>
                </div>

                <!-- TCT, FSEC, and Date Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                    <div>
                        <label for="tct_no" class="block text-sm font-semibold text-gray-700 mb-2">
                            TCT No. <span class="text-blue-600">*</span>
                        </label>
                        <input type="text" id="tct_no" name="tct_no" placeholder="TCT NO."
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label for="fsec_no" class="block text-sm font-semibold text-gray-700 mb-2">
                            FSEC No. <span class="text-blue-600">*</span>
                        </label>
                        <input type="text" id="fsec_no" name="fsec_no" placeholder="FSEC NO."
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label for="fsec_issued_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            FSEC Issued Date <span class="text-blue-600">*</span>
                        </label>
                        <input type="date" id="fsec_issued_date" name="fsec_issued_date"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Scope of Works -->
                <div class="mb-5">
                    <label for="scope_of_work" class="block text-sm font-semibold text-gray-700 mb-2">
                        Scope of Works <span class="text-blue-600">*</span>
                    </label>
                    <textarea id="scope_of_work" name="scope_of_work" rows="3" maxlength="500"
                        placeholder="Describe the specific work to be done"
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Max 500 characters</p>
                </div>
            </div>
            <div x-show="currentTab === 4" class="space-y-6">

                <!-- Header -->
                <!-- Section Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl p-5 mb-5 shadow-md text-white">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-user-tie text-xl"></i>
                        <div>
                            <h1 class="text-xl font-bold">Project Professionals</h1>
                            <p class="text-indigo-100 text-xs mt-0.5">Licensed professionals with valid <strong>PRC & PTR
                                    numbers</strong></p>
                        </div>
                    </div>
                </div>

                <!-- Professionals Section -->
                <fieldset id="professional-section" class="space-y-4">

                    <!-- Professional Entry Template -->
                    <div
                        class="professional-entry border border-gray-200 rounded-lg bg-white p-5 shadow-sm hover:shadow-md transition relative">

                        <!-- Remove Button (Hidden for first entry) -->
                        <button type="button" onclick="removeProfessional(this)"
                            class="hidden absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold transition">
                            ✕
                        </button>

                        <!-- Professional Type -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Professional Type <span class="text-blue-600">*</span>
                            </label>
                            <select name="prof_type[]"
                                class="prof-type w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Select profession</option>
                                <option>Architect</option>
                                <option>Civil/Structural Engineer</option>
                                <option>Sanitary Engineer</option>
                                <option>Electrical Engineer</option>
                                <option>Mechanical Engineer</option>
                                <option>Geodetic Engineer</option>
                            </select>
                        </div>

                        <!-- Name, PRC, PTR Row -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Full Name <span class="text-blue-600">*</span>
                                </label>
                                <input type="text" name="prof_name[]" placeholder="Full Name"
                                    class="prof-name w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    PRC Number <span class="text-blue-600">*</span>
                                </label>
                                <input type="text" name="prc_no[]" placeholder="0123456"
                                    class="prof-prc w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    PTR Number <span class="text-blue-600">*</span>
                                </label>
                                <input type="text" name="ptr_no[]" placeholder="PTR-2025-001"
                                    class="prof-ptr w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                        </div>

                        <!-- Contact Info Row -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-blue-600">*</span>
                                </label>
                                <input type="email" name="email[]" placeholder="name@email.com"
                                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number <span class="text-blue-600">*</span>
                                </label>
                                <input type="text" name="phone_number[]" placeholder="09171234567"
                                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Birthday <span class="text-blue-600">*</span>
                                </label>
                                <input type="date" name="birthday[]"
                                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Address <span class="text-blue-600">*</span>
                            </label>
                            <input type="text" name="prof_address[]" placeholder="Office or Home Address"
                                class="prof-address w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>
                </fieldset>

                <!-- Add Professional Button -->
                <div class="flex justify-start mt-4">
                    <button type="button" onclick="addProfessional()"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                        <i class="fa-solid fa-user-plus"></i>
                        Add Professional
                    </button>
                </div>
            </div>

            {{-- @include('applicant.forms.obo.oboDOcsForm') --}}

            <!-- Navigation Buttons -->
            <div class="mt-6 flex justify-between">
                <button type="button" class="text-gray-600 hover:underline" @click="previousTab"
                    x-show="currentTab > 0">←
                    Previous</button>

                <div class="ml-auto">
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        @click="nextTab" x-show="currentTab < tabs.length - 1">Next →</button>

                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700"
                        x-show="currentTab === tabs.length - 1">Submit</button>
                </div>
            </div>

            @if (session('success'))
                <script>
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Building Application Submitted!',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    setTimeout(function() {
                        localStorage.clear();
                        sessionStorage.clear();
                        window.location.href = "{{ route('applicant.buildingPermit') }}";
                    }, 2500);
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to submit Building Application. Please try again.",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function() {
                        window.location.href = "{{ route('applicant.buildingPermit') }}";
                    }, 2500);
                </script>
            @endif
        </form>
    </div>

    <div id="professional-section">
    </div>

    <script>
        const oldProfTypes = @json(old('prof_type', []));
        const oldProfNames = @json(old('prof_name', []));
        const oldPrcNos = @json(old('prc_no', []));
        const oldPtrNos = @json(old('ptr_no', []));
        const oldBirthdays = @json(old('birthday', []));
        const oldEmails = @json(old('email', []));
        const oldPhoneNumbers = @json(old('phone_number', []));
        const oldProfAddresses = @json(old('prof_address', []));
        window.oldProvince = "{{ old('province') }}";
        window.oldMunicipality = "{{ old('municipality') }}";
        window.oldBarangay = "{{ old('barangay') }}";

        window.oldProjectProvince = "{{ old('project_province') }}";
        window.oldProjectMunicipality = "{{ old('project_municipality') }}";
        window.oldProjectBarangay = "{{ old('project_barangay') }}";
    </script>
    <script src="{{ asset('asset/js/professional.js') }}"></script>
    <script src="{{ asset('asset/js/location.js') }}"></script>
    <script src="{{ asset('asset/js/buildingFormTabs.js') }}"></script>

    <script>
        function formatCurrency(input) {
            let value = input.value.replace(/,/g, '').replace(/[^\d.]/g, '');
            if (!value) {
                input.value = '';
                return;
            }
            const parts = value.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            input.value = parts.join('.');
        }

        function computeFAR() {
            const floorArea = parseFloat(document.getElementById('floor_area').value.replace(/,/g, '')) || 0;
            const lotArea = parseFloat(document.getElementById('lot_area').value.replace(/,/g, '')) || 0;
            const farField = document.getElementById('floor_area_ratio');

            if (lotArea > 0) {
                const far = (floorArea / lotArea).toFixed(2);
                farField.value = far;


                localStorage.setItem('savedFAR', far);
            } else {
                farField.value = '';
                localStorage.removeItem('savedFAR');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedFAR = localStorage.getItem('savedFAR');
            if (savedFAR) {
                const farField = document.getElementById('floor_area_ratio');
                if (farField) farField.value = savedFAR;
            }

            const floorAreaInput = document.getElementById('floor_area');
            const lotAreaInput = document.getElementById('lot_area');

            if (floorAreaInput) floorAreaInput.addEventListener('input', computeFAR);
            if (lotAreaInput) lotAreaInput.addEventListener('input', computeFAR);
        });
    </script>
    <script>
        document.getElementById('buildingForm').addEventListener('submit', function(e) {
            Swal.fire({
                title: 'Submitting Application...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    </script>

@endsection
