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

    <script src="{{ asset('asset/js/zoningDocumentChecker.js') }}"></script>
    <script src="{{ asset('asset/js/location.js') }}"></script>
    <script src="{{ asset('asset/js/zoningFormTabs.js') }}"></script>

@endsection
