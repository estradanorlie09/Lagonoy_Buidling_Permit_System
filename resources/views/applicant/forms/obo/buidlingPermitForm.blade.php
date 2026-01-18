@extends('layout.applicant.app')

@section('title', 'Building Permit Form')

@section('content')
    <div class="w-full mx-auto p-6 bg-white rounded shadow" x-data="formTabs()">
        <form id="buildingForm" method="POST" action="{{ route('building_application.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="bg-blue-50 border border-blue-100 rounded-sm p-6 shadow-sm mb-8 relative">
                <!-- Back Button (Top Right) -->
                <a href="{{ route('applicant.buildingPermit') }}"
                    class="absolute top-4 right-4 inline-flex items-center gap-2 px-3 py-1.5 bg-white hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-md shadow-sm transition">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <!-- Header Content -->
                <div class="flex items-center gap-3 mb-3">
                    <i class="fa-solid fa-building text-blue-600 text-3xl"></i>
                    <h1 class="text-2xl md:text-3xl font-bold text-blue-600">
                        Application for Building Permit / Clearance
                    </h1>
                </div>

                <p class="text-gray-700 mb-3">
                    Welcome! You are about to begin your application for a
                    <span class="font-semibold">Building Permit</span>.
                    This process ensures that your construction complies with all local building codes and safety
                    regulations.
                </p>

                <p class="text-sm text-gray-500 mb-2">
                    Please provide accurate and complete information. Once submitted, your application will be reviewed
                    by the <span class="font-semibold">Office of the Building Official (OBO)</span>.
                </p>

                <div class="flex items-center gap-2 text-sm text-gray-600 mt-4">
                    <i class="fa-regular fa-circle-check text-blue-500"></i>
                    <span>Estimated processing time: 3–5 working days</span>
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
                <div class="mb-4 p-4 bg-blue-100 text-red-700 rounded-lg">
                    <strong>Whoops!</strong> Please fix the following:
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- Personal Details -->
            <div x-show="currentTab === 0" class="space-y-4">
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 text-blue-700">
                        Instructions for Submitting Building Permit Application
                    </h2>

                    <p class="mb-4 text-gray-700">
                        The <strong>Building Permit Application</strong> ensures that all construction, renovation, or
                        alteration
                        projects comply with the requirements of the
                        <em>National Building Code of the Philippines (PD 1096)</em> and related regulations to guarantee
                        safety,
                        structural integrity, and zoning compliance.
                    </p>

                    <h3 class="text-lg font-semibold mb-2">Steps for Submission</h3>
                    <ol class="list-decimal list-inside text-gray-700 space-y-2">
                        <li>
                            <strong>Prepare the Requiblue Documents:</strong>
                            <ul class="list-disc list-inside ml-5">
                                <li>Duly accomplished and notarized Building Permit Application Form</li>
                                <li>Proof of Ownership (e.g., land title, tax declaration, or contract of lease)</li>
                                <li>Barangay Clearance for construction</li>
                                <li>Locational or Zoning Clearance</li>
                                <li>Architectural, Structural, Electrical, Sanitary/Plumbing, and Mechanical Plans
                                    (signed and sealed by licensed professionals)
                                </li>
                                <li>Bill of Materials and Cost Estimates</li>
                                <li>Fire Safety Compliance Certificate (if applicable)</li>
                            </ul>
                        </li>
                        <li>Log in to the system and open your <strong>Building Permit Application</strong> record.</li>
                        <li>Go to the <strong>Building Permit Documents</strong> section.</li>
                        <li>Upload all requiblue files in PDF or image format.</li>
                        <li>Add remarks or additional information if needed (optional).</li>
                        <li>Click <strong>Submit Building Application</strong> to send your documents for evaluation.</li>
                    </ol>

                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-xl p-5 mt-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fa-solid fa-bell text-blue-600 text-lg"></i>
                            <h3 class="text-lg font-semibold text-blue-700">Reminders</h3>
                        </div>

                        <ul class="text-gray-700 space-y-2">
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-pen-ruler text-blue-500 mt-1"></i>
                                <span>All technical plans must be signed and sealed by duly licensed professionals.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-file-circle-check text-blue-500 mt-1"></i>
                                <span>Ensure that documents are complete, clear, and properly labeled before
                                    submission.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-exclamation text-blue-500 mt-1"></i>
                                <span>Incomplete or unsigned submissions may cause processing delays.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-envelope-circle-check text-blue-500 mt-1"></i>
                                <span>You will receive system or email notifications regarding the review status or requiblue
                                    revisions.</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>


            <!-- Project Details -->
            <div x-show="currentTab === 1" class="space-y-6">

                <!-- Section Header -->
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fa-solid fa-clipboard-list text-blue-600 text-2xl"></i>
                        <h1 class="text-2xl font-bold text-blue-700">Project Information</h1>
                    </div>
                    <p class="text-gray-700 text-sm">
                        Please fill out all requiblue project details accurately. Fields marked with
                        <span class="text-blue-500">*</span> are mandatory.
                    </p>
                </div>
                <div class="form-group">
                    <label for="type_of_application" class="text-sm font-medium text-gray-700 mb-2">Type of Application
                        <span style="color:blue">*</span></label><br>
                    <select id="type_of_application" name="type_of_application" 
                        class="w-full border border-gray-300 rounded-md mt-2 p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled {{ old('type_of_application') ? '' : 'selected' }}>Select
                            application type</option>
                        <option value="new" {{ old('type_of_application') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="renewal" {{ old('type_of_application') == 'renewal' ? 'selected' : '' }}>Renewal
                        </option>
                        <option value="amendatory" {{ old('type_of_application') == 'amendatory' ? 'selected' : '' }}>
                            Amendatory</option>
                    </select>
                </div>

                <!-- Type of Occupancy -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type of Occupancy -->
                    <div>
                        <label for="occupancy_type" class="block mb-2 text-sm font-medium text-gray-700">
                            Type of Occupancy <span class="text-blue-500">*</span>
                        </label>
                        <select id="occupancy_type" name="occupancy_type" 
                            class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled {{ old('occupancy_type') ? '' : 'selected' }}>Select Type of
                                Occupancy</option>
                            <option value="residential" {{ old('occupancy_type') == 'residential' ? 'selected' : '' }}>
                                Residential</option>
                            <option value="commercial" {{ old('occupancy_type') == 'commercial' ? 'selected' : '' }}>
                                Commercial</option>
                            <option value="industrial" {{ old('occupancy_type') == 'industrial' ? 'selected' : '' }}>
                                Industrial</option>
                            <option value="institutional" {{ old('occupancy_type') == 'institutional' ? 'selected' : '' }}>
                                Institutional</option>
                            <option value="agricultural" {{ old('occupancy_type') == 'agricultural' ? 'selected' : '' }}>
                                Agricultural</option>
                            <option value="recreational" {{ old('occupancy_type') == 'recreational' ? 'selected' : '' }}>
                                Recreational</option>
                            <option value="mixed_use" {{ old('occupancy_type') == 'mixed_use' ? 'selected' : '' }}>Mixed
                                Use</option>
                        </select>
                        @error('occupancy_type')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Classified As -->
                    <div>
                        <label for="classified_as" class="block mb-2 text-sm font-medium text-gray-700">
                            Classified As <span class="text-blue-500">*</span>
                        </label>
                        <select id="classified_as" name="classified_as" 
                            class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled {{ old('classified_as') ? '' : 'selected' }}>Select
                                Classification</option>
                            <option value="group_a" {{ old('classified_as') == 'group_a' ? 'selected' : '' }}>Group A –
                                Residential Dwellings</option>
                            <option value="group_b" {{ old('classified_as') == 'group_b' ? 'selected' : '' }}>Group B –
                                Residential (Apartments / Dormitories)</option>
                            <option value="group_c" {{ old('classified_as') == 'group_c' ? 'selected' : '' }}>Group C –
                                Educational / Recreational</option>
                            <option value="group_d" {{ old('classified_as') == 'group_d' ? 'selected' : '' }}>Group D –
                                Institutional</option>
                            <option value="group_e" {{ old('classified_as') == 'group_e' ? 'selected' : '' }}>Group E –
                                Business and Mercantile</option>
                            <option value="group_f" {{ old('classified_as') == 'group_f' ? 'selected' : '' }}>Group F –
                                Industrial</option>
                            <option value="group_g" {{ old('classified_as') == 'group_g' ? 'selected' : '' }}>Group G –
                                Storage and Hazardous</option>
                            <option value="group_h" {{ old('classified_as') == 'group_h' ? 'selected' : '' }}>Group H –
                                Assembly (Load &lt; 1000)</option>
                            <option value="group_i" {{ old('classified_as') == 'group_i' ? 'selected' : '' }}>Group I –
                                Assembly (Load ≥ 1000)</option>
                            <option value="group_j" {{ old('classified_as') == 'group_j' ? 'selected' : '' }}>Group J –
                                Accessory Structures</option>
                        </select>
                        @error('classified_as')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>


                <!-- Project Details -->
                <div class="grid md:grid-cols-3 gap-5">
                    <!-- Project Title -->
                    <div>
                        <label for="project_title" class="block text-sm font-medium text-gray-700">
                            Project Title / Description <span class="text-blue-500">*</span>
                        </label>
                        <input type="text" id="project_title" name="project_title"
                            placeholder="e.g., Two-Storey Residential House" value="{{ old('project_title') }}"
                            class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('project_title')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Number of Floors -->
                    <div>
                        <label for="number_of_floor" class="block text-sm font-medium text-gray-700">
                            Number of Floors <span class="text-blue-500">*</span>
                        </label>
                        <input type="number" id="number_of_floor" name="number_of_floor" placeholder="e.g., 2"
                            value="{{ old('number_of_floor') }}"
                            class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('number_of_floor')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estimated Cost -->
                    <div class="relative">
                        <label for="estimated_cost" class="block text-sm font-medium text-gray-700 mb-1">
                            Estimated Cost <span class="text-blue-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-lg">₱</span>
                            <input type="text" id="estimated_cost" name="estimated_cost"
                                placeholder="e.g., 1,200,000" value="{{ old('estimated_cost') }}"
                                oninput="formatCurrency(this)"
                                class="w-full pl-8 pr-3 border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 font-medium">
                        </div>
                        @error('estimated_cost')
                            <p class="text-blue-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Floor Area & Lot Area -->
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label for="floor_area" class="block text-sm font-medium text-gray-700">
                            Total Floor Area (sq.m.) <span class="text-blue-500">*</span>
                        </label>
                        <input type="text" id="floor_area" name="floor_area" placeholder="e.g., 150"
                            value="{{ old('floor_area') }}" oninput="formatCurrency(this); computeFAR();"
                            class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('floor_area')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lot_area" class="block text-sm font-medium text-gray-700">
                            Lot Area (sq.m.) <span class="text-blue-500">*</span>
                        </label>
                        <input type="text" id="lot_area" name="lot_area" placeholder="e.g., 200"
                            value="{{ old('lot_area') }}" oninput="formatCurrency(this); computeFAR();"
                            class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('lot_area')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Floor Area Ratio -->
                <div class="mt-4">
                    <label for="floor_area_ratio" class="block text-sm font-medium text-gray-700">
                        Floor Area Ratio (FAR)
                    </label>
                    <input type="text" id="floor_area_ratio" name="floor_area_ratio" placeholder="Auto-calculated"
                        readonly
                        class="w-full border border-gray-300 rounded-md p-3 bg-gray-100 text-gray-700 mt-1 focus:outline-none">
                    <p class="text-xs text-gray-500 mt-1">Automatically computed as Total Floor Area ÷ Lot Area.</p>
                </div>
                <div>
                    <label for="tct_no" class="block text-sm font-medium text-gray-700">
                        TCT NO. <span class="text-blue-500">*</span>
                    </label>
                    <input type="text" id="tct_no" name="tct_no" placeholder="TCT NO."
                        value="{{ old('tct_no') }}"
                        class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tct_no')
                        <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class=" grid md:grid-cols-2 gap-5">
                    <div>
                        <label for="fsec_no" class="block text-sm font-medium text-gray-700">
                            FSEC NO. <span class="text-blue-500">*</span>
                        </label>
                        <input type="text" id="fsec_no" name="fsec_no" placeholder="FSEC NO."
                            value="{{ old('fsec_no') }}"
                            class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('fsec_no')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="fsec_issued_date" class="block text-sm font-medium text-gray-700">
                            FSEC No. Issued Date <span class="text-blue-500">*</span>
                        </label>
                        <input type="date" id="fsec_issued_date" name="fsec_issued_date"
                            value="{{ old('fsec_issued_date') }}"
                            class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('fsec_issued_date')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-6">
                    <label for="scope_of_work" class="block text-sm font-medium text-gray-700">
                        Scope of Works<span class="text-blue-500">*</span>
                    </label>
                    <textarea name="scope_of_work" id="scope_of_work" rows="5" maxlength="100"
                        placeholder="Describe the specific work to be done"
                        class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('scope_of_work') }}</textarea>
                    @error('scope_of_work')
                        <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>






                <!-- Location Section -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-blue-700 mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-blue-600"></i> Location of Property
                    </h2>
                    <p class="text-sm text-gray-600 mb-4">
                        Provide the complete property address and select the corresponding province, city/municipality, and
                        barangay.
                    </p>

                    <div class="mb-4">
                        <label for="property_address" class="block text-sm font-medium text-gray-700">
                            Property Full Address <span class="text-blue-500">*</span>
                        </label>
                        <input type="text" id="property_address" name="property_address"
                            placeholder="House No., Street, Subdivision" value="{{ old('property_address') }}"
                            class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('property_address')
                            <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-3 gap-5">
                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-700">
                                Province <span class="text-blue-500">*</span>
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
                            <label for="municipality" class="block text-sm font-medium text-gray-700">
                                Municipality / City <span class="text-blue-500">*</span>
                            </label>
                            <select id="project_municipality" name="municipality"
                                class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Municipality / City</option>
                            </select>
                            @error('municipality')
                                <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="barangay" class="block text-sm font-medium text-gray-700">
                                Barangay <span class="text-blue-500">*</span>
                            </label>
                            <select id="project_barangay" name="barangay"
                                class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Barangay</option>
                            </select>
                            @error('barangay')
                                <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div class="mt-6">
                    <label for="comments" class="block text-sm font-medium text-gray-700">
                        Additional Notes
                    </label>
                    <textarea name="comments" id="comments" rows="5" maxlength="100"
                        placeholder="You may include remarks or special considerations (Max 100 characters)."
                        class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('comments') }}</textarea>
                </div>
            </div>

            <div x-show="currentTab === 2" class="space-y-6">

                <!-- Header -->
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fa-solid fa-user-tie text-blue-600 text-2xl"></i>
                        <h1 class="text-2xl font-bold text-blue-700">Project Professionals</h1>
                    </div>
                    <p class="text-gray-700 text-sm">
                        List all licensed professionals involved in your project. Each professional must have a valid
                        <strong>PRC and PTR number</strong> and be duly accblueited for the specific work discipline.
                    </p>
                </div>

                <!-- Professionals Section -->
                <fieldset id="professional-section" class="space-y-4">

                    <!-- Default Professional Entry -->
                    <div
                        class="professional-entry border border-gray-300 rounded-xl bg-gray-50 p-6 shadow-sm relative transition hover:shadow-md">
                        <!-- Remove Button -->
                        <button type="button" onclick="removeProfessional(this)"
                            class="hidden absolute top-2 right-2 text-blue-500 hover:text-blue-700 font-bold text-lg">✖</button>

                        <!-- Professional Type -->
                        <div>
                            <label for="prof_type_1" class="block text-sm font-medium text-gray-700">
                                Professional Type <span class="text-blue-500">*</span>
                            </label>
                            <select id="prof_type_1" name="prof_type[]"
                                class="prof-type w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Select --</option>
                                <option>Architect</option>
                                <option>Civil/Structural Engineer</option>
                                <option>Sanitary Engineer</option>
                                <option>Electrical Engineer</option>
                                <option>Mechanical Engineer</option>
                                <option>Geodetic Engineer</option>
                            </select>
                        </div>

                        <!-- Basic Info -->
                        <div class="grid md:grid-cols-3 gap-5 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Full Name <span
                                        class="text-blue-500">*</span></label>
                                <input type="text" name="prof_name[]" placeholder="Full Name"
                                    class="prof-name w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">PRC Number <span
                                        class="text-blue-500">*</span></label>
                                <input type="text" name="prc_no[]" placeholder="e.g., 0123456"
                                    class="prof-prc w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">PTR Number <span
                                        class="text-blue-500">*</span></label>
                                <input type="text" name="ptr_no[]" placeholder="e.g., PTR-2025-001"
                                    class="prof-ptr w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="grid md:grid-cols-3 gap-5 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Birthday <span
                                        class="text-blue-500">*</span></label>
                                <input type="date" name="birthday[]"
                                    class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email <span
                                        class="text-blue-500">*</span></label>
                                <input type="email" name="email[]" placeholder="e.g., name@email.com"
                                    class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone Number <span
                                        class="text-blue-500">*</span></label>
                                <input type="text" name="phone_number[]" placeholder="e.g., 09171234567"
                                    class="w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Address <span
                                    class="text-blue-500">*</span></label>
                            <input type="text" name="prof_address[]" placeholder="Office or Home Address"
                                class="prof-address w-full border border-gray-300 rounded-md p-3 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </fieldset>

                <!-- Add Professional Button -->
                <div class="flex justify-start">
                    <button type="button" onclick="addProfessional()"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-sm transition">
                        <i class="fa-solid fa-user-plus"></i>
                        Add Another Professional
                    </button>
                </div>
            </div>

            @include('applicant.forms.obo.oboDOcsForm')

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
