@extends('layout.applicant.app')

@section('title', 'Safety Clearance')

@section('content')
    <div x-data="{ open: false }" class="max-w-7xl mx-auto px-6 py-8">

        <!-- Header -->
        <div class="rounded-xl p-6 bg-gradient-to-r from-red-100 via-red-200 to-red-300 shadow-md mb-6">
            <h2 class="text-2xl font-bold text-red-700">👨‍🚒 Safety Clerance</h2>
            <p class="text-gray-700 text-sm mt-1">
                Track, manage, and create your Safety Applications in this section.
            </p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total -->
            <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4">
                <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Applications</p>
                    <h3 class="text-xl font-bold text-gray-800">0</h3>
                </div>
            </div>

            <!-- Approved -->
            <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4">
                <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Approved</p>
                    <h3 class="text-xl font-bold text-gray-800">0
                    </h3>
                </div>
            </div>

            <!-- Under Review -->
            <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                    <i class="fas fa-search text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Under Review</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        0</h3>
                </div>
            </div>

            <!-- Disapproved -->
            <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4">
                <div class="p-3 bg-red-200 text-red-700 rounded-lg">
                    <i class="fas fa-times-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Disapproved</p>
                    <h3 class="text-xl font-bold text-gray-800">0
                    </h3>
                </div>
            </div>
        </div>

        <!-- Card Container (Table Section) -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- Top Bar -->
            <div class="flex flex-col sm:flex-row justify-between items-center border-b border-gray-200 px-6 py-4 gap-4">
                <!-- Search -->
                <div class="flex items-center w-full sm:w-1/3 relative">
                    <input type="search" id="customSearch" placeholder="🔍 Search applications..."
                        class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm text-sm focus:ring-2 focus:ring-red-500 focus:outline-none">
                    <i class="fas fa-search absolute left-3 text-gray-400"></i>
                </div>

                <!-- Create Button -->
                <button @click="open = true"
                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm shadow-md flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i> Create New Application
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto p-10">
                <table id="example" class="w-full text-sm border-t border-gray-200">
                    <thead class="bg-red-50 text-red-700 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-center">Application ID</th>
                            <th class="px-6 py-3 text-center">Application Date</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        {{-- @foreach ($applications as $application)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center font-semibold text-gray-800">
                                    {{ $application->application_no }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600">
                                    {{ $application->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusColors = [
                                            'submitted' => 'bg-gray-100 text-gray-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'disapproved' => 'bg-red-100 text-red-700',
                                            'resubmit' => 'bg-yellow-100 text-yellow-700',
                                            'under_review' => 'bg-blue-100 text-blue-700',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$application->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('applicant.zoning.zoning_application_view', $application->id) }}"
                                        class="text-blue-600 hover:underline text-sm font-medium">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
        <div x-show="open" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-transparent bg-opacity-30 backdrop-blur-sm">
            <div @click.away="open = false"
                class="bg-white rounded-lg m-5 shadow-xl max-w-lg w-full p-6 relative transform transition-all">
                <!-- Close Button --> <button @click="open = false"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"> <i class="fas fa-times"></i> </button>
                <!-- Modal Content -->
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Data Privacy Notice</h2>
                <p class="text-sm text-gray-600 mb-6"> By creating a new application, you agree to the collection and
                    processing of your personal data in compliance with the Data Privacy Act. Your information will only be
                    used for zoning application purposes and will be kept strictly confidential. </p>
                <div class="flex justify-end gap-3"> <button @click="open = false"
                        class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md"> Cancel </button>
                    <a href="{{ route('applicant.forms.zoning.zoning_form') }}"
                        onclick="event.preventDefault(); localStorage.clear(); window.location.href=this.href;"
                        class="px-4 py-2 text-sm bg-red-500 hover:bg-red-600 text-white rounded-md"> I Agree </a>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable Script -->
    <script>
        $(document).ready(function() {
            let table = $('#example').DataTable({
                dom: "<'hidden'f>rt<'flex flex-col sm:flex-row justify-between items-center mt-4 gap-3'<'w-full sm:w-1/2'i><'w-full sm:w-1/2'p>>",
                language: {
                    search: "",
                    lengthMenu: "Show _MENU_ entries"
                }
            });

            // Custom search box
            $('#customSearch').on('keyup', function() {
                table.search(this.value).draw();
            });


        });
    </script>

    <!-- Custom Styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        .dataTable td {
            padding: 1rem 1rem !important;
        }

        table.dataTable thead th {
            text-align: center !important;
        }

        /* DataTable Pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
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
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection
