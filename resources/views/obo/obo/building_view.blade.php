@extends('layout.applicant.app')

@section('title', 'View Building Application')

@section('content')
    <div class="max-w-10xl bg-gray-50 rounded-xl mx-auto px-6 py-8">

        <div
            class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-blue-50 via-cyan-50 to-blue-100 shadow-lg mb-6 p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6 border border-blue-200">

            <!-- Left Section -->
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-14 h-14 flex items-center justify-center bg-white/80 backdrop-blur-sm rounded-full shadow-md border border-blue-200">
                        <i class="fas fa-building text-blue-600 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-blue-900 tracking-tight">
                        Building Application Details
                    </h2>
                </div>
                <p class="text-gray-700 text-sm md:text-base max-w-xl leading-relaxed">
                    Review all submitted information, supporting documents, and monitor the current status of your building
                    permit application.
                </p>
            </div>

            <!-- Right Decorative Illustration -->
            <div class="hidden md:block relative">
                <img src="{{ asset('asset/img/architecture-and-city.png') }}" alt="Building Illustration"
                    class="w-32 opacity-90 drop-shadow-md hover:scale-105 transition-transform duration-300">
            </div>

            <!-- Decorative Overlays -->
            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-blue-100/40 pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-300/20 rounded-full blur-3xl"></div>
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-cyan-200/30 rounded-full blur-3xl"></div>
        </div>

        <!-- Application Info Card -->
        <div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-blue-100">
            <div class="flex justify-between items-center border-b border-blue-200 pb-4 mb-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-file-alt text-blue-600 text-lg"></i>
                    <h3 class="text-xl font-semibold text-gray-800">Application Info</h3>
                </div>

                <a href="{{ route('obo.buildingApplicationRecord') }}"
                    class="flex items-center gap-1 px-4 py-2 bg-blue-50 hover:bg-blue-100 rounded-md text-blue-700 text-sm font-medium transition">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
            </div>

            <!-- Application Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="flex items-center gap-3 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-200">
                    <i class="fas fa-hashtag text-blue-600 text-lg"></i>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Application No</p>
                        <p class="font-semibold text-gray-900">{{ $application->application_no }}</p>
                    </div>
                </div>

                <div
                    class="flex items-center gap-3 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-200">
                    <i class="fas fa-calendar-alt text-blue-600 text-lg"></i>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Submitted On</p>
                        <p class="font-semibold text-gray-900">{{ $application->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div
                    class="flex items-center gap-3 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-200">
                    <i class="fa fa-file-text text-blue-600 text-lg"></i>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Status</p>
                        <span
                            class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-200 text-blue-800">
                            {{ $application->status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Status Tracker -->
            <div class="mt-6 bg-white shadow-sm rounded-xl p-6 border border-blue-100">
                <h4 class="text-sm font-semibold text-gray-700 mb-4">Application Progress</h4>

                @php
                    // Normalize status to lowercase
                    $status = strtolower($application->status);

                    $stageLabels = [
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'disapproved' => 'Disapproved',
                        'payment' => 'Payment',
                        'approved' => 'Approved',
                    ];

                    $stageIcons = [
                        'submitted' => 'fas fa-upload',
                        'under_review' => 'fas fa-search',
                        'approved' => 'fas fa-check-circle',
                        'disapproved' => 'fas fa-times-circle',
                        'payment' => 'fas fa-credit-card',
                    ];

                    switch ($status) {
                        case 'approved':
                            $stages = ['submitted', 'under_review', 'payment', 'approved'];
                            break;
                        case 'disapproved':
                            $stages = ['submitted', 'under_review', 'disapproved'];
                            break;
                        case 'payment':
                            $stages = ['submitted', 'under_review', 'payment', 'disapproved', 'approved'];
                            break;
                        default:
                            // submitted / under_review
                            $stages = ['submitted', 'under_review', 'payment', 'disapproved', 'approved'];
                            break;
                    }
                @endphp

                <div class="flex justify-between items-center relative">
                    @foreach ($stages as $index => $stage)
                        @php
                            $colorClass = 'bg-gray-300 text-gray-600';
                            $lineColor = 'bg-gray-300';

                            if ($status === 'approved') {
                                if (in_array($stage, ['submitted', 'under_review', 'payment','approved'])) {
                                    $colorClass = 'bg-emerald-600 text-white';
                                }
                            }

                            if ($status === 'disapproved') {
                                if (in_array($stage, ['submitted', 'under_review'])) {
                                    $colorClass = 'bg-emerald-600 text-white';
                                }
                                if ($stage === 'disapproved') {
                                    $colorClass = 'bg-orange-600 text-white';
                                }
                            }

                            if ($status === 'payment') {
                                if (in_array($stage, ['submitted', 'under_review'])) {
                                    $colorClass = 'bg-emerald-600 text-white';
                                }
                                if ($stage === 'payment') {
                                    $colorClass = 'bg-amber-600 text-white';
                                }
                            }

                            if ($status === 'submitted') {
                                if ($stage === 'submitted') {
                                    $colorClass = 'bg-blue-600 text-white';
                                }
                            }

                            if ($status === 'under_review') {
                                if (in_array($stage, ['submitted', 'under_review'])) {
                                    $colorClass = 'bg-emerald-600 text-white';
                                }
                                if ($stage === 'under_review') {
                                    $colorClass = 'bg-cyan-600 text-white';
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
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center {{ $colorClass }} shadow-md">
                                <i class="{{ $stageIcons[$stage] }}"></i>
                            </div>
                            <span class="text-xs mt-2 text-center capitalize font-medium text-gray-700">
                                {{ $stageLabels[$stage] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Property Info Card -->
        <div class="bg-white shadow-sm rounded-xl p-6 mb-6 border border-blue-100">
            <!-- Header -->
            <div class="flex items-center gap-2 mb-6">
                <i class="fas fa-home text-blue-600 text-lg"></i>
                <h3 class="text-lg font-semibold text-gray-800">Property Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Property Address -->
                <div
                    class="flex items-start gap-3 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-200">
                    <i class="fas fa-map-marker-alt text-blue-600 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Property Address</p>
                        <p class="font-semibold text-gray-900">{{ $application->property->property_address }}</p>
                    </div>
                </div>

                <!-- Province -->
                <div
                    class="flex items-start gap-3 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-200">
                    <i class="fas fa-flag text-blue-600 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Province</p>
                        <p class="font-semibold text-gray-900">{{ $application->property->province }}</p>
                    </div>
                </div>

                <!-- Municipality/City -->
                <div
                    class="flex items-start gap-3 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-200">
                    <i class="fas fa-city text-blue-600 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Municipality / City</p>
                        <p class="font-semibold text-gray-900">{{ $application->property->municipality }}</p>
                    </div>
                </div>

                <!-- Barangay -->
                <div
                    class="flex items-start gap-3 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-200">
                    <i class="fas fa-map-pin text-blue-600 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Barangay</p>
                        <p class="font-semibold text-gray-900">{{ $application->property->barangay }}</p>
                    </div>
                </div>

                <!-- Occupancy Type -->
                <div
                    class="flex items-start gap-3 bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-200">
                    <i class="fas fa-building text-blue-600 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Occupancy Type</p>
                        <p class="font-semibold text-gray-900">{{ $application->property->occupancy_type }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professionals Card -->
        <div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-blue-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-user-tie text-blue-600"></i>
                Professionals
            </h3>

            @if ($application->professionals && $application->professionals->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-blue-200 rounded-lg divide-y divide-blue-200">
                        <thead class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white uppercase text-sm font-medium">
                            <tr>
                                <th class="px-4 py-3 text-left"><i class="fas fa-id-badge mr-1"></i>Name</th>
                                <th class="px-4 py-3 text-left"><i class="fas fa-briefcase mr-1"></i>Type</th>
                                <th class="px-4 py-3 text-left"><i class="fas fa-file-alt mr-1"></i>PRC No</th>
                                <th class="px-4 py-3 text-left"><i class="fas fa-file-signature mr-1"></i>PTR No</th>
                                <th class="px-4 py-3 text-left"><i class="fas fa-phone mr-1"></i>Phone</th>
                                <th class="px-4 py-3 text-left"><i class="fas fa-envelope mr-1"></i>Email</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-blue-100 text-gray-700 text-sm">
                            @foreach ($application->professionals as $prof)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-4 py-4 font-medium">{{ $prof->prof_name }}</td>
                                    <td class="px-4 py-4">{{ $prof->prof_type }}</td>
                                    <td class="px-4 py-4">{{ $prof->prc_no }}</td>
                                    <td class="px-4 py-4">{{ $prof->ptr_no }}</td>
                                    <td class="px-4 py-4">{{ $prof->phone_number }}</td>
                                    <td class="px-4 py-4">{{ $prof->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600 mt-2">No professionals assigned.</p>
            @endif
        </div>

        <!-- Additional Notes Card -->
        <div x-data="{ open: {{ $application->property->comments ? 'true' : 'false' }} }" class="bg-white shadow-md rounded-xl p-6 mb-6 border border-blue-100">
            <div @click="open = !open" class="flex justify-between items-center cursor-pointer select-none">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-sticky-note text-blue-600"></i> Additional Notes
                </h3>
                <button class="text-gray-500 hover:text-blue-600 transition">
                    <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                </button>
            </div>

            <div x-show="open" x-transition class="mt-4 bg-blue-50 p-4 rounded-lg border border-blue-200">
                @if (!empty($application->property->comments))
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">
                        {{ $application->property->comments }}
                    </p>
                @else
                    <p class="text-gray-500 italic">No comments available.</p>
                @endif
            </div>
        </div>

        <!-- Document Requirements Checklist Card -->
        <!-- Document Requirements Checklist Card -->
        <div class="container mx-auto py-8 px-4">
            <div x-data="documentTracker(@js($application->id))" x-init="loadDocuments()"
                class="bg-white p-6 rounded-xl border border-blue-100 shadow-md">

              
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-clipboard-check text-blue-600"></i>
                            Required Documents - Physical Submission
                        </h3>
                        <p class="text-gray-600 text-sm mt-2">
                            The following documents must be submitted physically to the Office of Building Official
                        </p>
                    </div>
                    <div x-show="allChecked" class="bg-green-600 text-white px-4 py-2 rounded">
                        All Documents Submitted
                    </div>

                </div>

                <!-- Loading State -->
                <div x-show="loading" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-4xl text-blue-600"></i>
                    <p class="mt-2 text-gray-600">Loading documents...</p>
                </div>

                <!-- Success Message -->
                <div x-show="successMessage" x-transition class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-600"></i>
                        <span class="text-green-800" x-text="successMessage"></span>
                    </div>
                </div>

                <!-- Error Message -->
                <div x-show="errorMessage" x-transition class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                        <span class="text-red-800" x-text="errorMessage"></span>
                    </div>
                </div>

                <div x-show="!loading">
                    <!-- Select All Option -->
                    <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200 flex items-center gap-3">
                        <input type="checkbox" @click.prevent="requestConfirm('ALL', !allChecked)" :checked="allChecked"
                            class="w-5 h-5 text-blue-600 rounded cursor-pointer accent-blue-600">

                        <label class="flex-1 cursor-pointer text-sm font-semibold text-gray-800">
                            Select All Documents
                        </label>
                    </div>

                    <!-- I. TECHNICAL DOCUMENTS -->
                    <div class="mb-6">
                        <h4
                            class="text-sm font-bold text-gray-900 bg-blue-100 px-4 py-2 rounded-lg mb-3 uppercase tracking-wide">
                            <i class="fas fa-drafting-compass mr-2 text-blue-600"></i>I. TECHNICAL DOCUMENTS
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <template x-for="doc in technicalDocs" :key="doc.key">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition"
                                    :class="checkedDocs[doc.key] ? 'bg-blue-50 border-blue-300' : ''">
                                    <div class="flex items-center gap-4 flex-1">

                                        <input type="checkbox"
                                            @click.prevent="requestConfirm(doc.key, !checkedDocs[doc.key])"
                                            :checked="checkedDocs[doc.key]"
                                            class="w-5 h-5 text-blue-600 rounded cursor-pointer accent-blue-600 flex-shrink-0">
                                        <h4 class="font-semibold text-gray-900" x-text="doc.label"></h4>
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 flex-shrink-0 ml-2">
                                        <i class="fas fa-circle"></i>
                                    </span>
                                </div>
                            </template>
                        </div>
                    </div>


                    <!-- II. PROOF OF OWNERSHIP -->
                    <div class="mb-6">
                        <h4
                            class="text-sm font-bold text-gray-900 bg-green-100 px-4 py-2 rounded-lg mb-3 uppercase tracking-wide">
                            <i class="fas fa-file-contract mr-2 text-green-600"></i>II. PROOF OF OWNERSHIP
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <template x-for="doc in ownershipDocs" :key="doc.key">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition"
                                    :class="checkedDocs[doc.key] ? 'bg-blue-50 border-blue-300' : ''">
                                    <div class="flex items-center gap-4 flex-1">

                                        <input type="checkbox"
                                            @click.prevent="requestConfirm(doc.key, !checkedDocs[doc.key])"
                                            :checked="checkedDocs[doc.key]"
                                            class="w-5 h-5 text-blue-600 rounded cursor-pointer accent-blue-600 flex-shrink-0">
                                        <h4 class="font-semibold text-gray-900" x-text="doc.label"></h4>
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 flex-shrink-0 ml-2">
                                        <i class="fas fa-circle"></i>
                                    </span>
                                </div>
                            </template>
                        </div>
                    </div>


                    <!-- III. WRITTEN CLEARANCES / CERTIFICATIONS -->
                    <div class="mb-6">
                        <h4
                            class="text-sm font-bold text-gray-900 bg-amber-100 px-4 py-2 rounded-lg mb-3 uppercase tracking-wide">
                            <i class="fas fa-certificate mr-2 text-amber-600"></i>III. WRITTEN CLEARANCES / CERTIFICATIONS
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <template x-for="doc in clearanceDocs" :key="doc.key">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition"
                                    :class="checkedDocs[doc.key] ? 'bg-blue-50 border-blue-300' : ''">
                                    <div class="flex items-center gap-4 flex-1">

                                        <input type="checkbox"
                                            @click.prevent="requestConfirm(doc.key, !checkedDocs[doc.key])"
                                            :checked="checkedDocs[doc.key]"
                                            class="w-5 h-5 text-blue-600 rounded cursor-pointer accent-blue-600 flex-shrink-0">
                                        <h4 class="font-semibold text-gray-900" x-text="doc.label"></h4>
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 flex-shrink-0 ml-2">
                                        <i class="fas fa-circle"></i>
                                    </span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-semibold text-gray-800">Documents Prepared</h5>
                            <span class="text-lg font-bold text-blue-600" x-text="`${checkedCount}/${totalDocs}`"></span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                                :style="`width: ${percentage}%`"></div>
                        </div>
                        <p class="text-sm text-gray-700 mt-2" x-text="`${percentage}% of documents prepared`"></p>
                    </div>

                    <!-- Important Notice -->
                    <div class="mt-6 p-4 bg-amber-50 border border-amber-300 rounded-lg">
                        <div class="flex gap-3">
                            <i class="fas fa-info-circle text-amber-600 flex-shrink-0 mt-0.5"></i>
                            <div>
                                <h5 class="font-semibold text-amber-900">Important Notice</h5>
                                <p class="text-sm text-amber-800 mt-1">
                                    Please bring all required documents in <strong>printed format</strong> to the Office of
                                    Building
                                    Official during your appointment. Documents will be physically verified and checked by
                                    the
                                    authorized OBO officer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONFIRMATION MODAL -->
                <div x-show="showConfirmModal" x-transition x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6" @click.outside="closeModal()">
                        <div class="flex items-center gap-3 mb-4">
                            <i class="fas fa-exclamation-triangle text-amber-500 text-xl"></i>
                            <h3 class="text-lg font-bold text-gray-800">Confirm Physical Submission</h3>
                        </div>
                        <p class="text-sm text-gray-600 mb-6">
                            Are you sure you want to
                            <span class="font-semibold text-blue-600">
                                <span x-text="pendingValue ? 'mark as submitted' : 'unmark'"></span>
                            </span>
                            <span x-show="pendingDocKey === 'ALL'">all documents</span>
                            <span x-show="pendingDocKey !== 'ALL'">this document</span>?
                            <br><br>
                            This confirms physical submission to the <strong>Office of the Building Official</strong>.
                        </p>
                        <div class="flex justify-end gap-3">
                            <button @click="closeModal()" :disabled="submitting"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition disabled:opacity-50">
                                Cancel
                            </button>
                            <button @click="confirmCheck()" :disabled="submitting"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition disabled:opacity-50 flex items-center gap-2">
                                <i class="fas fa-spinner fa-spin" x-show="submitting"></i>
                                <span x-text="submitting ? 'Saving...' : 'Confirm'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
            function documentTracker(applicationId) {
                return {
                    applicationId,
                    loading: true,
                    submitting: false,
                    successMessage: '',
                    errorMessage: '',
                    showConfirmModal: false,
                    pendingDocKey: null,
                    pendingValue: null,
                    checkedDocs: {},

                    technicalDocs: [{
                            key: 'architectural_plans',
                            label: 'Architectural Plans'
                        },
                        {
                            key: 'structural_plans',
                            label: 'Structural Plans'
                        },
                        {
                            key: 'sanitary_plumbing_plans',
                            label: 'Sanitary / Plumbing Plans'
                        },
                        {
                            key: 'electrical_plans',
                            label: 'Electrical Plans'
                        },
                        {
                            key: 'mechanical_plans',
                            label: 'Mechanical Plans'
                        },
                        {
                            key: 'electronics_alarm_cctv_plans',
                            label: 'Electronics / Alarm / CCTV Plans'
                        },
                        {
                            key: 'bill_of_materials_cost_estimates',
                            label: 'Bill of Materials & Cost Estimates'
                        },
                    ],

                    ownershipDocs: [{
                            key: 'deed_of_sale_title',
                            label: 'Deed of Sale / TCT / Title Documents'
                        },
                        {
                            key: 'current_real_property_tax_receipt',
                            label: 'Current Real Property Tax Receipt'
                        },
                        {
                            key: 'lot_site_plan',
                            label: 'Lot / Site Plan'
                        },
                        {
                            key: 'authorization_spa',
                            label: 'Authorization / SPA'
                        },
                    ],

                    clearanceDocs: [{
                            key: 'zoning_clearance',
                            label: 'Zoning Clearance'
                        },
                        {
                            key: 'fire_safety_clearance_bfp',
                            label: 'Fire Safety Clearance (BFP)'
                        },
                        {
                            key: 'environmental_clearance_denr',
                            label: 'Environmental Clearance (DENR)'
                        },
                        {
                            key: 'other_required_clearances',
                            label: 'Other Required Clearances'
                        },
                    ],

                    get allChecked() {
                        return Object.keys(this.checkedDocs).length > 0 &&
                            Object.values(this.checkedDocs).every(v => v);
                    },

                    get checkedCount() {
                        return Object.values(this.checkedDocs).filter(v => v).length;
                    },

                    get totalDocs() {
                        return Object.keys(this.checkedDocs).length;
                    },

                    get percentage() {
                        return this.totalDocs === 0 ? 0 :
                            Math.round((this.checkedCount / this.totalDocs) * 100);
                    },

                    async loadDocuments() {
                        this.loading = true;

                        try {
                            const res = await fetch(`/applications/${this.applicationId}/documents`, {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });

                            const json = await res.json();

                            const allDocs = [
                                ...this.technicalDocs,
                                ...this.ownershipDocs,
                                ...this.clearanceDocs
                            ];

                            allDocs.forEach(d => this.checkedDocs[d.key] = false);

                            if (json.success) {
                                json.data.forEach(d => {
                                    this.checkedDocs[d.document_key] = d.is_submitted;
                                });
                            }
                        } catch {
                            this.showError('Failed to load documents');
                        } finally {
                            this.loading = false;
                        }
                    },

                    requestConfirm(key, value) {
                        this.pendingDocKey = key;
                        this.pendingValue = value;
                        this.showConfirmModal = true;
                    },

                    async confirmCheck() {
                        this.submitting = true;
                        this.clearMessages();

                        const isAll = this.pendingDocKey === 'ALL';

                        const url = isAll ?
                            `/applications/${this.applicationId}/documents/toggle-all` :
                            `/applications/${this.applicationId}/documents/toggle`;

                        const body = isAll ? {
                            is_submitted: this.pendingValue
                        } : {
                            document_key: this.pendingDocKey,
                            is_submitted: this.pendingValue
                        };

                        try {
                            const res = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(body)
                            });

                            const json = await res.json();

                            if (json.success) {
                                if (isAll) {
                                    Object.keys(this.checkedDocs)
                                        .forEach(k => this.checkedDocs[k] = this.pendingValue);
                                } else {
                                    this.checkedDocs[this.pendingDocKey] = this.pendingValue;
                                }

                                this.showSuccess(json.message);
                                this.closeModal();
                            } else {
                                this.showError(json.message);
                            }
                        } catch {
                            this.showError('Failed to update document');
                        } finally {
                            this.submitting = false;
                        }
                    },

                    closeModal() {
                        this.showConfirmModal = false;
                        this.pendingDocKey = null;
                        this.pendingValue = null;
                    },

                    showSuccess(msg) {
                        this.successMessage = msg;
                        setTimeout(() => this.successMessage = '', 3000);
                    },

                    showError(msg) {
                        this.errorMessage = msg;
                        setTimeout(() => this.errorMessage = '', 5000);
                    },

                    clearMessages() {
                        this.successMessage = '';
                        this.errorMessage = '';
                    }
                }
            }
        </script>

        @if (session('success'))
            <script>
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Document Submitted!",
                    showConfirmButton: false,
                    timer: 2500
                });
            </script>
        @endif

        <script src="{{ asset('asset/js/backPageRefresher.js') }}"></script>
    @endsection
