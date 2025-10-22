@extends('layout.applicant.app')

@section('title', 'Zoning')

@section('zoning_form')
    <div class="w-full mx-auto mt-10 p-6 bg-white rounded shadow" x-data="formTabs()">
        <form method="POST" action="{{ route('sanitary.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-red-600 mb-4">Application for Sanitary / Plumbing Permit</h1>
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
                        <option value="">-- Select Type of Occupancy --</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                        <option value="industrial">Industrial</option>
                        <option value="institutional">Institutional</option>
                        <option value="agricultural">Agricultural</option>
                        <option value="recreational">Recreational</option>
                        <option value="mixed_use">Mixed Use</option>
                        <option value="others">Others (please specify)</option>
                    </select>
                </div>

                <div class="mt-5">
                    <h1 class="text-xl font-bold">Location of Property (House No.,Street)</h1>
                </div>
                <div class="w-full">
                    <label for="property_address" class="block text-sm font-medium text-gray-700">
                        Propery Full Address <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="property_address" name="property_address" placeholder="Property Full Address "
                        value="{{ old('property_address') }}"
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
                <div class="mt-5">
                    <h1 class="text-xl font-bold">Attached Requirements 📂</h1>
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
                            Sanitary / Plumbing Plans (signed & sealed by Sanitary Engineer / Plumber)<span
                                class="text-red-500">*</span>
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-2" class="hidden" name="documents[plumbing_plans]" multiple
                            onchange="handleFiles(this, 'file-info-2','plumbing_plans')" />

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
                            Plumbing Bill of Materials & Cost Estimates<span class="text-red-500">*</span>

                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-3" class="hidden" name="documents[bill]" multiple
                            onchange="handleFiles(this, 'file-info-3','bill')" />

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
                            Specifications (if separate from plans)<span class="text-red-500">*</span>
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-4" class="hidden" name="documents[specification]" multiple
                            onchange="handleFiles(this, 'file-info-4','specification')" />

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
                            Location / Site Development Plan (showing septic tank, drainage, etc)<span
                                class="text-red-500">*</span>
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-5" class="hidden" name="documents[location]" multiple
                            onchange="handleFiles(this, 'file-info-5','location')" />
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

                <h1 class="text-xl font-bold">Optional Documents</h1>
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
                            Health-Related Certificates (e.g., Food Establishments, Hospitals, Markets)
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-6" class="hidden" name="documents[health_related_cert]"
                            multiple onchange="handleFiles(this, 'file-info-6')" />

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
                            Upload Documents (Other Supporting Documents (optional))
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-7" class="hidden"name="documents[other_doc]" multiple
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
                <div id="docsMessage" class="mt-6 text-sm text-gray-600"></div>

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


            @if (session('success'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Zoning Application Created!",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function() {
                        window.location.href = "{{ route('applicant.sanitary') }}";
                    }, 2500);
                </script>
            @endif
            @if (session('error'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to submit Sanitary Application. Please try again.",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function() {
                        window.location.href = "{{ route('applicant.sanitary') }}";
                    }, 2500);
                </script>
            @endif
        </form>
    </div>

    <script src="{{ asset('asset/js/sanitaryDocumentChecker.js') }}"></script>
    <script src="{{ asset('asset/js/sanitaryFormTabs.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.oldMunicipality = @json(old('municipality'));
        window.oldBarangay = @json(old('barangay'));
    </script>
    <script src="{{ asset('asset/js/location.js') }}"></script>


@endsection
