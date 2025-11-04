<div x-show="currentTab === 3" class="space-y-8">

    <!-- Section Header -->
    <div class="bg-red-50 border border-red-100 rounded-lg p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <i class="fa-solid fa-file-circle-check text-red-600 text-2xl"></i>
            <h1 class="text-2xl font-bold text-red-700">Attached Requirements</h1>
        </div>
        <p class="text-gray-700">
            Please upload all required documents below. Make sure each file is clear, signed, and sealed by licensed
            professionals.
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

                <!-- TECHNICAL DOCUMENTS -->
                <tr class="bg-red-50 font-semibold">
                    <td colspan="4" class="py-2 px-4 text-red-700">I. Technical Documents</td>
                </tr>

                @php
                    $technicalDocs = [
                        ['id' => 2, 'label' => 'Architectural Plans (signed & sealed)', 'name' => 'architecture_plans'],
                        ['id' => 3, 'label' => 'Structural Plans (signed & sealed)', 'name' => 'structure_plans'],
                        [
                            'id' => 4,
                            'label' => 'Sanitary / Plumbing Plans (signed & sealed)',
                            'name' => 'plumbing_plans',
                        ],
                        ['id' => 5, 'label' => 'Electrical Plans (signed & sealed)', 'name' => 'electrical_plans'],
                        ['id' => 6, 'label' => 'Mechanical Plans (signed & sealed)', 'name' => 'mechanical_plans'],
                        [
                            'id' => 7,
                            'label' => 'Electronics / Alarm / CCTV Plans (signed & sealed)',
                            'name' => 'electronics_plans',
                        ],
                        [
                            'id' => 8,
                            'label' => 'Bill of Materials & Cost Estimates (signed & sealed)',
                            'name' => 'estimated_cost',
                        ],
                    ];
                @endphp

                @foreach ($technicalDocs as $doc)
                    <tr>
                        <td class="py-2 px-4 text-gray-600">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 flex items-center gap-2">
                            <i class="fa-solid fa-file-contract text-red-500"></i> {{ $doc['label'] }}
                            <span class="text-red-500">*</span>
                        </td>
                        <td class="py-2 px-4">
                            <input type="file" id="documents-{{ $doc['id'] }}" class="hidden"
                                name="documents[{{ $doc['name'] }}]" multiple
                                onchange="handleFiles(this, 'file-info-{{ $doc['id'] }}','{{ $doc['name'] }}')" />
                            <label for="documents-{{ $doc['id'] }}"
                                class="cursor-pointer inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <i class="fa-solid fa-upload text-red-500"></i> Upload
                            </label>
                        </td>
                        <td class="py-2 px-4 text-gray-600">
                            <div id="file-info-{{ $doc['id'] }}" class="text-xs text-gray-500"></div>
                        </td>
                    </tr>
                @endforeach

                <!-- PROOF OF OWNERSHIP -->
                <tr class="bg-red-50 font-semibold">
                    <td colspan="4" class="py-2 px-4 text-red-700">II. Proof of Ownership</td>
                </tr>

                @php
                    $ownershipDocs = [
                        [
                            'id' => 9,
                            'label' => 'Deed of Sale / Transfer Certificate of Title / Title Documents',
                            'name' => 'dos',
                        ],
                        ['id' => 10, 'label' => 'Current Real Property Tax Receipt', 'name' => 'crptx'],
                        [
                            'id' => 11,
                            'label' => 'Lot / Site Plan (signed & sealed by Geodetic Engineer)',
                            'name' => 'site_plan',
                        ],
                        [
                            'id' => 12,
                            'label' => 'Authorization / SPA (if applicant is not registered owner)',
                            'name' => 'SPA',
                        ],
                    ];
                @endphp

                @foreach ($ownershipDocs as $doc)
                    <tr>
                        <td class="py-2 px-4 text-gray-600">{{ $loop->iteration + 7 }}</td>
                        <td class="py-2 px-4 flex items-center gap-2">
                            <i class="fa-solid fa-file-signature text-red-500"></i> {{ $doc['label'] }}
                            <span class="text-red-500">*</span>
                        </td>
                        <td class="py-2 px-4">
                            <input type="file" id="documents-{{ $doc['id'] }}" class="hidden"
                                name="documents[{{ $doc['name'] }}]" multiple
                                onchange="handleFiles(this, 'file-info-{{ $doc['id'] }}','{{ $doc['name'] }}')" />
                            <label for="documents-{{ $doc['id'] }}"
                                class="cursor-pointer inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <i class="fa-solid fa-upload text-red-500"></i> Upload
                            </label>
                        </td>
                        <td class="py-2 px-4 text-gray-600">
                            <div id="file-info-{{ $doc['id'] }}" class="text-xs text-gray-500"></div>
                        </td>
                    </tr>
                @endforeach

                <!-- WRITTEN CLEARANCES -->
                <tr class="bg-red-50 font-semibold">
                    <td colspan="4" class="py-2 px-4 text-red-700">III. Written Clearances / Certifications</td>
                </tr>

                @php
                    $clearanceDocs = [
                        ['id' => 13, 'label' => 'Zoning Clearance', 'name' => 'zoning_clearance'],
                        ['id' => 14, 'label' => 'Fire Safety Clearance / FSEC (BFP)', 'name' => 'bfp_certificate'],
                        [
                            'id' => 15,
                            'label' => 'Environmental Clearance / DENR (if applicable)',
                            'name' => 'Environmental_clearance',
                        ],
                        ['id' => 16, 'label' => 'Other Clearances (DOH, DPWH, etc.) as required', 'name' => 'optional'],
                    ];
                @endphp

                @foreach ($clearanceDocs as $doc)
                    <tr>
                        <td class="py-2 px-4 text-gray-600">{{ $loop->iteration + 11 }}</td>
                        <td class="py-2 px-4 flex items-center gap-2">
                            <i class="fa-solid fa-file-shield text-red-500"></i> {{ $doc['label'] }}
                            <span class="text-red-500">*</span>
                        </td>
                        <td class="py-2 px-4">
                            <input type="file" id="documents-{{ $doc['id'] }}" class="hidden"
                                name="documents[{{ $doc['name'] }}]" multiple
                                onchange="handleFiles(this, 'file-info-{{ $doc['id'] }}','{{ $doc['name'] }}')" />
                            <label for="documents-{{ $doc['id'] }}"
                                class="cursor-pointer inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <i class="fa-solid fa-upload text-red-500"></i> Upload
                            </label>
                        </td>
                        <td class="py-2 px-4 text-gray-600">
                            <div id="file-info-{{ $doc['id'] }}" class="text-xs text-gray-500"></div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="docsMessage" class="mt-6 text-sm text-gray-600"></div>
</div>

<script src="{{ asset('asset/js/buildingDocumentChecker.js') }}"></script>
