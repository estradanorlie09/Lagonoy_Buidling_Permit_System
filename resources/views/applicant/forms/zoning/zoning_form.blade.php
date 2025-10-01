@extends('layout.applicant.app')

@section('title', 'Zoning')

@section('zoning_form')
    <div class="w-full mx-auto mt-10 p-6 bg-white rounded shadow" x-data="formTabs()">
        <form method="POST" action="{{ route('zoning.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-red-600 mb-4">Application for Zoning Permit</h1>
                    <p class="mb-6">Please fill out the form!</p>
                </div>
                <div>
                    <a href="{{ route('applicant.zoning.zoning_page') }}" class="text-red-500 border-b-1">Back</a>
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
                <div class="mb-8 bg-white border border-gray-200 rounded-lg shadow p-6">
                    <h1 class="text-2xl font-bold text-red-600 mb-4">📖 Instructions for Applying for a Zoning Application
                    </h1>

                    <!-- Step 1 -->
                    <div class="mb-5">
                        <h2 class="font-semibold text-lg mb-2">Step 1: Fill Out Applicant and Property Information</h2>
                        <ul class="list-disc list-inside ml-4 text-gray-700 text-sm space-y-1">
                            <li>Enter property details: address, province, municipality/city, barangay, lot area, and tax
                                declaration number.</li>
                            <li>Select the ownership type (Individual, Corporation, etc.).</li>
                        </ul>
                    </div>

                    <!-- Step 2 -->
                    <div class="mb-5">
                        <h2 class="font-semibold text-lg mb-2">Step 2: Upload Required Documents</h2>
                        <p class="text-sm text-gray-700 mb-2">
                            You must attach the following <span class="text-red-500 font-semibold">4 required
                                documents</span>:
                        </p>
                        <ul class="list-disc list-inside ml-4 text-gray-700 text-sm space-y-1">
                            <li>📂 Vicinity Map (signed by Engineer/Architect)</li>
                            <li>📂 Lot Plan (signed by Geodetic Engineer)</li>
                            <li>📂 Proof of Ownership / Tax Declaration</li>
                            <li>📂 Community Tax Certificate (CTC)</li>
                        </ul>
                        <p class="text-sm text-gray-600 mt-2">
                            Optional documents (upload if available): Other supporting documents.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="mb-5">
                        <h2 class="font-semibold text-lg mb-2">Step 3: Review Your Application</h2>
                        <ul class="list-disc list-inside ml-4 text-gray-700 text-sm space-y-1">
                            <li>Check that all information is correct.</li>
                            <li>Ensure uploaded documents are clear and complete.</li>
                            <li>Add remarks in the "Comments" field (maximum of 100 characters).</li>
                        </ul>
                    </div>

                    <!-- Step 4 -->
                    <div class="mb-5">
                        <h2 class="font-semibold text-lg mb-2">Step 4: Submit Application</h2>
                        <ul class="list-disc list-inside ml-4 text-gray-700 text-sm space-y-1">
                            <li>Click <span class="font-semibold">Submit Application</span>.</li>
                            <li>Your status will be set to <span class="text-red-500 font-semibold">Submitted</span>.</li>
                            <li>A tracking number (e.g., <code class="bg-gray-100 px-1 py-0.5 rounded">ZN-XXXXXXXX</code>)
                                will be generated.</li>
                        </ul>
                    </div>

                    <!-- Step 5 -->
                    <div class="mb-5">
                        <h2 class="font-semibold text-lg mb-2">Step 5: Application Review</h2>
                        <p class="text-sm text-gray-700 mb-2">A Zoning Officer will review your documents and mark them as:
                        </p>
                        <ul class="list-disc list-inside ml-4 text-gray-700 text-sm space-y-1">
                            <li>✅ Approved</li>
                            <li>❌ Disapproved (with remarks)</li>
                            <li>🔄 Resubmit required</li>
                        </ul>
                    </div>

                    <!-- Step 6 -->
                    <div class="mb-3">
                        <h2 class="font-semibold text-lg mb-2">Step 6: Decision and Next Steps</h2>
                        <ul class="list-disc list-inside ml-4 text-gray-700 text-sm space-y-1">
                            <li>If approved → proceed with the next step in the permitting process.</li>
                            <li>If disapproved → you may reapply with corrections.</li>
                            <li>If resubmit required → upload missing or corrected documents.</li>
                        </ul>
                    </div>

                    <!-- Tip -->
                    <p class="mt-4 text-sm text-gray-600 italic">
                        ⚡ Tip: Keep your tracking/application number safe — you’ll use it for follow-ups.
                    </p>
                </div>


            </div>

            <!-- Project Details -->
            <div x-show="currentTab === 1" class="space-y-4">
                <div class="mt-5">
                    <h1 class="text-xl font-bold">Ownership</h1>
                </div>
                <div class="w-full">
                    <label for="property_address" class="block text-sm font-medium text-gray-700">
                        Ownership Type <span class="text-red-500">*</span>
                    </label>

                    <select name="ownership_type" id="ownership_type" value="{{ old('ownership_type') }}"
                        class="w-full border border-gray-300 text-sm rounded mt-1 px-3 py-2.5 focus:outline-none focus:ring-1 focus:ring-red-500">

                        <option value="owner" {{ old('ownership_type') == 'owner' ? 'selected' : '' }}>Owner
                        </option>
                        <option value="authorized_representative"
                            {{ old('ownership_type') == 'authorized_representative' ? 'selected' : '' }}>Authorized
                            Representative</option>

                    </select>
                    @error('ownership_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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

                <div class="mt-5">
                    <h1 class="text-xl font-bold">Other Property Information</h1>
                </div>
                <div class="flex gap-5">

                    <div class="w-full">
                        <label for="lot_area" class="block text-sm font-medium text-gray-700">
                            Lot Area <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="lot_area" name="lot_area" placeholder="Lot Area (sq. meters)"
                            value="{{ old('lot_area') }}"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('lot_area')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="w-full">
                        <label for="tax_declaration" class="block text-sm font-medium text-gray-700">
                            OCT/TCT/Tax Declaration No. <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="tax_declaration" name="tax_declaration"
                            value="{{ old('tax_declaration') }}" placeholder="OCT/TCT/Tax Declaration No.:"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('tax_declaration')
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
                            Upload Documents (Vicinity Map (signed by Engineer/Architect))<span
                                class="text-red-500">*</span>
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-2" class="hidden" name="documents[vicinity_map]" multiple
                            onchange="handleFiles(this, 'file-info-2','vicinity_map')" />

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
                            Upload Documents (Lot Plan (signed by Geodetic Engineer))<span class="text-red-500">*</span>

                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-3" class="hidden" name="documents[lot_plan]" multiple
                            onchange="handleFiles(this, 'file-info-3','lot_plan')" />

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
                            Upload Documents (Proof of Ownership / Tax Declaration)<span class="text-red-500">*</span>
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-4" class="hidden" name="documents[proof_of_ownership]"
                            multiple onchange="handleFiles(this, 'file-info-4','proof_of_ownership')" />

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
                            Upload Documents (Community Tax Certificate (CTC))<span class="text-red-500">*</span>
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-5" class="hidden" name="documents[ctc]" multiple
                            onchange="handleFiles(this, 'file-info-5','CTC')" />
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
                            Upload Documents (Authorization Letter (optional))
                        </label>

                        <!-- Hidden file input -->
                        <input type="file" id="documents-6" class="hidden" name="documents[authorization_letter]"
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
                        window.location.href = "{{ route('applicant.zoning.zoning_page') }}";
                    }, 2500);
                </script>
            @endif
            @if (session('error'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to submit Zoning Application. Please try again.",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function() {
                        window.location.href = "{{ route('applicant.zoning.zoning_page') }}";
                    }, 2500);
                </script>
            @endif
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Required documents list
        const requiredDocs = {
            vicinity_map: "Vicinity Map",
            lot_plan: "Lot Plan",
            proof_of_ownership: "Proof of Ownership / Tax Declaration",
            CTC: "Community Tax Certificate (CTC)"
        };

        let uploadedDocs = {};

        function handleFiles(inputElement, containerId, docType) {
            const fileInfo = document.getElementById(containerId);
            fileInfo.innerHTML = ''; // reset display

            const files = inputElement.files;
            if (files.length === 0) {
                fileInfo.textContent = 'No file selected';
                delete uploadedDocs[docType];
                checkDocuments();
                return;
            }

            const file = files[0];
            uploadedDocs[docType] = file.name;

            const fileDiv = document.createElement('div');
            fileDiv.classList.add('flex', 'items-center', 'justify-between', 'w-full', 'gap-3');

            const fileNameSpan = document.createElement('span');
            fileNameSpan.textContent = file.name;
            fileNameSpan.classList.add('truncate', 'max-w-xs');

            const actionDiv = document.createElement('div');
            actionDiv.classList.add('flex', 'items-center', 'gap-3');

            const previewButton = document.createElement('button');
            previewButton.textContent = 'Preview';
            previewButton.className = 'text-blue-500 underline text-sm hover:text-blue-700 focus:outline-none';
            previewButton.type = 'button';
            previewButton.onclick = () => {
                const fileURL = URL.createObjectURL(file);
                window.open(fileURL);
            };

            const removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.className = 'text-red-500 underline text-sm hover:text-red-700 focus:outline-none';
            removeButton.type = 'button';
            removeButton.onclick = () => {
                inputElement.value = '';
                fileInfo.innerHTML = 'No file selected';
                delete uploadedDocs[docType];
                checkDocuments();
            };

            actionDiv.appendChild(previewButton);
            actionDiv.appendChild(removeButton);
            fileDiv.appendChild(fileNameSpan);
            fileDiv.appendChild(actionDiv);
            fileInfo.appendChild(fileDiv);

            checkDocuments();
        }

        function checkDocuments() {
            const messageBox = document.getElementById("docsMessage");
            const missing = Object.keys(requiredDocs).filter(doc => !(doc in uploadedDocs));

            if (missing.length > 0) {
                messageBox.textContent = "⚠️ Missing documents: " + missing.map(m => requiredDocs[m]).join(", ");
                messageBox.className = "text-red-500 text-sm mt-4";
                return false; 
            } else {
                messageBox.textContent = "✅ All required documents are uploaded.";
                messageBox.className = "text-green-600 text-sm mt-4";
                return true; 
            }
        }
    </script>

    <script>
        const oldMunicipality = @json(old('municipality'));
        const oldBarangay = @json(old('barangay'));

        $('#project_province').on('change', function() {
            let province = $(this).val();

            $('#project_municipality').html('<option>Loading...</option>');
            $('#project_barangay').html('<option>Select Barangay</option>');

            $.post('/location/municipalities', {
                province: province,
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#project_municipality').html('<option value="">Select Municipality/City</option>');
                $.each(data, function(key, value) {
                    let optionValue = typeof value === 'object' ? value.name || key : value;
                    let optionText = typeof value === 'object' ? value.name || key : value;

                    $('#project_municipality').append(
                        `<option value="${optionValue}" ${oldMunicipality == optionValue ? 'selected' : ''}>${optionText}</option>`
                    );
                });

                // If we restored municipality, trigger barangay load
                if (oldMunicipality) {
                    $('#project_municipality').trigger('change');
                }
            }).fail(function() {
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
                $('#project_barangay').html('<option value="">Select Barangay</option>');
                $.each(data, function(index, barangay) {
                    let optionValue = typeof barangay === 'object' ? barangay.name || index :
                        barangay;
                    let optionText = typeof barangay === 'object' ? barangay.name || index :
                        barangay;

                    $('#project_barangay').append(
                        `<option value="${optionValue}" ${oldBarangay == optionValue ? 'selected' : ''}>${optionText}</option>`
                    );
                });
                if (oldBarangay) {
                    $('#project_barangay').val(oldBarangay);
                }
            }).fail(function() {
                alert('Failed to load barangays.');
                $('#project_barangay').html('<option>Select Barangay</option>');
            });
        });

        // On page load, if province has old value, trigger change
        if ($('#project_province').val()) {
            $('#project_province').trigger('change');
        }
    </script>


    {{-- for project address
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
                if (oldBarangay) {
                    $('#project_barangay').val(oldBarangay);
                }
            }).fail(function(xhr) {
                alert('Failed to load barangays.');
                $('#project_barangay').html('<option>Select Barangay</option>');
            });
        });
    </script> --}}
    <script>
        function formTabs() {
            return {
                currentTab: JSON.parse(localStorage.getItem('currentTab')) || 0, // load from storage or default 0
                tabs: [{
                        label: 'Instructions'
                    },
                    {
                        label: 'Property Information'
                    },
                    {
                        label: 'Documents'
                    },
                ],
                setTab(index) {
                    this.currentTab = index;
                    this.saveTab();
                },
                nextTab() {
                    if (this.currentTab < this.tabs.length - 1) {
                        this.currentTab++;
                        this.saveTab();
                    }
                },
                previousTab() {
                    if (this.currentTab > 0) {
                        this.currentTab--;
                        this.saveTab();
                    }
                },
                saveTab() {
                    localStorage.setItem('currentTab', JSON.stringify(this.currentTab));
                }
            };
        }
    </script>

@endsection
