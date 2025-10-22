@extends('layout.applicant.app')

@section('title', 'Sanitary Applications Records')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- Header -->
        <div class="rounded-xl p-6 bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-md mb-6">
            <h2 class="text-2xl font-bold text-blue-700">🏛️ Sanitary Record Dashboard</h2>
            <p class="text-gray-700 text-sm mt-1">
                Review, approve, or request changes on sanitary applications submitted by applicants.
            </p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total -->
            <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Applications</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $applications->count() }}</h3>
                </div>
            </div>

            <!-- Pending / Under Review -->
            <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4">
                <div class="p-3 bg-yellow-100 text-yellow-600 rounded-lg">
                    <i class="fas fa-hourglass-half text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pending Review</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $applications->where('status', 'submitted')->count() }}
                    </h3>
                </div>
            </div>

            <!-- Approved -->
            <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4">
                <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Approved</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $applications->where('status', 'approved')->count() }}
                    </h3>
                </div>
            </div>

            <!-- Disapproved -->
            <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4">
                <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                    <i class="fas fa-times-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Disapproved</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $applications->where('status', 'disapproved')->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Applications Table -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="m-5">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-4 px-6">

                    <div class="w-full sm:w-1/2 mb-2 sm:mb-0">
                        <h1 class="text-xl font-bold text-gray-800">SANITARY RECORDS TABLE</h1>
                    </div>

                    <div class="w-full sm:w-1/2">
                        <div class="relative w-full">
                            <input type="search" id="customSearch" placeholder="🔍 Search applications..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-t border-gray-300 my-4">

            <div class="flex gap-3 mb-4 px-6 flex-wrap">
                <!-- Status Filters -->
                <button class="filter-btn status-btn bg-gray-200 text-gray-800 px-4 py-2 rounded-full font-medium"
                    data-type="status" data-value="all">All</button>
                <button class="filter-btn status-btn bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-medium"
                    data-type="status" data-value="under_review">Under Review</button>
                <button class="filter-btn status-btn bg-green-100 text-green-800 px-4 py-2 rounded-full font-medium"
                    data-type="status" data-value="approved">Approved</button>
                <button class="filter-btn status-btn bg-red-100 text-red-800 px-4 py-2 rounded-full font-medium"
                    data-type="status" data-value="disapproved">Disapproved</button>
                <button class="filter-btn status-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-medium"
                    data-type="status" data-value="resubmit">Resubmit</button>

                <!-- Date Filters -->
                <button class="filter-btn date-btn bg-gray-200 text-gray-800 px-4 py-2 rounded-full font-medium"
                    data-type="date" data-value="all">All Dates</button>
                <button class="filter-btn date-btn bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-medium"
                    data-type="date" data-value="today">Today</button>
                <button class="filter-btn date-btn bg-green-100 text-green-800 px-4 py-2 rounded-full font-medium"
                    data-type="date" data-value="last_week">Last Week</button>
                <button class="filter-btn date-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-medium"
                    data-type="date" data-value="last_month">Last Month</button>
            </div>



            <div class="overflow-x-auto p-10">
                <table id="example" class="w-full text-sm border-t border-gray-200">
                    <thead class="bg-blue-50 text-blue-700 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-center">Application ID</th>
                            <th class="px-6 py-3 text-center">Applicant Name</th>
                            <th class="px-6 py-3 text-center">Date Submitted</th>
                            <th class="px-6 py-3 text-center">Approve By</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($applications as $application)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-left font-semibold text-gray-800">
                                    {{ $application->application_no }}
                                </td>
                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ ucwords($application->user->first_name ?? 'N/A') }}
                                    {{ ucwords($application->user->middle_name ?? 'N/A') }}
                                    {{ ucwords($application->user->last_name ?? 'N/A') }}
                                </td>
                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ $application->created_at->format('M d, Y') }}
                                </td>
                                @if ($application->status == 'approved')
                                    <td class="px-6 py-4 text-left text-gray-800">
                                        {{ $application->approver->first_name }}
                                    </td>
                                @else
                                    <td class="px-6 py-4 text-left text-gray-800">
                                        --
                                    </td>
                                @endif
                                <td class="px-6 py-4 text-left">
                                    @php
                                        $statusColors = [
                                            'submitted' => 'bg-yellow-100 text-yellow-700',
                                            'under_review' => 'bg-blue-100 text-blue-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'disapproved' => 'bg-red-100 text-red-700',
                                            'resubmit' => 'bg-gray-200 text-gray-700',
                                        ];

                                        $stageLabels = [
                                            'submitted' => 'Submitted',
                                            'under_review' => 'Under Review',
                                            'approved' => 'Approved',
                                            'disapproved' => 'Disapproved',
                                            'resubmit' => 'Resubmit',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$application->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $stageLabels[$application->status] ?? ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-left space-x-2 flex items-center">

                                    <!-- View -->
                                    <a href="{{ route('sanitary_officer.sanitary.sanitary_view_record', $application->id) }}"
                                        class="relative inline-block text-blue-600 hover:text-blue-800 text-sm font-medium"
                                        x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">

                                        <span class="p-2 bg-blue-100 rounded-md hover:bg-blue-200 transition">
                                            <i class="fas fa-eye"></i>
                                        </span>

                                        <div x-show="open" x-transition
                                            class="absolute left-1/2 -translate-x-1/2 mt-2 px-3 py-2 text-sm font-medium text-white bg-blue-900 rounded-lg shadow-lg z-50"
                                            style="display: none;">
                                            View
                                        </div>
                                    </a>


                                    @if ($application->status === 'under_review')
                                        <!-- Approve -->
                                        <form action="{{ route('sanitary_officer.sanitary.approve', $application->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="button" data-tooltip-target="tooltip-approved"
                                                @click="$dispatch('open-remarks-modal', { id: '{{ $application->id }}', title: 'Approved', par: 'approve'})"
                                                class="p-2 bg-green-100 rounded-md hover:bg-green-200 transition text-green-600">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                            <div id="tooltip-approved" role="tooltip"
                                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-green-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                Approved
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </form>

                                        <!-- Disapprove -->
                                        <form
                                            action="{{ route('sanitary_officer.sanitary.disapprove', $application->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="button"
                                                data-tooltip-target="tooltip-disapproved"data-tooltip-placement="bottom"
                                                @click="$dispatch('open-remarks-modal', { id: '{{ $application->id }}', title: 'Disapproved', par: 'disapprove'})"
                                                class="p-2 bg-red-100 rounded-md hover:bg-red-200 transition text-red-600">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                            <div id="tooltip-disapproved" role="tooltip-1"
                                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-red-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                Disapproved
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </form>

                                        <!-- Request Resubmission -->
                                        <form action="{{ route('sanitary_officer.sanitary.resubmit', $application->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="button" data-tooltip-target="tooltip-resubmit"
                                                @click="$dispatch('open-remarks-modal', { id: '{{ $application->id }}', title: 'Resubmit', par:'resubmit'})"
                                                class="p-2 bg-yellow-100 rounded-md hover:bg-yellow-200 transition text-yellow-600">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <div id="tooltip-resubmit" role="tooltip-1"
                                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-yellow-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                                Resubmit
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Account Created!",
                showConfirmButton: false,
                timer: 2500
            });
            setTimeout(function() {

            }, 2500);
        </script>
    @endif
    <!-- Modal -->
    <div x-data="{ open: false, appId: null, appTitle: '', appPar: '' }"
        x-on:open-remarks-modal.window="
        open = true; 
        appId = $event.detail.id; 
        appTitle = $event.detail.title
        appPar = $event.detail.par
    "
        x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-transparent bg-opacity-30 backdrop-blur-sm">
        <div @click.away="open = false" class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-4">
                Add Remarks for <span x-text="appTitle"></span>
            </h2>

            <form :action="`/sanitary_officer/sanitary/${appId}/${appPar}`" method="POST">
                @csrf
                <textarea name="remarks" rows="4" required
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-500"></textarea>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Status Update",
                showConfirmButton: false,
                timer: 2500
            });
            setTimeout(function() {

            }, 2500);
        </script>
    @endif

    <script src="{{ asset('asset/js/sanitaryRecordFilter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
