@extends('layout.applicant.app')

@section('title', 'Zoning Schedule')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- Header -->
        <div class="rounded-xl p-6 bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-md mb-6">
            <h2 class="text-2xl font-bold text-blue-700">🔎 Zoning Schedule Visitation </h2>
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
                        <h1 class="text-xl font-bold text-gray-800">VISITATIONS RECORDS</h1>
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
                <!-- Status Filters Buttons -->
                <button class="filter-btn status-btn bg-gray-200 text-gray-800 p-2 w-10 rounded-xl font-medium"
                    data-type="status" data-value="all">All</button>
                <button class="filter-btn status-btn bg-blue-100 text-blue-800 px-4 py-2 rounded-xl font-medium"
                    data-type="status" data-value="scheduled">Scheduled</button>
                <button class="filter-btn status-btn bg-orange-100 text-orange-800 px-4 py-2 rounded-xl font-medium"
                    data-type="status" data-value="rescheduled">Rescheduled</button>
                <button class="filter-btn status-btn bg-green-100 text-green-800 px-4 py-2 rounded-xl font-medium"
                    data-type="status" data-value="completed">Completed</button>
                <button class="filter-btn status-btn bg-red-100 text-red-800 px-4 py-2 rounded-xl font-medium"
                    data-type="status" data-value="absent">Absent</button>
                <button class="filter-btn status-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-xl font-medium"
                    data-type="status" data-value="cancelled">Cancelled</button>


                <!-- Date Filters -->
                <button class="filter-btn date-btn bg-gray-200 text-gray-800 px-4 py-2 rounded-xl font-medium"
                    data-type="date" data-value="all">All Dates</button>
                <button class="filter-btn date-btn bg-blue-100 text-blue-800 px-4 py-2 rounded-xl font-medium"
                    data-type="date" data-value="today">Today</button>
                <button class="filter-btn date-btn bg-green-100 text-green-800 px-4 py-2 rounded-xl font-medium"
                    data-type="date" data-value="last_week">Last Week</button>
                <button class="filter-btn date-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-xl font-medium"
                    data-type="date" data-value="last_month">Last Month</button>
            </div>



            <div class="overflow-x-auto p-10">
                <table id="example" class="w-full text-sm border-t border-gray-200">
                    <thead class="bg-blue-50 text-blue-700 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-center">Application ID</th>
                            <th class="px-6 py-3 text-center">Applicant Name</th>
                            <th class="px-6 py-3 text-center">Visitation Date</th>
                            <th class="px-6 py-3 text-center">Visitation Time</th>
                            <th class="px-6 py-3 text-center">Visitation Status</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        {{-- @foreach ($visitations as $visitation)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-left font-semibold text-gray-800">
                                    {{ $visitation->zoningApplication->application_no }}
                                </td>
                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ ucwords($visitation->zoningApplication->user->first_name ?? 'N/A') }}
                                    {{ ucwords($visitation->zoningApplication->user->middle_name ?? 'N/A') }}
                                    {{ ucwords($visitation->zoningApplication->user->last_name ?? 'N/A') }}
                                </td>
                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ \Carbon\Carbon::parse($visitation->visit_date)->format('M d, Y') }}

                                </td>
                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ \Carbon\Carbon::parse($visitation->visit_time)->format('h:i A') }}
                                </td>

                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ $visitation->status ? $visitation->status : '----' }}

                                </td>
                                <td class="px-6 py-4 text-left space-x-2 flex items-center">
                                    @if ($visitation->status === 'scheduled')
                                        <!-- Reschedule Button -->
                                        <button type="button"
                                            @click="$dispatch('open-remarks-modal', { id: '{{ $visitation->id }}', title: 'Reschedule Visit', par:'reschedule'})"
                                            class="p-2 bg-yellow-100 rounded-md hover:bg-yellow-200 transition text-yellow-600"
                                            title="Reschedule">
                                            <i class="fas fa-calendar-alt"></i>
                                        </button>

                                        <!-- Cancel Button -->
                                        <form action="#" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="p-2 bg-red-100 rounded-md hover:bg-red-200 transition text-red-600"
                                                title="Cancel Schedule">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <!-- Set Schedule Button -->
                                        <form action="{{ route('obo.zoning.approve', $visitation->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="button"
                                                @click="$dispatch('open-remarks-modal', { id: '{{ $visitation->id }}', title: 'Set Visit', par: 'approve'})"
                                                class="p-2 bg-green-100 rounded-md hover:bg-green-200 transition text-green-600"
                                                title="Set Schedule">
                                                <i class="fas fa-calendar"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach --}}

                        @foreach ($applications as $application)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-left font-semibold text-gray-800">
                                    {{ $application->application_no }}
                                </td>
                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ ucwords($application->first_name ?? 'N/A') }}
                                    {{ ucwords($application->middle_name ?? '') }}
                                    {{ ucwords($application->last_name ?? '') }}
                                </td>
                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ $application->visit_date ? \Carbon\Carbon::parse($application->visit_date)->format('M d, Y') : '---' }}
                                </td>
                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ $application->visit_time ? \Carbon\Carbon::parse($application->visit_time)->format('h:i A') : '---' }}
                                </td>
                                <td class="px-6 py-4 text-left">
                                    @php
                                        $statusColors = [
                                            'submitted' => 'bg-yellow-100 text-yellow-700',
                                            'under_review' => 'bg-blue-100 text-blue-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'disapproved' => 'bg-red-100 text-red-700',
                                            'resubmit' => 'bg-gray-200 text-gray-700',
                                            'scheduled' => 'bg-purple-100 text-purple-700',
                                            'completed' => 'bg-green-200 text-green-800',
                                            'cancelled' => 'bg-gray-300 text-gray-800',
                                        ];

                                        $stageLabels = [
                                            'submitted' => 'Submitted',
                                            'under_review' => 'Under Review',
                                            'approved' => 'Approved',
                                            'disapproved' => 'Disapproved',
                                            'resubmit' => 'Resubmit',
                                            'scheduled' => 'Scheduled',
                                            'completed' => 'Completed',
                                            'cancelled' => 'Cancelled',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$application->visitation_status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $stageLabels[$application->visitation_status] ?? ucfirst($application->visitation_status ?? '---') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-left space-x-2 flex items-center">


                                    @if ($application->visitation_status === 'scheduled' || $application->visitation_status === 'rescheduled')
                                        <button type="button"
                                            @click="$dispatch('open-remarks-modal', { id: '{{ $application->application_id }}', title: 'Reschedule Visit', par:'reschedule'})"
                                            class="p-2 bg-yellow-100 rounded-md hover:bg-yellow-200 transition text-yellow-600"
                                            title="Reschedule">
                                            <i class="fas fa-calendar-alt"></i>
                                        </button>



                                        <!-- Completed -->
                                        <button type="button"
                                            @click="markStatus('{{ $application->visitation_id }}', 'completed')"
                                            class="p-2 bg-green-100 rounded-md hover:bg-green-200 transition text-green-600"
                                            title="Completed">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        <!-- No-Show -->
                                        <button type="button"
                                            @click="markStatus('{{ $application->visitation_id }}', 'absent')"
                                            class="p-2 bg-red-100 rounded-md hover:bg-red-200 transition text-red-600"
                                            title="No Show">
                                            <i class="fas fa-user-slash"></i>
                                        </button>

                                        {{-- cancel --}}
                                        <button type="button"
                                            @click="markStatus('{{ $application->visitation_id }}', 'cancelled')"
                                            class="p-2 bg-gray-100 rounded-md hover:bg-gray-200 transition text-gray-600"
                                            title="Cancel">
                                            <i class="fas fa-x"></i>
                                        </button>
                                    @else
                                        @if ($application->visitation_status === 'completed')
                                            <h1>---</h1>
                                        @else
                                            <button type="button"
                                                @click="$dispatch('open-remarks-modal', { id: '{{ $application->application_id }}', title: 'Schedule Visit', par:'set_schedule'})"
                                                class="p-2 bg-yellow-100 rounded-md hover:bg-gray-200 transition text-yellow-600"
                                                title="Schedule">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        @endif
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
                title: "Schedule Created!",
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
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Schedule Zoning Visit</h2>
                <p class="text-gray-500">for <span class="font-medium text-gray-700" x-text="appTitle"></span></p>
            </div>

            <form :action="`/zoning_officer/zoning/${appId}/${appPar}`" method="POST">
                @csrf

                <!-- Visit Date -->
                <label class="block mb-2 font-medium">Visit Date</label>
                <input type="date" name="visit_date" required x-init="$el.min = new Date().toISOString().split('T')[0]"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">

                <!-- Visit Time -->
                <label class="block mb-2 font-medium">Visit Time</label>
                <input type="time" name="visit_time" required step="1800" value="08:00"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-500 mb-4">

                <!-- Notes / Purpose -->
                <label class="block mb-2 font-medium">Notes / Purpose</label>
                <textarea name="remarks" rows="3"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-500 mb-4"
                    placeholder="Optional notes about the visit..."></textarea>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                        Schedule
                    </button>
                </div>
            </form>
        </div>
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

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
            });
        </script>
    @endif
    <script src="{{ asset('asset/js/zoningVisitationModal.js') }}"></script>
    <script src="{{ asset('asset/js/zoningVisitationFilter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
