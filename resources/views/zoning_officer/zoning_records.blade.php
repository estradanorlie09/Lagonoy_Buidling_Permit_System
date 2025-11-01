@extends('layout.applicant.app')

@section('title', 'Zoning Applications Management')

@section('content')
    <div class="bg-white max-w-10xl mx-auto px-6 py-8">

        <!-- Header -->
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
                        Zoning Application Details
                    </h2>
                </div>
                <p class="text-gray-700 text-sm md:text-base max-w-xl leading-relaxed">
                    Review all submitted information, supporting documents, and monitor the current status of your zoning
                    permit application.
                </p>
            </div>

            <!-- Right Decorative Illustration -->
            <div class="hidden md:block relative">
                <img src="{{ asset('asset/img/location.png') }}" alt="Building Illustration"
                    class="w-32 opacity-90 drop-shadow-md hover:scale-105 transition-transform duration-300">
            </div>

            <!-- Decorative Overlays -->
            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-red-200/40 pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-red-300/20 rounded-full blur-3xl"></div>
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-rose-200/30 rounded-full blur-3xl"></div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total -->
            <div class="flex items-center gap-4 bg-red-50 rounded-xl p-5 shadow-sm border border-red-100">
                <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Applications</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $applications->count() }}</h3>
                </div>
            </div>

            <!-- Approved -->
            <div class="flex items-center gap-4 bg-green-50 rounded-xl p-5 shadow-sm border border-green-100">
                <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Approved</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $applications->where('status', 'approved')->count() }}
                    </h3>
                </div>
            </div>

            <!-- Disapproved -->
            <div class="flex items-center gap-4 bg-red-50 rounded-xl p-5 shadow-sm border border-red-100">
                <div class="p-3 bg-red-200 text-red-700 rounded-lg">
                    <i class="fas fa-times-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Disapproved</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $applications->where('status', 'disapproved')->count() }}
                    </h3>
                </div>
            </div>

            <!-- Resubmit -->
            <div class="flex items-center gap-4 bg-gray-50 rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="p-3 bg-gray-200 text-gray-500 rounded-lg">
                    <i class="fas fa-redo text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Resubmit</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $applications->where('status', 'resubmit')->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Applications Table -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="m-5">
                <div class="w-full sm:w-1/2 mb-2 sm:mb-0">
                    <div class="w-full sm:w-1/2">
                        <h1 class="text-xl font-semibold text-red-800">Zoning Applications</h1>
                        <p class="text-sm w-90 text-gray-500">Manage zoning building permit applications.</p>
                    </div>
                </div>
            </div>
            <hr class="border-t border-gray-300 my-4">
            <div class="flex flex-col sm:flex-row items-center justify-between px-6 gap-4">

                <!-- Left side: dropdowns -->
                <div class="flex gap-4 flex-wrap items-center w-full sm:w-auto">
                    <!-- Status Dropdown -->
                    <select id="statusFilter"
                        class="filter-select status-select bg-red-100 text-red-800 px-4 py-2 rounded-lg font-medium cursor-pointer focus:outline-none transition">
                        <option data-type="status" data-value="all" value="all">All</option>
                        <option data-type="status" data-value="under_review" value="under_review">Under Review</option>
                        <option data-type="status" data-value="approved" value="approved">Approved</option>
                        <option data-type="status" data-value="disapproved" value="disapproved">Disapproved</option>
                        <option data-type="status" data-value="resubmit" value="resubmit">Resubmit</option>
                    </select>

                    <!-- Date Dropdown -->
                    <select id="dateFilter"
                        class="filter-select date-select bg-red-100 text-red-800 px-4 py-2 rounded-lg font-medium cursor-pointer focus:outline-none transition">
                        <option data-type="date" data-value="all" value="all">All Dates</option>
                        <option data-type="date" data-value="today" value="today">Today</option>
                        <option data-type="date" data-value="last_week" value="last_week">Last Week</option>
                        <option data-type="date" data-value="last_month" value="last_month">Last Month</option>
                    </select>
                </div>

                <!-- Right side: search input -->
                <div class="w-full sm:w-1/2 relative">
                    <input type="search" id="customSearch" placeholder="Search applications..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:ring-2 focus:ring-red-500 focus:outline-none transition" />
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            <div class="overflow-x-auto p-10">
                <table id="example" class="w-full text-sm border-t border-gray-200">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-center w-10 !font-bold">#</th>
                            <th class="px-6 py-3 text-center !font-bold">Application ID</th>
                            <th class="px-6 py-3 text-center !font-bold">Applicant Name</th>
                            <th class="px-6 py-3 text-center !font-bold">Date Submitted</th>
                            <th class="px-6 py-3 text-center !font-bold">Approved By</th>
                            <th class="px-6 py-3 text-center !font-bold">Status</th>
                            <th class="px-6 py-3 text-center !ont-bold">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($applications as $index => $application)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center font-semibold text-gray-800">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-gray-800">
                                    {{ $application->application_no }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600">
                                    {{ ucwords($application->user->first_name ?? 'N/A') }}
                                    {{ ucwords($application->user->middle_name ?? 'N/A') }}
                                    {{ ucwords($application->user->last_name ?? 'N/A') }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600">
                                    {{ $application->created_at->format('M d, Y') }}
                                </td>
                                @if ($application->status == 'approved')
                                    <td class="px-6 py-4 text-center text-gray-800">
                                        {{ $application->approver->first_name }}
                                    </td>
                                @else
                                    <td class="px-6 py-4 text-center text-gray-800">
                                        --
                                    </td>
                                @endif

                                <td class="px-6 py-4 text-center">
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
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center space-x-2">
                                        <!-- View -->
                                        <a href="{{ route('zoning_officer.zoning.zoning_view_record', $application->id) }}"
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
                                            <form action="{{ route('zoning_officer.zoning.approve', $application->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="button"
                                                    @click="$dispatch('open-remarks-modal', { id: '{{ $application->id }}', title: 'Approved', par: 'approve'})"
                                                    class="p-2 bg-green-100 rounded-md hover:bg-green-200 transition text-green-600">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>

                                            <!-- Disapprove -->
                                            <form
                                                action="{{ route('zoning_officer.zoning.disapprove', $application->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="button"
                                                    @click="$dispatch('open-remarks-modal', { id: '{{ $application->id }}', title: 'Disapproved', par: 'disapprove'})"
                                                    class="p-2 bg-red-100 rounded-md hover:bg-red-200 transition text-red-600">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>

                                            <!-- Request Resubmission -->
                                            <form action="{{ route('zoning_officer.zoning.resubmit', $application->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="button"
                                                    @click="$dispatch('open-remarks-modal', { id: '{{ $application->id }}', title: 'Resubmit', par:'resubmit'})"
                                                    class="p-2 bg-yellow-100 rounded-md hover:bg-yellow-200 transition text-yellow-600">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
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

            <form :action="`/zoning_officer/zoning/${appId}/${appPar}`" method="POST">
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

    <script src="{{ asset('asset/js/zoningRecordFilter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
