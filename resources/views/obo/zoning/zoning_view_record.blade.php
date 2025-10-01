@extends('layout.applicant.app')

@section('title', 'View Zoning Applicant Info')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- Header -->
        <div class="rounded-xl p-6 bg-gradient-to-r from-red-100 via-red-200 to-red-300 shadow-md mb-6">
            <h2 class="text-2xl font-bold text-red-700">📄 Zoning Application Information</h2>
            <p class="text-gray-700 text-sm mt-1">Review all information for your submitted application.</p>
        </div>

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
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Application Info</h3>
                <div class="flex justify-start">
                    <a href="{{ route('obo.zoning_records') }}"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-gray-700 text-sm font-medium">
                        ← Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Application No:</p>
                    <p class="font-semibold text-gray-800">{{ $application->application_no }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Submitted On:</p>
                    <p class="font-semibold text-gray-800">{{ $application->created_at->format('M d, Y') }}</p>
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

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        <!-- Applicant Information Card -->
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
            <div class="flex items-center mb-4">
                <i class="fas fa-user-circle text-2xl text-blue-500 mr-3"></i>
                <h3 class="text-lg font-semibold text-gray-800">Applicant Information</h3>
            </div>
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <p class="text-gray-500 text-sm">Full Name</p>
                    <p class="font-semibold text-gray-800">
                        {{ ucfirst($application->user->first_name) }}
                        {{ $application->user->middle_name ? ucfirst($application->user->middle_name) : '' }}
                        {{ ucfirst($application->user->last_name) }}
                        {{ $application->user->suffix ? ', ' . $application->user->suffix : '' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Email</p>
                    <p class="font-semibold text-gray-800">{{ $application->user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Phone</p>
                    <p class="font-semibold text-gray-800">{{ $application->user->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Birth Date</p>
                    <p class="font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($application->user->birth_date)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Gender</p>
                    <p class="font-semibold text-gray-800">{{ ucfirst($application->user->gender) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Address</p>
                    <p class="font-semibold text-gray-800">
                        {{ $application->user->street ? $application->user->street . ', ' : '' }}
                        {{ $application->user->barangay ? $application->user->barangay . ', ' : '' }}
                        {{ $application->user->municipality ? $application->user->municipality . ', ' : '' }}
                        {{ $application->user->province ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Property Information Card -->
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
            <div class="flex items-center mb-4">
                <i class="fas fa-building text-2xl text-green-500 mr-3"></i>
                <h3 class="text-lg font-semibold text-gray-800">Property Information</h3>
            </div>
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <p class="text-gray-500 text-sm">Property Address</p>
                    <p class="font-semibold text-gray-800">{{ $application->property->property_address }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Province</p>
                    <p class="font-semibold text-gray-800">{{ $application->property->province }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Municipality/City</p>
                    <p class="font-semibold text-gray-800">{{ $application->property->municipality }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Barangay</p>
                    <p class="font-semibold text-gray-800">{{ $application->property->barangay }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Lot Area (sq.m)</p>
                    <p class="font-semibold text-gray-800">{{ $application->property->lot_area }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tax Declaration No</p>
                    <p class="font-semibold text-gray-800">{{ $application->property->tax_declaration }}</p>
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
    <div class="bg-white shadow-lg rounded-xl mt-5 p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Submitted Documents</h3>

        </div>

        @php
            // Group documents by version and sort descending
            $docsByVersion = $application->documents->groupBy('version')->sortKeysDesc();
            $latestVersion = $docsByVersion->keys()->first();
        @endphp

        @if ($docsByVersion->count())
            @foreach ($docsByVersion as $version => $docs)
                <div class="mb-6 relative">
                    <!-- Version Badge -->
                    <h4 class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold mb-3">
                        Version {{ $version }}
                    </h4>

                    <!-- Latest Version Ribbon -->
                    @if ($version == $latestVersion)
                        <span
                            class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                            Latest
                        </span>
                    @endif

                    <ul class="space-y-4">
                        @foreach ($docs as $doc)
                            <li>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                    class="flex items-center space-x-4 p-4 border border-gray-300 rounded-lg hover:shadow-lg hover:border-blue-500 transition duration-300 ease-in-out">

                                    <!-- Document Icon with colored background -->
                                    <div
                                        class="flex-shrink-0 p-2 rounded-md
                                @if (Str::endsWith($doc->file_path, ['jpg', 'jpeg', 'png', 'gif'])) bg-yellow-100 text-yellow-600
                                @elseif(Str::endsWith($doc->file_path, 'pdf')) bg-red-100 text-red-600
                                @elseif(Str::endsWith($doc->file_path, ['doc', 'docx'])) bg-blue-100 text-blue-600
                                @elseif(Str::endsWith($doc->file_path, 'txt')) bg-gray-100 text-gray-600
                                @else bg-gray-100 text-gray-500 @endif
                                ">
                                        @if (Str::endsWith($doc->file_path, ['jpg', 'jpeg', 'png', 'gif']))
                                            <i class="fas fa-file-image text-2xl"></i>
                                        @elseif(Str::endsWith($doc->file_path, 'pdf'))
                                            <i class="fas fa-file-pdf text-2xl"></i>
                                        @elseif(Str::endsWith($doc->file_path, ['doc', 'docx']))
                                            <i class="fas fa-file-word text-2xl"></i>
                                        @elseif(Str::endsWith($doc->file_path, 'txt'))
                                            <i class="fas fa-file-alt text-2xl"></i>
                                        @else
                                            <i class="fas fa-file text-2xl"></i>
                                        @endif
                                    </div>

                                    <!-- Document Details -->
                                    <div class="flex-1">
                                        <span class="block text-lg font-medium text-gray-800">
                                            {{ $doc->filename ?? 'Submitted Document' }}
                                        </span>

                                        @if ($doc->document_type)
                                            <span class="text-sm text-gray-500">
                                                {{ $doc->document_type }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No documents submitted.</p>
        @endif



    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection
