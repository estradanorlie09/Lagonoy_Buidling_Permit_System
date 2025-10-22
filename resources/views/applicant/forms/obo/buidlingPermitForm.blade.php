@extends('layout.applicant.app')

@section('title', 'Building Permit Form')

@section('zoning_form')
    <div class="w-full mx-auto mt-10 p-6 bg-white rounded shadow" x-data="formTabs()">
        <form method="POST" action="{{ route('building_application.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-red-600 mb-4">Application for Building Permit / Clearance</h1>
                    <p class="mb-6">Please fill out the form!</p>
                </div>
                <div>
                    <a href="javascript:void(0);" onclick="window.history.back();"
                        class="flex items-center gap-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md text-gray-700 text-sm font-medium transition">
                        <i class="fas fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
            <input type="text" value="submitted" name="status" hidden>
            <!-- Tabs Header -->
            <div class="flex space-x-4 mb-6">
                <template x-for="(tabName, index) in tabs" :key="index">
                    <button type="button" @click="setTab(index)" class="pb-2"
                        :class="currentTab === index ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-600'"
                        x-text="tabName.label">
                    </button>
                </template>
            </div>

            <hr class="mb-5 border border-gray-300">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <strong>Whoops!</strong> Please fix the following:
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tab Content -->
            <!-- Personal Details -->
            <div x-show="currentTab === 0" class="space-y-4">
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Instructions for Submitting Sanitary / Plumbing
                        Clearance</h2>

                    <p class="mb-4 text-gray-700">
                        The <strong>Sanitary/Plumbing Clearance</strong> ensures that your project complies with
                        health and sanitation standards under the <em>National Building Code (PD 1096)</em> and
                        the <em>Plumbing Code of the Philippines</em>.
                    </p>

                    <h3 class="text-lg font-semibold mb-2">📌 Steps to Submit</h3>
                    <ol class="list-decimal list-inside text-gray-700 space-y-2">
                        <li>
                            <strong>Prepare Your Documents:</strong>
                            <ul class="list-disc list-inside ml-5">
                                <li>Sanitary / Plumbing Plans (signed & sealed by Sanitary Engineer / Master Plumber)</li>
                                <li>Plumbing Bill of Materials & Cost Estimates</li>
                                <li>Specifications (if separate from plans)</li>
                                <li>Location / Site Development Plan (showing septic tank, drainage, sewer lines, etc.)</li>
                                <li>Health-Related Certificates (for food, medical, or public establishments, if applicable)
                                </li>
                            </ul>
                        </li>
                        <li>Log in to the system and open your <strong>Building Permit Application</strong>.</li>
                        <li>Go to the <strong>Sanitary Clearance</strong> section and upload the required documents (PDF or
                            image).</li>
                        <li>Add remarks if needed (optional).</li>
                        <li>Click <strong>Submit Sanitary Clearance</strong> to send your application for review.</li>
                    </ol>

                    <h3 class="text-lg font-semibold mt-4 mb-2">✅ Reminders</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        <li>All plans must be signed & sealed by a licensed Sanitary Engineer / Master Plumber.</li>
                        <li>Incomplete or unsigned documents will delay your application.</li>
                        <li>You will be notified in the system or email if your submission is approved or returned with
                            remarks.</li>
                    </ul>
                </div>



            </div>

            <!-- Project Details -->
            <div x-show="currentTab === 1" class="space-y-4">
                <div class="mb-4">
                    <label for="occupancy_type" class="block mb-2 font-medium text-gray-700">
                        Type of Occupancy
                    </label>
                    <select name="occupancy_type" id="occupancy_type"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        <option value="" {{ old('occupancy_type') == '' ? 'selected' : '' }}>-- Select Type of
                            Occupancy --</option>
                        <option value="residential" {{ old('occupancy_type') == 'residential' ? 'selected' : '' }}>
                            Residential</option>
                        <option value="commercial" {{ old('occupancy_type') == 'commercial' ? 'selected' : '' }}>Commercial
                        </option>
                        <option value="industrial" {{ old('occupancy_type') == 'industrial' ? 'selected' : '' }}>Industrial
                        </option>
                        <option value="institutional" {{ old('occupancy_type') == 'institutional' ? 'selected' : '' }}>
                            Institutional</option>
                        <option value="agricultural" {{ old('occupancy_type') == 'agricultural' ? 'selected' : '' }}>
                            Agricultural</option>
                        <option value="recreational" {{ old('occupancy_type') == 'recreational' ? 'selected' : '' }}>
                            Recreational</option>
                        <option value="mixed_use" {{ old('occupancy_type') == 'mixed_use' ? 'selected' : '' }}>Mixed Use
                        </option>

                    </select>

                    @error('occupancy_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-5">
                    <div class="w-full">
                        <label for="project_title" class="block text-sm font-medium text-gray-700">
                            Project Title / Description <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="project_title" name="project_title"
                            placeholder="Project Title / Description" value="{{ old('project_title') }}"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('project_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="number_of_floor" class="block text-sm font-medium text-gray-700">
                            Number of Floors <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="number_of_floor" name="number_of_floor" placeholder=" Number of Floors  "
                            value="{{ old('number_of_floor') }}"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('number_of_floor')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="w-full">
                        <label for="floor_area" class="block text-sm font-medium text-gray-700">
                            Total Floor Area (sq.m.)<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="floor_area" name="floor_area" placeholder="Total Floor Area (sq.m.)"
                            value="{{ old('floor_area') }}"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('floor_area')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="lot_area" class="block text-sm font-medium text-gray-700">
                            Lot Area (sq.m.) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="lot_area" name="lot_area" placeholder="Lot Area (sq.m.)  "
                            value="{{ old('lot_area') }}"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('lot_area')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="estimated_cost" class="block text-sm font-medium text-gray-700">
                            Estimated Cost (PHP) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="estimated_cost" name="estimated_cost"
                            placeholder=" Estimated Cost (PHP)  " value="{{ old('estimated_cost') }}"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('estimated_cost')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-5">
                    <h1 class="text-xl font-bold">Location of Property (House No.,Street)</h1>
                </div>
                <div class="w-full">
                    <label for="property_address" class="block text-sm font-medium text-gray-700">
                        Propery Full Address <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="property_address" name="property_address"
                        placeholder="Property Full Address " value="{{ old('property_address') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">

                </div>
                @error('property_address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div class="flex flex-col md:flex-row md:space-x-4 gap-5 mb-6">
                    <div class="w-full">
                        <label for="province" class="block text-sm font-medium text-gray-700">
                            Province <span class="text-red-500">*</span>
                        </label>
                        <select id="project_province" name="province" value="{{ old('province') }}"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Province</option>
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

                    <div class="w-full">
                        <label for="municipality" class="block text-sm font-medium text-gray-700">
                            Municipality <span class="text-red-500">*</span>
                        </label>
                        <select id="project_municipality" name="municipality"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Municipality/City</option>
                        </select>
                        @error('municipality')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="barangay" class="block text-sm font-medium text-gray-700">
                            Barangay <span class="text-red-500">*</span>
                        </label>
                        <select id="project_barangay" name="barangay"
                            class="w-full border border-gray-300 rounded mt-2 px-3 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Barangay</option>
                        </select>
                        @error('barangay')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="w-full">
                    <label for="comments" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                    <textarea name="comments" id="comments" cols="30" rows="10"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500"
                        placeholder="Additional Notes (Maximum of 100 Characters)">{{ old('comments') }}</textarea>
                </div>

            </div>
            <div x-show="currentTab === 2" class="space-y-4">
                <h1 class="font-bold text-gray-500">Project Professionals</h1>
                <fieldset id="professional-section">
                    <!-- Default professional field -->
                    <div class="professional-entry border border-gray-300 rounded-lg p-4 relative mt-3 bg-gray-50">
                        <button type="button" onclick="removeProfessional(this)"
                            class="hidden absolute top-2 right-2 text-red-500 font-bold">✖</button>

                        <div class="w-full">
                            <label for="prof_type_1" class="block text-sm font-medium text-gray-700">
                                Professional Type <span class="text-red-500">*</span>
                            </label>
                            <select id="prof_type_1" name="prof_type[]"
                                class="prof-type w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                                <option value="">-- Select --</option>
                                <option>Architect</option>
                                <option>Civil/Structural Engineer</option>
                                <option>Sanitary Engineer</option>
                                <option>Electrical Engineer</option>
                                <option>Mechanical Engineer</option>
                                <option>Geodetic Engineer</option>
                            </select>


                        </div>

                        <div class="flex gap-5 mt-2">
                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700">Full Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="prof_name[]" placeholder="Full Name"
                                    class="prof-name w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            </div>

                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700">PRC Number <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="prc_no[]" placeholder="PRC Number"
                                    class="prof-prc w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            </div>

                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700">PTR Number <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="ptr_no[]" placeholder="PTR Number"
                                    class="prof-ptr w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            </div>
                        </div>

                        <div class="flex gap-5 mt-2">
                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700">Birthday <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="birthday[]"
                                    class="prof-name w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email[]" placeholder="Email"
                                    class="prof-ptr w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700">Phone Number <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="phone_number[]" placeholder="Phone Number"
                                    class="prof-prc w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                            </div>

                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-sm font-medium text-gray-700">Address <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="prof_address[]" placeholder="Address"
                                class="prof-address w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        </div>
                    </div>
                </fieldset>

                <button type="button" onclick="addProfessional()"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-3">+ Add Another Professional</button>
            </div>
            @include('applicant.forms.obo.oboDOcsForm')

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

            @if (session('success'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Building Application Created!",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function() {
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
    </script>
    <script src="{{ asset('asset/js/professional.js') }}"></script>
    <script src="{{ asset('asset/js/location.js') }}"></script>
    <script src="{{ asset('asset/js/buildingFormTabs.js') }}"></script>

@endsection
