@extends('layout.applicant.app')

@section('title', 'Zoning Applications Management')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- Header -->
        <div class="rounded-xl p-6 bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-md mb-6">
            <h2 class="text-2xl font-bold text-blue-700">🏛️ Zoning Record Dashboard</h2>
            <p class="text-gray-700 text-sm mt-1">
                Review, approve, or request changes on zoning applications submitted by applicants.
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
                        <h1 class="text-xl font-bold text-gray-800">ZONING RECORDS TABLE</h1>
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
                                    <a href="{{ route('obo.zoning.zoning_view_record', $application->id) }}"
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
                                        <form action="{{ route('obo.zoning.approve', $application->id) }}" method="POST"
                                            class="inline">
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
                                        <form action="{{ route('obo.zoning.disapprove', $application->id) }}"
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
                                        <form action="{{ route('obo.zoning.resubmit', $application->id) }}"
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

            <form :action="`/obo/zoning/${appId}/${appPar}`" method="POST">
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <!-- DataTable Script -->
    <script>
        $(document).ready(function() {
            let table = $('#example').DataTable({
                dom: "<'hidden'f>rt<'flex flex-col sm:flex-row justify-between items-center mt-4 gap-3'<'w-full sm:w-1/2'i><'w-full sm:w-1/2'p>>",
                language: {
                    search: "",
                    lengthMenu: "Show _MENU_ entries",
                    emptyTable: "🚫 No applications found."
                }
            });

            $('#customSearch').on('input', function() {
                table.search(this.value).draw();
            });

            let selectedStatus = "all";
            let selectedDate = "all";

            $(".filter-btn").on("click", function() {
                let type = $(this).data("type");
                let value = $(this).data("value");

                if (type === "status") {
                    if (selectedStatus === value) {
                        selectedStatus = "all";
                    } else {
                        selectedStatus = value;
                    }

                    // Reset all status buttons to their original bg/text color
                    $(".status-btn").each(function() {
                        let val = $(this).data("value");
                        switch (val) {
                            case "all":
                                $(this).removeClass().addClass(
                                    "filter-btn status-btn bg-gray-200 text-gray-800 px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "under_review":
                                $(this).removeClass().addClass(
                                    "filter-btn status-btn bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "approved":
                                $(this).removeClass().addClass(
                                    "filter-btn status-btn bg-green-100 text-green-800 px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "disapproved":
                                $(this).removeClass().addClass(
                                    "filter-btn status-btn bg-red-100 text-red-800 px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "resubmit":
                                $(this).removeClass().addClass(
                                    "filter-btn status-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                        }
                    });

                    // Add dark background for active
                    if (selectedStatus !== "all") {
                        $(this).removeClass().addClass(
                            "filter-btn status-btn bg-gray-800 text-white px-4 py-2 rounded-full font-medium"
                            );
                        switch (selectedStatus) {
                            case "under_review":
                                $(this).removeClass().addClass(
                                    "filter-btn status-btn bg-blue-800 text-white px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "approved":
                                $(this).removeClass().addClass(
                                    "filter-btn status-btn bg-green-800 text-white px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "disapproved":
                                $(this).removeClass().addClass(
                                    "filter-btn status-btn bg-red-800 text-white px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "resubmit":
                                $(this).removeClass().addClass(
                                    "filter-btn status-btn bg-yellow-800 text-white px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                        }
                    }
                }

                if (type === "date") {
                    if (selectedDate === value) {
                        selectedDate = "all";
                    } else {
                        selectedDate = value;
                    }

                    // Reset all date buttons to original colors
                    $(".date-btn").each(function() {
                        let val = $(this).data("value");
                        switch (val) {
                            case "all":
                                $(this).removeClass().addClass(
                                    "filter-btn date-btn bg-gray-200 text-gray-800 px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "today":
                                $(this).removeClass().addClass(
                                    "filter-btn date-btn bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "last_week":
                                $(this).removeClass().addClass(
                                    "filter-btn date-btn bg-green-100 text-green-800 px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "last_month":
                                $(this).removeClass().addClass(
                                    "filter-btn date-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                        }
                    });

                    // Add dark background for active
                    if (selectedDate !== "all") {
                        switch (selectedDate) {
                            case "today":
                                $(this).removeClass().addClass(
                                    "filter-btn date-btn bg-blue-800 text-white px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "last_week":
                                $(this).removeClass().addClass(
                                    "filter-btn date-btn bg-green-800 text-white px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                            case "last_month":
                                $(this).removeClass().addClass(
                                    "filter-btn date-btn bg-yellow-800 text-white px-4 py-2 rounded-full font-medium"
                                    );
                                break;
                        }
                    }
                }

                table.draw(); 
            });


           
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                let statusCell = data[3]; 
                let dateStr = data[2]; 

                // Normalize status text
                let statusText = statusCell
                    .trim() 
                    .toLowerCase() 
                    .replace(/\s+/g, "_"); 
               
                let filterStatus = selectedStatus.toLowerCase().trim();

                let recordDate = moment(dateStr, "MMM DD, YYYY");

             
                let statusPass = (selectedStatus === "all") || statusText === selectedStatus;

                // DATE filter
                let datePass = true;
                let today = moment();
                if (selectedDate === "today") {
                    datePass = recordDate.isSame(today, "day");
                } else if (selectedDate === "last_week") {
                    datePass = recordDate.isBetween(today.clone().subtract(7, 'days'), today, 'day', '[]');
                } else if (selectedDate === "last_month") {
                    datePass = recordDate.isSame(today.clone().subtract(1, 'month'), "month");
                }

                return statusPass && datePass;
            });


        });
    </script>
    <!-- Custom Styles -->
    <style>
        /* input[type="search"]::-webkit-search-cancel-button {
                                                                            -webkit-appearance: none;
                                                                            appearance: none;
                                                                            display: none;
                                                                        } */

        [x-cloak] {
            display: none !important;
        }

        .dataTable td {
            padding: 1rem 1rem !important;
        }

        table.dataTable thead th {
            text-align: left !important;
        }

        /* DataTable Pagination */
        /* .dataTables_wrapper .dataTables_paginate .paginate_button {
                                                                                                                                                                background: #f8f8f8;
                                                                                                                                                                color: #333 !important;
                                                                                                                                                                border: 1px solid #ddd;
                                                                                                                                                                border-radius: 6px;
                                                                                                                                                                padding: 4px 12px;
                                                                                                                                                                margin: 2px;
                                                                                                                                                            }

                                                                                                                                                            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                                                                                                                                                                background: #dc2626 !important;
                                                                                                                                                                color: #fff !important;
                                                                                                                                                                border: 1px solid #dc2626;
                                                                                                                                                            }

                                                                                                                                                            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                                                                                                                                                                background: #ef4444 !important;
                                                                                                                                                                color: #fff !important;
                                                                                                                                                            } */
    </style>
@endsection
