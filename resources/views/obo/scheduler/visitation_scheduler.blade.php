@extends('layout.applicant.app')

@section('title', 'Building Permit Schedule')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-cyan-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-full">

            <!-- Header Section -->
            <div class="mb-8">
                <div
                    class="rounded-2xl p-8 bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-600 shadow-lg overflow-hidden relative">
                    <!-- Background Pattern -->
                    <div class="absolute right-0 top-0 w-96 h-96 bg-white/5 rounded-full -mr-48 -mt-48"></div>
                    <div class="absolute left-0 bottom-0 w-72 h-72 bg-white/5 rounded-full -ml-36 -mb-36"></div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-building text-white text-2xl"></i>
                            </div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white">Building Permit Inspection Schedule</h1>
                        </div>
                        <p class="text-blue-100 text-lg max-w-2xl">
                            Manage and track building permit inspection schedules for all applications
                        </p>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Applications -->
                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Total Applications</p>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $applications->count() }}</h3>
                        </div>
                        <div class="p-4 bg-blue-100 text-blue-600 rounded-xl">
                            <i class="fas fa-folder-open text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Review -->
                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Pending Review</p>
                            <h3 class="text-3xl font-bold text-gray-800">
                                {{ $applications->where('status', 'submitted')->count() }}</h3>
                        </div>
                        <div class="p-4 bg-yellow-100 text-yellow-600 rounded-xl">
                            <i class="fas fa-hourglass-half text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Scheduled -->
                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Scheduled</p>
                            <h3 class="text-3xl font-bold text-gray-800">
                                {{ $applications->where('visitation_status', 'scheduled')->count() }}</h3>
                        </div>
                        <div class="p-4 bg-indigo-100 text-indigo-600 rounded-xl">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Completed -->
                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Completed</p>
                            <h3 class="text-3xl font-bold text-gray-800">
                                {{ $applications->where('visitation_status', 'completed')->count() }}</h3>
                        </div>
                        <div class="p-4 bg-green-100 text-green-600 rounded-xl">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Table Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Table Header -->
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-list text-blue-600"></i>
                                Inspection Records
                            </h2>
                            <p class="text-gray-500 text-sm mt-1">View and manage all scheduled building permit inspections
                            </p>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative w-full md:w-80">
                            <input type="search" id="customSearch" placeholder="Search applications..."
                                class="w-full pl-11 pr-4 py-3 border-2 border-gray-300 rounded-xl shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="px-8 py-5 border-b border-gray-200 bg-gradient-to-r from-white to-blue-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status Filters -->
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-filter text-blue-600"></i>
                                <p class="text-sm font-semibold text-gray-700">Filter by Status</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    class="filter-btn status-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200"
                                    data-type="status" data-value="all">All</button>
                                <button
                                    class="filter-btn status-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200"
                                    data-type="status" data-value="scheduled"><i
                                        class="fas fa-calendar text-xs mr-1"></i>Scheduled</button>
                                <button
                                    class="filter-btn status-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-cyan-50 text-cyan-700 hover:bg-cyan-100 border border-cyan-200"
                                    data-type="status" data-value="rescheduled"><i
                                        class="fas fa-sync-alt text-xs mr-1"></i>Rescheduled</button>
                                <button
                                    class="filter-btn status-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-green-50 text-green-700 hover:bg-green-100 border border-green-200"
                                    data-type="status" data-value="completed"><i
                                        class="fas fa-check text-xs mr-1"></i>Completed</button>
                                <button
                                    class="filter-btn status-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-red-50 text-red-700 hover:bg-red-100 border border-red-200"
                                    data-type="status" data-value="absent"><i
                                        class="fas fa-user-slash text-xs mr-1"></i>Absent</button>
                                <button
                                    class="filter-btn status-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200"
                                    data-type="status" data-value="cancelled"><i
                                        class="fas fa-ban text-xs mr-1"></i>Cancelled</button>
                            </div>
                        </div>

                        <!-- Date Filters -->
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-calendar-alt text-indigo-600"></i>
                                <p class="text-sm font-semibold text-gray-700">Filter by Date</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    class="filter-btn date-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200"
                                    data-type="date" data-value="all">All Dates</button>
                                <button
                                    class="filter-btn date-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200"
                                    data-type="date" data-value="today"><i
                                        class="fas fa-calendar-day text-xs mr-1"></i>Today</button>
                                <button
                                    class="filter-btn date-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200"
                                    data-type="date" data-value="last_week"><i
                                        class="fas fa-calendar-week text-xs mr-1"></i>Last Week</button>
                                <button
                                    class="filter-btn date-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all bg-cyan-50 text-cyan-700 hover:bg-cyan-100 border border-cyan-200"
                                    data-type="date" data-value="last_month"><i
                                        class="fas fa-calendar text-xs mr-1"></i>Last Month</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table id="example" class="w-full">
                        <thead
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-900 text-xs font-bold uppercase tracking-wider border-b-2 border-blue-200">
                            <tr>
                                <th class="px-6 py-4 text-left">Application ID</th>
                                <th class="px-6 py-4 text-left">Applicant Name</th>
                                <th class="px-6 py-4 text-center">Inspection Date</th>
                                <th class="px-6 py-4 text-center">Inspection Time</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($applications as $application)
                                <tr class="hover:bg-blue-50 transition-colors duration-200 border-b border-gray-100">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-2 font-semibold text-gray-800">
                                            <i class="fas fa-file-alt text-blue-600"></i>
                                            {{ $application->application_no }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">
                                                    {{ ucwords($application->first_name ?? 'N/A') }}
                                                    {{ ucwords($application->middle_name ?? '') }}
                                                    {{ ucwords($application->last_name ?? '') }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-700">
                                        @if ($application->visit_date)
                                            <div class="inline-flex items-center gap-2 px-3 py-2 bg-blue-50 rounded-lg">
                                                <i class="fas fa-calendar-alt text-blue-600 text-sm"></i>
                                                <span
                                                    class="font-medium text-sm">{{ \Carbon\Carbon::parse($application->visit_date)->format('M d, Y') }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Not Scheduled</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-700">
                                        @if ($application->visit_time)
                                            <div class="inline-flex items-center gap-2 px-3 py-2 bg-indigo-50 rounded-lg">
                                                <i class="fas fa-clock text-indigo-600 text-sm"></i>
                                                <span
                                                    class="font-medium text-sm">{{ \Carbon\Carbon::parse($application->visit_time)->format('h:i A') }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Not Set</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusConfig = [
                                                'submitted' => [
                                                    'bg' => 'bg-yellow-100',
                                                    'text' => 'text-yellow-800',
                                                    'icon' => 'fa-file',
                                                    'label' => 'Submitted',
                                                ],
                                                'under_review' => [
                                                    'bg' => 'bg-blue-100',
                                                    'text' => 'text-blue-800',
                                                    'icon' => 'fa-magnifying-glass',
                                                    'label' => 'Under Review',
                                                ],
                                                'approved' => [
                                                    'bg' => 'bg-green-100',
                                                    'text' => 'text-green-800',
                                                    'icon' => 'fa-check',
                                                    'label' => 'Approved',
                                                ],
                                                'scheduled' => [
                                                    'bg' => 'bg-indigo-100',
                                                    'text' => 'text-indigo-800',
                                                    'icon' => 'fa-calendar-check',
                                                    'label' => 'Scheduled',
                                                ],
                                                'completed' => [
                                                    'bg' => 'bg-green-200',
                                                    'text' => 'text-green-900',
                                                    'icon' => 'fa-check-circle',
                                                    'label' => 'Completed',
                                                ],
                                                'absent' => [
                                                    'bg' => 'bg-red-100',
                                                    'text' => 'text-red-800',
                                                    'icon' => 'fa-user-slash',
                                                    'label' => 'Absent',
                                                ],
                                                'cancelled' => [
                                                    'bg' => 'bg-gray-200',
                                                    'text' => 'text-gray-800',
                                                    'icon' => 'fa-ban',
                                                    'label' => 'Cancelled',
                                                ],
                                                'rescheduled' => [
                                                    'bg' => 'bg-cyan-100',
                                                    'text' => 'text-cyan-800',
                                                    'icon' => 'fa-sync-alt',
                                                    'label' => 'Rescheduled',
                                                ],
                                            ];
                                            $config = $statusConfig[$application->visitation_status] ?? [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-700',
                                                'icon' => 'fa-question',
                                                'label' => ucfirst($application->visitation_status ?? 'Unknown'),
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold {{ $config['bg'] }} {{ $config['text'] }}">
                                            <i class="fas {{ $config['icon'] }}"></i>
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            @if ($application->visitation_status === 'scheduled' || $application->visitation_status === 'rescheduled')
                                                <!-- Reschedule -->
                                                <button type="button"
                                                    @click="$dispatch('open-remarks-modal', { id: '{{ $application->application_id }}', title: 'Reschedule Visit', par:'reschedule'})"
                                                    class="p-2.5 bg-cyan-100 hover:bg-cyan-200 text-cyan-600 rounded-lg transition-all"
                                                    title="Reschedule">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </button>

                                                <!-- Completed -->
                                                <button type="button"
                                                    @click="markStatus('{{ $application->visitation_id }}', 'completed')"
                                                    class="p-2.5 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-all"
                                                    title="Mark Completed">
                                                    <i class="fas fa-check"></i>
                                                </button>

                                                <!-- No-Show -->
                                                <button type="button"
                                                    @click="markStatus('{{ $application->visitation_id }}', 'absent')"
                                                    class="p-2.5 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-all"
                                                    title="Mark Absent">
                                                    <i class="fas fa-user-slash"></i>
                                                </button>

                                                <!-- Cancel -->
                                                <button type="button"
                                                    @click="markStatus('{{ $application->visitation_id }}', 'cancelled')"
                                                    class="p-2.5 bg-gray-200 hover:bg-gray-300 text-gray-600 rounded-lg transition-all"
                                                    title="Cancel">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                @if ($application->visitation_status === 'completed')
                                                    <span class="text-gray-400 text-sm italic">No actions</span>
                                                @else
                                                    <button type="button"
                                                        @click="$dispatch('open-remarks-modal', { id: '{{ $application->application_id }}', title: 'Schedule Visit', par:'set_schedule'})"
                                                        class="px-4 py-2.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-all font-medium text-sm flex items-center gap-2"
                                                        title="Schedule">
                                                        <i class="fas fa-calendar-plus"></i>
                                                        Schedule
                                                    </button>
                                                @endif
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
    </div>

    <!-- Modal -->
    <div x-data="{ open: false, appId: null, appTitle: '', appPar: '' }"
        x-on:open-remarks-modal.window="open = true; appId = $event.detail.id; appTitle = $event.detail.title; appPar = $event.detail.par"
        x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

        <div @click.away="open = false"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 transform transition-all">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-calendar-plus text-blue-600 mr-2"></i>
                    <span x-text="appTitle"></span>
                </h2>
                <p class="text-gray-500 text-sm">Configure the inspection schedule details</p>
            </div>

            <form :action="`/obo/visitation/${appId}/${appPar}`" method="POST">
                @csrf

                <div class="space-y-5">
                    <!-- Visit Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar text-blue-600 mr-2"></i>Inspection Date
                        </label>
                        <input type="date" name="visit_date" required x-init="$el.min = new Date().toISOString().split('T')[0]"
                            class="w-full border-2 border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-medium">
                    </div>

                    <!-- Visit Time -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-clock text-indigo-600 mr-2"></i>Inspection Time
                        </label>
                        <input type="time" name="visit_time" required step="1800" value="08:00"
                            class="w-full border-2 border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition font-medium">
                    </div>

                    <!-- Notes / Purpose -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-note-sticky text-cyan-600 mr-2"></i>Notes / Purpose
                        </label>
                        <textarea name="remarks" rows="4"
                            class="w-full border-2 border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition resize-none"
                            placeholder="Add any relevant notes or special instructions..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                    <button type="button" @click="open = false"
                        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg font-medium transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-check mr-2"></i>Schedule Inspection
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
                title: "Success!",
                text: "Schedule updated successfully",
                showConfirmButton: false,
                timer: 2500
            });
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

    <script src="{{ asset('asset/js/oboVisitationModal.js') }}"></script>
    <script src="{{ asset('asset/js/oboVisitationFilter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
