@extends('layout.applicant.app')

@section('title', 'Building Application Records')

@section('content')
    <div class="bg-white max-w-10xl mx-auto px-6 py-8">

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
                        Building Application Records 
                    </h2>
                </div>
                <p class="text-gray-700 text-sm md:text-base max-w-xl leading-relaxed">
                    Review all submitted information, supporting documents from applicants.
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

            {{-- <!-- Under Review -->
                <div class="bg-white rounded-xl shadow-md border-t-2 border-red-300 p-7 flex items-center gap-4">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Under Review</p>
                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $applications->where('status', 'under_review')->count() }}</h3>
                    </div>
                </div> --}}

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
                        <h1 class="text-xl font-semibold text-red-800">Building Applications</h1>
                        <p class="text-sm w-90 text-gray-500">Manage applicant building permit applications.</p>
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


            <div class="bg-gray-50 p-4 sm:p-6 overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700" id="example">
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
                            <tr class="hover:bg-blue-50 transition-all duration-200">
                                <!-- Row Number -->
                                <td class="px-6 py-4 text-center font-semibold text-gray-800">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Application ID -->
                                <td class="px-6 py-4 text-center font-semibold text-gray-800">
                                    <div class="flex items-center justify-center gap-2">
                                        <i class="fas fa-file-alt text-red-600 bg-blue-100 p-1.5 rounded-md"></i>
                                        <span class="text-gray-800">{{ $application->application_no }}</span>
                                    </div>
                                </td>

                                <!-- \Name ID -->
                                <td class="px-6 py-4 text-center font-semibold text-gray-800">
                                    <div class="flex items-center justify-center gap-2">
                                        <i class="fas fa-user text-red-600 bg-blue-100 p-1.5 rounded-md"></i>
                                        <span class="text-gray-800"> {{ ucwords($application->user->first_name ?? 'N/A') }}
                                            {{ ucwords($application->user->middle_name ?? 'N/A') }}
                                            {{ ucwords($application->user->last_name ?? 'N/A') }}</span>
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4 text-center text-gray-700">
                                    <div class="flex items-center justify-center gap-2">
                                        <i class="fas fa-calendar-alt text-indigo-500 bg-indigo-100 p-1.5 rounded-md"></i>
                                        <span class="text-gray-700">
                                            {{ $application->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </td>

                                @if ($application->status == 'approved')
                                    <td class="px-6 py-4 text-center text-gray-700">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-gray-700">
                                                {{ $application->approver->first_name }}
                                            </span>
                                        </div>
                                    </td>
                                @else
                                    <td class="px-6 py-4 text-left text-gray-800">
                                        --
                                    </td>
                                @endif



                                <!-- Status -->
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusStyles = [
                                            'submitted' => [
                                                'icon' => 'fas fa-paper-plane',
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-700',
                                            ],
                                            'approved' => [
                                                'icon' => 'fas fa-check-circle',
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-700',
                                            ],
                                            'disapproved' => [
                                                'icon' => 'fas fa-times-circle',
                                                'bg' => 'bg-red-100',
                                                'text' => 'text-red-700',
                                            ],
                                            'resubmit' => [
                                                'icon' => 'fas fa-sync-alt',
                                                'bg' => 'bg-yellow-100',
                                                'text' => 'text-yellow-700',
                                            ],
                                            'under_review' => [
                                                'icon' => 'fas fa-search',
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-700',
                                            ],
                                        ];

                                        $status = $statusStyles[$application->status] ?? [
                                            'icon' => 'fas fa-question-circle',
                                            'bg' => 'bg-gray-100',
                                            'text' => 'text-gray-600',
                                        ];
                                    @endphp

                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full {{ $status['bg'] }} {{ $status['text'] }}">
                                        <i class="{{ $status['icon'] }}"></i>
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>

                                <!-- Action -->
                                <td class="px-6 py-4 text-left space-x-2 flex items-center">

                                    <!-- View -->
                                    <a href="{{ route('obo.obo.building_view', $application->id) }}"
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
                                        <form action="{{ route('obo.approved', $application->id) }}"
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
                                        {{-- <form action="{{ route('zoning_officer.zoning.disapprove', $application->id) }}"
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
                                        <form action="{{ route('zoning_officer.zoning.resubmit', $application->id) }}"
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
                                        </form> --}}
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

            <form :action="`/obo/building_application_record/${appId}/${appPar}`" method="POST">
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

    <script src="{{ asset('asset/js/buildingRecordFilter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
