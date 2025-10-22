@extends('layout.applicant.app')

@section('title', 'View Building Application')

@section('content')
    <div class="max-w-10xl bg-white rounded-xl mx-auto px-6 py-8">

        <div
            class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-red-50 via-rose-100 to-red-200 shadow-lg mb-6 p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6 border border-red-100">

            <!-- Left Section -->
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-14 h-14 flex items-center justify-center bg-white/70 backdrop-blur-sm rounded-full shadow-md border border-red-200">
                        <i class="fas fa-building text-red-600 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-red-800 tracking-tight">
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
            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-red-200/40 pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-red-300/20 rounded-full blur-3xl"></div>
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-rose-200/30 rounded-full blur-3xl"></div>
        </div>


        @if ($application->status == 'approved')
            <a href="{{ route('sanitary.pdf', $application->id) }}"
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
                'resubmit' => 'fas fa-redo',
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
                    <i class="fas fa-file-alt text-red-600 text-lg"></i>
                    <h3 class="text-xl font-semibold text-gray-800">Application Info</h3>
                </div>

                {{-- <a href="{{ route('applicant.buildingPermit') }}"
                    class="flex items-center gap-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md text-gray-700 text-sm font-medium transition">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a> --}}
                <a href="javascript:void(0);" onclick="window.history.back();"
                    class="flex items-center gap-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md text-gray-700 text-sm font-medium transition">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

            </div>


            <!-- Application Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <i class="fas fa-hashtag text-red-500 text-lg"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Application No</p>
                        <p class="font-semibold text-gray-800">{{ $application->application_no }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <i class="fas fa-calendar-alt text-red-500 text-lg"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Submitted On</p>
                        <p class="font-semibold text-gray-800">{{ $application->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <i class="fa fa-file-text text-red-500 text-lg"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Status</p>
                        <p class="font-semibold text-gray-800">{{ $application->status }}</p>
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
                                    $colorClass = 'bg-red-600 text-white';
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
                <i class="fas fa-home text-red-600 text-lg"></i>
                <h3 class="text-lg font-semibold text-gray-800">Property Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Property Address -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <i class="fas fa-map-marker-alt text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Property Address</p>
                        <p class="font-semibold text-gray-800">{{ $application->property->property_address }}</p>
                    </div>
                </div>

                <!-- Province -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <i class="fas fa-flag text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Province</p>
                        <p class="font-semibold text-gray-800">{{ $application->property->province }}</p>
                    </div>
                </div>

                <!-- Municipality/City -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <i class="fas fa-city text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Municipality / City</p>
                        <p class="font-semibold text-gray-800">{{ $application->property->municipality }}</p>
                    </div>
                </div>

                <!-- Barangay -->
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <i class="fas fa-map-pin text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Barangay</p>
                        <p class="font-semibold text-gray-800">{{ $application->property->barangay }}</p>
                    </div>
                </div>

                {{-- Residence TYpe --}}
                <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <i class="fas fa-building text-red-500 text-lg mt-1"></i>
                    <div>
                        <p class="text-gray-500 text-sm">Occupancy Type</p>
                        <p class="font-semibold text-gray-800">{{ $application->property->occupancy_type }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Notes -->
        @if ($application->property->comments)
            <div class="bg-white shadow-md rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🗒️ Additional Notes</h3>
                <p class="text-gray-700">{{ $application->property->comments }}</p>
            </div>
        @endif

        <!-- Documents -->
        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Submitted Documents</h3>
                @if (strtolower($application->status) === 'resubmit')
                    <a href="{{ route('applicant.sanitary.sanitary_application_view.resubmit_doc', $application->id) }}"
                        class="px-5 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg shadow-md text-sm font-medium transition">
                        <i class="fas fa-redo mr-2"></i> Resubmit Documents
                    </a>
                @endif
            </div>

            @php
                $latestDocs = $application->documents
                    ->groupBy('document_type')
                    ->map(fn($docs) => $docs->sortByDesc('version')->first());
            @endphp

            @if ($latestDocs->count() > 0)
                <ul class="space-y-4">
                    @foreach ($latestDocs as $doc)
                        <li>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                class="flex items-center space-x-4 p-4 border border-gray-300 rounded-lg hover:shadow-lg hover:border-blue-500 transition duration-300 ease-in-out">

                                <!-- Document Icon -->
                                <div class="flex-shrink-0">
                                    @if (Str::endsWith($doc->file_path, ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $doc->file_path) }}" alt="{{ $doc->filename }}"
                                            class="h-10 w-10 object-cover rounded">
                                    @elseif(Str::endsWith($doc->file_path, 'pdf'))
                                        <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                                    @elseif(Str::endsWith($doc->file_path, ['doc', 'docx']))
                                        <i class="fas fa-file-word text-blue-600 text-2xl"></i>
                                    @elseif(Str::endsWith($doc->file_path, 'txt'))
                                        <i class="fas fa-file-alt text-gray-600 text-2xl"></i>
                                    @else
                                        <i class="fas fa-file text-gray-500 text-2xl"></i>
                                    @endif
                                </div>

                                <!-- Document Details -->
                                <div class="flex-1">
                                    <span class="block text-lg font-medium text-gray-800">
                                        {{ $doc->filename ?? 'Submitted Document' }}
                                    </span>

                                    @if ($doc->document_type)
                                        <span class="text-sm text-gray-500">
                                            {{ $doc->document_type }} (v{{ $doc->version }})
                                        </span>
                                    @endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No documents submitted.</p>
            @endif
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

@endsection
