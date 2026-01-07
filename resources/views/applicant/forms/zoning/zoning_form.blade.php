@extends('layout.applicant.app')

@section('title', 'Zoning')

@section('zoning_form')
    <div class="w-full mx-auto mt-10 p-6 bg-white rounded shadow" x-data="formTabs()">
        <form id="zoningForm" method="POST" action="{{ route('zoning.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="bg-red-50 border border-red-100 rounded-sm p-6 shadow-sm mb-8 relative">
                <!-- Back Button (Top Right) -->
                <a href="{{ route('applicant.zoning.zoning_page') }}"
                    class="absolute top-4 right-4 inline-flex items-center gap-2 px-3 py-1.5 bg-white hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-md shadow-sm transition">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <!-- Header Content -->
                <div class="flex items-center gap-3 mb-3">
                    <i class="fa-solid fa-map-location-dot text-red-600 text-3xl"></i>
                    <h1 class="text-2xl md:text-3xl font-bold text-red-600">
                        Application for Zoning Clearance / Permit
                    </h1>
                </div>

                <p class="text-gray-700 mb-3">
                    Welcome! You are about to begin your application for a
                    <span class="font-semibold">Zoning Clearance</span>.
                    This process ensures that your property complies with all local zoning regulations and land use
                    requirements.
                </p>

                <p class="text-sm text-gray-500 mb-2">
                    Please provide accurate and complete information. Once submitted, your application will be reviewed
                    by the <span class="font-semibold">Office of the Zoning Administrator (OZA)</span>.
                </p>

                <div class="flex items-center gap-2 text-sm text-gray-600 mt-4">
                    <i class="fa-regular fa-circle-check text-red-500"></i>
                    <span>Estimated processing time: 2–4 working days</span>
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
                    <h2 class="text-xl font-bold mb-4 text-red-700">
                        Instructions for Submitting Zoning Clearance Application
                    </h2>

                    <p class="mb-4 text-gray-700">
                        The <strong>Zoning Clearance</strong> ensures that any proposed construction, renovation, or
                        land-use
                        development conforms to the
                        <em>Comprehensive Land Use Plan (CLUP)</em> and the <em>Zoning Ordinance</em> of the Municipality.
                        This process verifies that the project’s location and intended use are consistent with local zoning
                        regulations before the issuance of a Building Permit.
                    </p>

                    <h3 class="text-lg font-semibold mb-2">Steps for Submission</h3>
                    <ol class="list-decimal list-inside text-gray-700 space-y-2">
                        <li>
                            <strong>Prepare the Required Documents:</strong>
                            <ul class="list-disc list-inside ml-5">
                                <li>Duly accomplished Zoning Clearance Application Form</li>
                                <li>Certified True Copy of Land Title / TCT or Contract of Lease (if not owned)</li>
                                <li>Tax Declaration and latest Real Property Tax Receipt</li>
                                <li>Vicinity Map / Location Plan</li>
                                <li>Lot Plan with bearings and dimensions prepared by a Geodetic Engineer</li>
                                <li>Building Plan or Site Development Plan (if applicable)</li>
                                <li>Barangay Clearance for the proposed project</li>
                                <li>Special Power of Attorney (SPA), if the applicant is not the property owner</li>
                            </ul>
                        </li>
                        <li>Log in to the system and open your <strong>Zoning Clearance Application</strong> record.</li>
                        <li>Go to the <strong>Zoning Documents</strong> section.</li>
                        <li>Upload all required files in PDF or image format.</li>
                        <li>Provide additional remarks or project details if necessary.</li>
                        <li>Click <strong>Submit Zoning Application</strong> to send your documents for review and
                            evaluation.</li>
                    </ol>

                    <div class="bg-red-50 border-l-4 border-red-500 rounded-r-xl p-5 mt-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fa-solid fa-bell text-red-600 text-lg"></i>
                            <h3 class="text-lg font-semibold text-red-700">Reminders</h3>
                        </div>

                        <ul class="text-gray-700 space-y-2">
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-map-location-dot text-red-500 mt-1"></i>
                                <span>Ensure the project location complies with the zoning regulations and designated
                                    land-use area.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-file-circle-check text-red-500 mt-1"></i>
                                <span>All submitted documents must be clear, complete, and properly labeled.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-exclamation text-red-500 mt-1"></i>
                                <span>Incomplete or inaccurate submissions may delay the evaluation process.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-envelope-circle-check text-red-500 mt-1"></i>
                                <span>Applicants will receive system or email notifications regarding the status or any
                                    required corrections.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Project Details -->
            <div x-show="currentTab === 1" class="space-y-8">


                <div>
                    <h1 class="text-2xl font-bold text-red-700 flex items-center gap-2">
                        <i class="fa-solid fa-user-shield text-red-600"></i> Ownership Information
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">Specify who owns the property or if you are applying as an
                        authorized representative.</p>
                </div>

                <div class="w-full">
                    <label for="ownership_type" class="block text-sm font-medium text-gray-700">
                        Ownership Type <span class="text-red-500">*</span>
                    </label>
                    <select name="ownership_type" id="ownership_type" value="{{ old('ownership_type') }}"
                        class="w-full border border-gray-300 text-sm rounded mt-1 px-3 py-2.5 focus:outline-none focus:ring-1 focus:ring-red-500">
                        <option value="owner" {{ old('ownership_type') == 'owner' ? 'selected' : '' }}>Owner</option>
                        <option value="authorized_representative"
                            {{ old('ownership_type') == 'authorized_representative' ? 'selected' : '' }}>
                            Authorized Representative
                        </option>
                    </select>
                    @error('ownership_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <h1 class="text-2xl font-bold text-red-700 flex items-center gap-2 mt-5">
                        <i class="fa-solid fa-map-location-dot text-red-600"></i> Location of Property
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">Provide the full address and location details of the property.</p>
                </div>

                <div class="w-full">
                    <label for="property_address" class="block text-sm font-medium text-gray-700">
                        Property Full Address <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="property_address" name="property_address"
                        placeholder="House No., Street, Barangay" value="{{ old('property_address') }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                    @error('property_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

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


                <div>
                    <h1 class="text-2xl font-bold text-red-700 flex items-center gap-2 mt-5">
                        <i class="fa-solid fa-house-chimney text-red-600"></i> Other Property Information
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">Include key details about the property such as lot area and title
                        number.</p>
                </div>

                <div class="flex gap-5">
                    <div class="w-full">
                        <label for="lot_area" class="block text-sm font-medium text-gray-700">
                            Lot Area (sq. meters) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="lot_area" name="lot_area" placeholder="e.g., 250"
                            value="{{ old('lot_area') }}"
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('lot_area')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full"> <label for="tax_declaration" class="block text-sm font-medium text-gray-700">
                            OCT/TCT/Tax Declaration No. <span class="text-red-500">*</span> </label> <input type="text"
                            id="tax_declaration" name="tax_declaration" value="{{ old('tax_declaration') }}"
                            placeholder="OCT/TCT/Tax Declaration No."
                            class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('tax_declaration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                </div>


                <div class="mt-5">
                    <h1 class="text-xl font-bold text-red-700 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-red-600"></i> Additional Notes
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">You may add remarks or clarifications related to the property.
                    </p>
                </div>

                <div class="w-full">
                    <textarea name="comments" id="comments" cols="30" rows="4" maxlength="100"
                        class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500"
                        placeholder="Additional Notes (Maximum of 100 Characters)">{{ old('comments') }}</textarea>
                </div>
            </div>


            <div x-show="currentTab === 2" class="space-y-8">
                <!-- Section Header -->
                <div class="bg-red-50 border border-red-100 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fa-solid fa-file-circle-check text-red-600 text-2xl"></i>
                        <h1 class="text-2xl font-bold text-red-700">Attached Requirements</h1>
                    </div>
                    <p class="text-gray-700">
                        Please upload all required documents below. Make sure each file is clear, signed, and sealed by the
                        licensed professional.
                        Accepted formats: <strong>PDF, JPG, PNG</strong> (max 5MB each).
                    </p>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm">
                        <thead class="bg-red-100 text-red-700">
                            <tr>
                                <th class="py-3 px-4 text-left w-1/12">#</th>
                                <th class="py-3 px-4 text-left">Document Type</th>
                                <th class="py-3 px-4 text-left">Upload File</th>
                                <th class="py-3 px-4 text-left">Status / Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-2 px-4 text-gray-600">1</td>
                                <td class="py-2 px-4 flex items-center gap-2">
                                    <i class="fa-solid fa-map-location-dot text-red-500"></i>
                                    Vicinity Map (signed by Engineer/Architect)
                                    <span class="text-red-500">*</span>
                                </td>
                                <td class="py-2 px-4">
                                    <input type="file" id="documents-2" class="hidden" name="documents[vicinity_map]"
                                        multiple onchange="handleFiles(this, 'file-info-2','vicinity_map')" />
                                    <label for="documents-2"
                                        class="cursor-pointer inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        <i class="fa-solid fa-upload text-red-500"></i> Upload
                                    </label>
                                </td>
                                <td class="py-2 px-4 text-gray-600">
                                    <div id="file-info-2" class="text-xs text-gray-500"></div>
                                </td>
                            </tr>

                            <tr>
                                <td class="py-2 px-4 text-gray-600">2</td>
                                <td class="py-2 px-4 flex items-center gap-2">
                                    <i class="fa-solid fa-map text-red-500"></i>
                                    Lot Plan (signed by Geodetic Engineer)
                                    <span class="text-red-500">*</span>
                                </td>
                                <td class="py-2 px-4">
                                    <input type="file" id="documents-3" class="hidden" name="documents[lot_plan]"
                                        multiple onchange="handleFiles(this, 'file-info-3','lot_plan')" />
                                    <label for="documents-3"
                                        class="cursor-pointer inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        <i class="fa-solid fa-upload text-red-500"></i> Upload
                                    </label>
                                </td>
                                <td class="py-2 px-4 text-gray-600">
                                    <div id="file-info-3" class="text-xs text-gray-500"></div>
                                </td>
                            </tr>

                            <tr>
                                <td class="py-2 px-4 text-gray-600">3</td>
                                <td class="py-2 px-4 flex items-center gap-2">
                                    <i class="fa-solid fa-file-invoice text-red-500"></i>
                                    Proof of Ownership / Tax Declaration
                                    <span class="text-red-500">*</span>
                                </td>
                                <td class="py-2 px-4">
                                    <input type="file" id="documents-4" class="hidden"
                                        name="documents[proof_of_ownership]" multiple
                                        onchange="handleFiles(this, 'file-info-4','proof_of_ownership')" />
                                    <label for="documents-4"
                                        class="cursor-pointer inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        <i class="fa-solid fa-upload text-red-500"></i> Upload
                                    </label>
                                </td>
                                <td class="py-2 px-4 text-gray-600">
                                    <div id="file-info-4" class="text-xs text-gray-500"></div>
                                </td>
                            </tr>

                            <tr>
                                <td class="py-2 px-4 text-gray-600">4</td>
                                <td class="py-2 px-4 flex items-center gap-2">
                                    <i class="fa-solid fa-id-card text-red-500"></i>
                                    Community Tax Certificate (CTC)
                                    <span class="text-red-500">*</span>
                                </td>
                                <td class="py-2 px-4">
                                    <input type="file" id="documents-5" class="hidden" name="documents[ctc]" multiple
                                        onchange="handleFiles(this, 'file-info-5','CTC')" />
                                    <label for="documents-5"
                                        class="cursor-pointer inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        <i class="fa-solid fa-upload text-red-500"></i> Upload
                                    </label>
                                </td>
                                <td class="py-2 px-4 text-gray-600">
                                    <div id="file-info-5" class="text-xs text-gray-500"></div>
                                </td>
                            </tr>

                            <tr>
                                <td class="py-2 px-4 text-gray-600">5</td>
                                <td class="py-2 px-4 flex items-center gap-2">
                                    <i class="fa-solid fa-file-signature text-red-500"></i>
                                    Authorization Letter (optional)
                                </td>
                                <td class="py-2 px-4">
                                    <input type="file" id="documents-6" class="hidden"
                                        name="documents[authorization_letter]" multiple
                                        onchange="handleFiles(this, 'file-info-6','authorization_letter')" />
                                    <label for="documents-6"
                                        class="cursor-pointer inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        <i class="fa-solid fa-upload text-red-500"></i> Upload
                                    </label>
                                </td>
                                <td class="py-2 px-4 text-gray-600">
                                    <div id="file-info-6" class="text-xs text-gray-500"></div>
                                </td>
                            </tr>

                            <tr>
                                <td class="py-2 px-4 text-gray-600">6</td>
                                <td class="py-2 px-4 flex items-center gap-2">
                                    <i class="fa-solid fa-folder-open text-red-500"></i>
                                    Other Supporting Documents (optional)
                                </td>
                                <td class="py-2 px-4">
                                    <input type="file" id="documents-7" class="hidden" name="documents[other_doc]"
                                        multiple onchange="handleFiles(this, 'file-info-7','other_doc')" />
                                    <label for="documents-7"
                                        class="cursor-pointer inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        <i class="fa-solid fa-upload text-red-500"></i> Upload
                                    </label>
                                </td>
                                <td class="py-2 px-4 text-gray-600">
                                    <div id="file-info-7" class="text-xs text-gray-500"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Zoning Application Created!',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
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
    <script>
        window.oldProvince = "{{ old('province') }}";
        window.oldMunicipality = "{{ old('municipality') }}";
        window.oldBarangay = "{{ old('barangay') }}";

        window.oldProjectProvince = "{{ old('project_province') }}";
        window.oldProjectMunicipality = "{{ old('project_municipality') }}";
        window.oldProjectBarangay = "{{ old('project_barangay') }}";

        function formatTaxDeclaration(input) {
            let value = input.value.replace(/\D/g, '');
            if (!value) {
                input.value = '';
                return;
            }
            if (!value.startsWith('05')) {
                value = '05' + value.slice(2);
            }
            value = value.slice(0, 11);
            if (value.length > 2 && value.length <= 6) {
                value = value.slice(0, 2) + '-' + value.slice(2);
            } else if (value.length > 6) {
                value = value.slice(0, 2) + '-' + value.slice(2, 6) + '-' + value.slice(6);
            }

            input.value = value;
        }

        // Usage:
        const taxInput = document.getElementById('tax_declaration');
        taxInput.addEventListener('input', () => formatTaxDeclaration(taxInput));
    </script>
    <script>
        document.getElementById('zoningForm').addEventListener('submit', function(e) {
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
    <script src="{{ asset('asset/js/zoningDocumentChecker.js') }}"></script>
    <script src="{{ asset('asset/js/location.js') }}"></script>
    <script src="{{ asset('asset/js/zoningFormTabs.js') }}"></script>



@endsection
