    @extends('layout.applicant.app')

    @section('title', 'View Building Application')

    @section('content')
        <div class="max-w-10xl bg-white rounded-xl mx-auto px-6 py-8">

            <div
                class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 shadow-lg mb-6 p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6 border border-blue-100">

                <!-- Left Section -->
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-3">
                        <div
                            class="w-14 h-14 flex items-center justify-center bg-white/70 backdrop-blur-sm rounded-full shadow-md border border-blue-200">
                            <i class="fas fa-building text-blue-600 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-blue-800 tracking-tight">
                            Building Application Details
                        </h2>
                    </div>
                    <p class="text-gray-700 text-sm md:text-base max-w-xl leading-relaxed">
                        Review all submitted information, supporting documents, and monitor the current status of your
                        building
                        permit application.
                    </p>
                </div>

                <!-- Right Decorative Illustration -->
                <div class="hidden md:block relative">
                    <img src="{{ asset('asset/img/architecture-and-city.png') }}" alt="Building Illustration"
                        class="w-32 opacity-90 drop-shadow-md hover:scale-105 transition-transform duration-300">
                </div>

                <!-- Decorative Overlays -->
                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-blue-200/40 pointer-events-none"></div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-300/20 rounded-full blur-3xl"></div>
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-rose-200/30 rounded-full blur-3xl"></div>
            </div>


            @if ($application->status == 'approved')
                <a href="{{ route('building.pdf', $application->id) }}"
                    class="flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg shadow hover:bg-green-700 transition duration-200 mb-5">
                    <!-- Download Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    Download Certificate
                </a>
            @endif

            @php
                // Normalize status to lowercase
                $status = strtolower($application->status);

                $stageLabels = [
                    'submitted' => 'Submitted',
                    'under_review' => 'Under Review',
                    'disapproved' => 'Disapproved',
                    'resubmit' => 'Resubmit',
                    'approved' => 'Approved',
                ];

                $stageIcons = [
                    'submitted' => 'fas fa-upload',
                    'under_review' => 'fas fa-search',
                    'approved' => 'fas fa-check-circle',
                    'disapproved' => 'fas fa-times-circle',
                    'resubmit' => 'fas fa-blueo',
                ];

                switch ($status) {
                    case 'approved':
                        $stages = ['submitted', 'under_review', 'approved'];
                        break;
                    case 'disapproved':
                        $stages = ['submitted', 'under_review', 'disapproved'];
                        break;
                    case 'resubmit':
                        $stages = ['submitted', 'under_review', 'resubmit'];
                        break;
                    default:
                        // submitted / under_review
                        $stages = ['submitted', 'under_review', 'resubmit', 'disapproved', 'approved'];
                        break;
                }
            @endphp

            <!-- Application Info Card -->
            <div class="bg-white shadow-md rounded-xl p-6 mb-6">
                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-file-alt text-blue-600 text-lg"></i>
                        <h3 class="text-xl font-semibold text-gray-800">Application Info</h3>
                    </div>

                    <a href="{{ route('applicant.buildingPermit') }}"
                        class="flex items-center gap-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md text-gray-700 text-sm font-medium transition">
                        <i class="fas fa-arrow-left"></i>
                        Back
                    </a>


                </div>


                <!-- Application Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <i class="fas fa-hashtag text-blue-500 text-lg"></i>
                        <div>
                            <p class="text-gray-500 text-sm">Application No</p>
                            <p class="font-semibold text-gray-800">{{ $application->application_no }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <i class="fas fa-calendar-alt text-blue-500 text-lg"></i>
                        <div>
                            <p class="text-gray-500 text-sm">Submitted On</p>
                            <p class="font-semibold text-gray-800">{{ $application->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <i class="fa fa-file-text text-blue-500 text-lg"></i>
                        <div>
                            <p class="text-gray-500 text-sm">Status</p>
                            <p class="font-semibold text-gray-800">{{ ucwords($application->status) }}</p>
                        </div>
                    </div>

                </div>

                <!-- Status Tracker -->
                <div class="mt-6 bg-white shadow-md rounded-xl p-6">
                    <h4 class="text-sm font-semibold text-gray-600 mb-4">Application Progress</h4>

                    <div class="flex justify-between items-center relative">
                        @foreach ($stages as $index => $stage)
                            @php
                                $colorClass = 'bg-gray-300 text-gray-600';
                                $lineColor = 'bg-gray-300';

                                if ($status === 'approved') {
                                    if (in_array($stage, ['submitted', 'under_review', 'approved'])) {
                                        $colorClass = 'bg-green-600 text-white';
                                    }
                                }

                                if ($status === 'disapproved') {
                                    if (in_array($stage, ['submitted', 'under_review'])) {
                                        $colorClass = 'bg-green-600 text-white';
                                    }
                                    if ($stage === 'disapproved') {
                                        $colorClass = 'bg-blue-600 text-white';
                                    }
                                }

                                if ($status === 'resubmit') {
                                    if (in_array($stage, ['submitted', 'under_review'])) {
                                        $colorClass = 'bg-green-600 text-white';
                                    }
                                    if ($stage === 'resubmit') {
                                        $colorClass = 'bg-yellow-600 text-white';
                                    }
                                }

                                if ($status === 'submitted') {
                                    if ($stage === 'submitted') {
                                        $colorClass = 'bg-gray-600 text-white';
                                    }
                                }

                                if ($status === 'under_review') {
                                    if (in_array($stage, ['submitted', 'under_review'])) {
                                        $colorClass = 'bg-green-600 text-white';
                                    }
                                    if ($stage === 'under_review') {
                                        $colorClass = 'bg-blue-600 text-white';
                                    }
                                }

                                if ($index > 0) {
                                    $lineColor = 'bg-gray-300';
                                }
                            @endphp

                            <!-- Connector Line -->
                            @if ($index > 0)
                                <div class="absolute top-4 left-0 w-full h-1 z-0">
                                    <div class="w-full h-1 {{ $lineColor }}"></div>
                                </div>
                            @endif

                            <!-- Step -->
                            <div class="flex flex-col items-center z-10 flex-1">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $colorClass }}">
                                    <i class="{{ $stageIcons[$stage] }}"></i>
                                </div>
                                <span class="text-xs mt-2 text-center capitalize">
                                    {{ $stageLabels[$stage] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Property Info Card -->
            <div class="bg-white shadow-sm rounded-xl p-6 mb-6 border border-gray-100">
                <!-- Header -->
                <div class="flex items-center gap-2 mb-6">
                    <i class="fas fa-home text-blue-600 text-lg"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Property Information</h3>
                </div>

                <!-- Property Address Section -->
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-blue-700 uppercase tracking-wide mb-3 flex items-center gap-2">
                        <i class="fas fa-map-marked-alt text-blue-500"></i>
                        Address Information
                    </h4>
                    <!-- Property Address -->
                    <div class="flex items-start gap-3 mb-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <i class="fas fa-map-marker-alt text-blue-500 text-lg mt-1"></i>
                        <div>
                            <p class="text-gray-500 text-sm">Property Address</p>
                            <p class="font-semibold text-gray-800">{{ $application->property->property_address }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <!-- Province -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-flag text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">Province</p>
                                <p class="font-semibold text-gray-800">{{ $application->property->province }}</p>
                            </div>
                        </div>

                        <!-- Municipality/City -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-city text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">Municipality / City</p>
                                <p class="font-semibold text-gray-800">{{ $application->property->municipality }}</p>
                            </div>
                        </div>

                        <!-- Barangay -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-map-pin text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">Barangay</p>
                                <p class="font-semibold text-gray-800">{{ $application->property->barangay }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications Section -->
                <div>
                    <h4 class="text-sm font-semibold text-blue-700 uppercase tracking-wide mb-3 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-blue-500"></i>
                        Building Specifications
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <!-- Occupancy Type -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-building text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">Occupancy Type & Classification As</p>
                                <p class="font-semibold text-gray-800">
                                    {{ ucwords($application->property->occupancy_type) }} |
                                    {{ ucwords(str_replace('_', ' ', $application->property->classified_as)) }}

                                </p>
                            </div>
                        </div>

                        <!-- Estimated Cost -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-coins text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">Estimated Cost</p>
                                <p class="font-semibold text-gray-800">
                                    ₱{{ number_format($application->property->estimated_cost, 2) }}
                                </p>
                            </div>
                        </div>

                        <!-- Number of Floors -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-layer-group text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">Number of Floors</p>
                                <p class="font-semibold text-gray-800">{{ $application->property->number_of_floor }}</p>
                            </div>
                        </div>

                        <!-- Lot Area -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-ruler-combined text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">Lot Area</p>
                                <p class="font-semibold text-gray-800">{{ $application->property->lot_area }} m²</p>
                            </div>
                        </div>

                        <!-- Floor Area -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-ruler text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">Floor Area</p>
                                <p class="font-semibold text-gray-800">{{ $application->property->floor_area }} m²</p>
                            </div>
                        </div>

                        <!-- Floor Area Ratio -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-percent text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">Floor Area Ratio (FAR)</p>
                                <p class="font-semibold text-gray-800">{{ $application->property->floor_area_ratio }}</p>
                            </div>
                        </div>

                        <!-- TCT No -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-file-contract text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">TCT No.</p>
                                <p class="font-semibold text-gray-800">{{ $application->property->tct_no }}</p>
                            </div>
                        </div>

                        <!-- FSEC No -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-file-shield text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">FSEC No.</p>
                                <p class="font-semibold text-gray-800">{{ $application->property->fsec_no }}</p>
                            </div>
                        </div>

                        <!-- FSEC Date Issued -->
                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <i class="fas fa-calendar-check text-blue-500 text-lg mt-1"></i>
                            <div>
                                <p class="text-gray-500 text-sm">FSEC Date Issued</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($application->property->fsec_issued_date)->format('F d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="bg-white shadow-md rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-user-tie text-blue-600"></i>
                    Professionals
                </h3>

                @if ($application->professionals && $application->professionals->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-lg divide-y divide-gray-200">
                            <thead class="bg-blue-100 text-blue-700 uppercase text-sm font-medium">
                                <tr>
                                    <th class="px-4 py-3 text-left"><i class="fas fa-id-badge mr-1"></i>Name</th>
                                    <th class="px-4 py-3 text-left"><i class="fas fa-briefcase mr-1"></i>Type</th>
                                    <th class="px-4 py-3 text-left"><i class="fas fa-file-alt mr-1"></i>PRC No</th>
                                    <th class="px-4 py-3 text-left"><i class="fas fa-file-signature mr-1"></i>PTR No</th>
                                    <th class="px-4 py-3 text-left"><i class="fas fa-phone mr-1"></i>Phone</th>
                                    <th class="px-4 py-3 text-left"><i class="fas fa-envelope mr-1"></i>Email</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-gray-700 text-sm">
                                @foreach ($application->professionals as $prof)
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        <td class="px-4 py-4">{{ $prof->prof_name }}</td>
                                        <td class="px-4 py-4">{{ $prof->prof_type }}</td>
                                        <td class="px-4 py-4">{{ $prof->prc_no }}</td>
                                        <td class="px-4 py-4">{{ $prof->ptr_no }}</td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-2">

                                                {{ $prof->phone_number }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-2">

                                                {{ $prof->email }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-700 mt-2">No professionals assigned.</p>
                @endif
            </div>
            <div x-data="{ open: {{ $application->property->scope_of_work ? 'true' : 'false' }} }" class="bg-white shadow-md rounded-xl p-6 mb-6">
                <div @click="open = !open" class="flex justify-between items-center cursor-pointer select-none">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-tools text-blue-500"></i>
                        Scope Of Work
                    </h3>
                    <button class="text-gray-500 hover:text-blue-600 transition">
                        <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                    </button>
                </div>

                <div x-show="open" x-transition class="mt-4">
                    @if (!empty($application->property->scope_of_work))
                        <ul class="list-none space-y-2 text-gray-700">
                            @foreach (explode("\n", $application->property->scope_of_work) as $item)
                                <li class="flex items-start gap-2">

                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 italic">No data available.</p>
                    @endif
                </div>
            </div>


            <div x-data="{ open: {{ $application->property->comments ? 'true' : 'false' }} }" class="bg-white shadow-md rounded-xl p-6 mb-6">
                <div @click="open = !open" class="flex justify-between items-center cursor-pointer select-none">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-sticky-note text-yellow-500"></i>
                        Additional Notes
                    </h3>
                    <button class="text-gray-500 hover:text-blue-600 transition">
                        <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                    </button>
                </div>

                <div x-show="open" x-transition class="mt-4">
                    @if (!empty($application->property->comments))
                        <p class="text-gray-700 whitespace-pre-line">
                            {{ $application->property->comments }}
                        </p>
                    @else
                        <p class="text-gray-500 italic">No comments available.</p>
                    @endif
                </div>
            </div>





            <!-- Documents -->

            <div x-data="{ openResubmit: false, selectedDoc: null }" class="bg-gray-50 p-6 rounded-xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Submitted Documents</h3>
                </div>

                @php
                    $latestDocs = $application->documents
                        ->groupBy('document_type')
                        ->map(fn($docs) => $docs->sortByDesc('version')->first());
                @endphp

                @if ($latestDocs->count() > 0)
                    <div class="overflow-x-auto rounded-sm p-3 border border-gray-200 shadow-sm">
                        <table id="example" class="min-w-full bg-white text-sm">
                            <thead class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wide">
                                <tr>
                                    <th class="px-4 py-3 text-left">#</th>
                                    <th class="px-4 py-3 text-center">File</th>
                                    <th class="px-4 py-3 text-left">Type</th>
                                    <th class="px-4 py-3 text-center">Status</th>
                                    <th class="px-4 py-3 text-left">Remarks</th>
                                    <th class="px-4 py-3 text-left">Reviewed By</th>
                                    <th class="px-4 py-3 text-center">Date</th>
                                    <th class="px-4 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($latestDocs as $index => $doc)
                                    @php
                                        $status = strtolower($doc->status ?? 'pending');
                                        $statusStyles = match ($status) {
                                            'approved' => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-800',
                                                'icon' => 'fas fa-check-circle',
                                            ],
                                            'rejected' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-800',
                                                'icon' => 'fas fa-times-circle',
                                            ],
                                            'resubmit' => [
                                                'bg' => 'bg-yellow-100',
                                                'text' => 'text-yellow-800',
                                                'icon' => 'fas fa-blueo',
                                            ],
                                            'under_review' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-800',
                                                'icon' => 'fas fa-search',
                                            ],
                                            default => [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-700',
                                                'icon' => 'fas fa-hourglass-half',
                                            ],
                                        };

                                        $role = optional($doc->reviewer)->role;
                                        if ($role === 'obo') {
                                            $role = 'Office of Building Official';
                                        }
                                    @endphp

                                    <tr class="hover:bg-gray-50 transition">
                                        <!-- Index -->
                                        <td class="px-4 py-3 text-gray-600 text-center">{{ $loop->iteration }}</td>

                                        <!-- File Icon -->
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                class="text-blue-800 hover:text-gray-600">
                                                <i class="fas fa-file text-blue-500 text-2xl"></i>
                                            </a>
                                        </td>


                                        <!-- Type -->
                                        @php
                                            $documentNames = [
                                                'dos' => 'Deed of Sale',
                                                'tct' => 'Transfer Certificate of Title',
                                                'fsec' => 'Fire Safety Evaluation Clearance',
                                                'bldg_plan' => 'Building Plan',
                                                'bp_form' => 'Building Permit Form',
                                                'zoning' => 'Zoning Clearance',
                                                'crptx' => 'Current Real Property Tax Reciept',
                                                'SPA' => 'Special Power of Attorney'
                                            ];

                                            $docName =
                                                $documentNames[$doc->document_type] ??
                                                ucwords(str_replace('_', ' ', $doc->document_type));
                                        @endphp

                                        <td class="px-4 py-3">
                                            {{ $docName }} (v{{ $doc->version }})
                                        </td>

                                        <!-- Status -->
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center">
                                                <span
                                                    class="flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $statusStyles['bg'] }} {{ $statusStyles['text'] }}">
                                                    <i class="{{ $statusStyles['icon'] }}"></i>
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Remarks -->
                                        <td class="px-4 py-3 text-gray-700">
                                            {{ $doc->remarks ?? '—' }}
                                        </td>

                                        <!-- Reviewer -->
                                        <td class="px-4 py-3 text-gray-700">
                                            @if ($doc->reviewed_by)
                                                {{ optional($doc->reviewer)->first_name }}
                                                {{ optional($doc->reviewer)->last_name }}
                                                @if (optional($doc->reviewer)->profession || $role)
                                                    (@if (optional($doc->reviewer)->profession)
                                                        {{ optional($doc->reviewer)->profession }}
                                                    @endif
                                                    @if ($role)
                                                        {{ optional($doc->reviewer)->profession ? ' / ' : '' }}{{ $role }}
                                                    @endif)
                                                @endif
                                            @else
                                                <span class="text-gray-400">Pending</span>
                                            @endif
                                        </td>

                                        <!-- Date -->
                                        <td class="px-4 py-3 text-center text-gray-600">
                                            {{ $doc->updated_at ? $doc->updated_at->format('M d, Y h:i A') : '—' }}
                                        </td>

                                        <!-- Action -->
                                        <td class="px-4 py-3 text-center">
                                            @if ($status === 'resubmit' || $status === 'rejected')
                                                <button @click="openResubmit = true; selectedDoc = {{ $doc->toJson() }}"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                                                    <i class="fas fa-upload mr-1"></i> Resubmit
                                                </button>
                                            @else
                                                <span class="text-gray-400 text-xs">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center">No documents submitted.</p>
                @endif


                <div x-show="openResubmit" x-transition.opacity.duration.300ms
                    class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-cloak>
                    <div @click.away="openResubmit = false" x-transition.scale.duration.300ms
                        class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md relative border border-gray-100">
                        <!-- Close Button -->
                        <button @click="openResubmit = false"
                            class="absolute top-3 right-3 text-gray-400 hover:text-blue-500 transition" title="Close">
                            <i class="fas fa-times text-lg"></i>
                        </button>

                        <!-- Header -->
                        <h2 class="text-xl font-semibold text-gray-800 mb-5 text-center">
                            <i class="fas fa-file-upload text-blue-600 mr-2"></i>
                            Resubmit Document
                        </h2>

                        <!-- Form -->
                        <template x-if="selectedDoc">
                            <form :action="`/applicant/building_permit/view_application/resubmit/${selectedDoc.id}`"
                                method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf

                                <!-- Document Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">
                                        Document Type
                                    </label>
                                    <p class="text-gray-900 text-base font-semibold capitalize border border-gray-200 rounded-md px-3 py-2 bg-gray-50"
                                        x-text="selectedDoc.document_type"></p>
                                </div>

                                <!-- File Upload -->
                                <div>
                                    <label for="file" class="block text-sm font-medium text-gray-600 mb-1">
                                        Upload New File
                                    </label>
                                    <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition"
                                        requiblue>
                                </div>

                                <!-- Buttons -->
                                <div class="flex justify-end gap-3 mt-5">
                                    <button type="button" @click="openResubmit = false"
                                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </template>
                    </div>
                </div>

            </div>
        </div>
        @if (session('success'))
            <script>
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Document Submitted!",
                    showConfirmButton: false,
                    timer: 2500
                });
                setTimeout(function() {}, 2500);
            </script>
        @endif

        <script src="{{ asset('asset/js/datatable.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    @endsection
