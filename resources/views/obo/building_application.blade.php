@extends('layout.applicant.app')

@section('title', 'Building Application Records')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-full mx-auto px-6 py-8">

            <!-- Header Banner -->
            <div
                class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 shadow-lg mb-8 p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
                <!-- Left Section -->
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-16 h-16 flex items-center justify-center bg-white/20 backdrop-blur-md rounded-full shadow-lg border border-white/30">
                            <i class="fas fa-building text-white text-3xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">
                                Building Applications
                            </h1>
                            <p class="text-blue-100 text-sm md:text-base mt-1">
                                Manage and review applicant building permit submissions
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Decorative Illustration -->
                <div class="hidden md:block relative">
                    <img src="{{ asset('asset/img/architecture-and-city.png') }}" alt="Building Illustration"
                        class="w-40 opacity-90 drop-shadow-lg hover:scale-105 transition-transform duration-300">
                </div>

                <!-- Decorative Overlays -->
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-blue-900/20 pointer-events-none"></div>
                <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-blue-400/20 rounded-full blur-3xl"></div>
                <div class="absolute -top-16 -left-16 w-64 h-64 bg-blue-300/20 rounded-full blur-3xl"></div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Applications -->
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-blue-600 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Applications</p>
                            <h3 class="text-3xl font-bold text-gray-900">{{ $applications->count() }}</h3>
                        </div>
                        <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                            <i class="fas fa-folder-open text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Approved -->
                <div
                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-green-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Approved</p>
                            <h3 class="text-3xl font-bold text-gray-900">
                                {{ $applications->where('status', 'approved')->count() }}
                            </h3>
                        </div>
                        <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Disapproved -->
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-red-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Disapproved</p>
                            <h3 class="text-3xl font-bold text-gray-900">
                                {{ $applications->where('status', 'disapproved')->count() }}
                            </h3>
                        </div>
                        <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                            <i class="fas fa-times-circle text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Resubmit -->
                <div
                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-amber-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Awaiting Resubmit</p>
                            <h3 class="text-3xl font-bold text-gray-900">
                                {{ $applications->where('status', 'resubmit')->count() }}
                            </h3>
                        </div>
                        <div class="p-3 bg-amber-100 text-amber-600 rounded-lg">
                            <i class="fas fa-redo text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications Table Section -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="border-b border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Application Records</h2>
                    <p class="text-gray-600 text-sm">Review and manage all building permit applications</p>
                </div>

                <!-- Filters -->
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- Left: Filter Dropdowns -->
                        <div class="flex gap-3 flex-wrap items-center w-full sm:w-auto">
                            <!-- Status Filter -->
                            <select id="statusFilter"
                                class="filter-select status-select bg-blue-50 border border-blue-200 text-blue-900 px-4 py-2 rounded-lg font-medium cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <option data-type="status" data-value="all" value="all">All Status</option>
                                <option data-type="status" data-value="under_review" value="under_review">Under Review
                                </option>
                                <option data-type="status" data-value="approved" value="approved">Approved</option>
                                <option data-type="status" data-value="disapproved" value="disapproved">Disapproved</option>
                                <option data-type="status" data-value="resubmit" value="resubmit">Resubmit</option>
                            </select>

                            <!-- Date Filter -->
                            <select id="dateFilter"
                                class="filter-select date-select bg-blue-50 border border-blue-200 text-blue-900 px-4 py-2 rounded-lg font-medium cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <option data-type="date" data-value="all" value="all">All Dates</option>
                                <option data-type="date" data-value="today" value="today">Today</option>
                                <option data-type="date" data-value="last_week" value="last_week">Last Week</option>
                                <option data-type="date" data-value="last_month" value="last_month">Last Month</option>
                            </select>
                        </div>

                        <!-- Right: Search Input -->
                        <div class="w-full sm:w-80 relative">
                            <input type="search" id="customSearch" placeholder="Search by ID, name, or applicant..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition" />
                            <i
                                class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto p-10">
                    <table class="min-w-full text-sm text-gray-700" id="applicantTable">
                        <thead class="bg-gray-100 border-b border-gray-300">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-gray-900 w-10">#</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-900">Application ID</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-900">Applicant Name</th>
                                <th class="px-6 py-4 text-center font-semibold text-gray-900">Date Submitted</th>
                                <th class="px-6 py-4 text-center font-semibold text-gray-900">Approved By</th>
                                <th class="px-6 py-4 text-center font-semibold text-gray-900">Status</th>
                                <th class="px-6 py-4 text-center font-semibold text-gray-900">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @foreach ($applications as $index => $application)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <!-- Row Number -->
                                    <td class="px-6 py-4 font-semibold text-gray-700">
                                        {{ $index + 1 }}
                                    </td>

                                    <!-- Application ID -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-file-alt text-blue-600"></i>
                                            <span
                                                class="font-medium text-gray-900">{{ $application->application_no }}</span>
                                        </div>
                                    </td>

                                    <!-- Applicant Name -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-blue-200 flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600 text-xs"></i>
                                            </div>
                                            <span class="text-gray-900 font-medium">
                                                {{ ucwords($application->user->first_name ?? 'N/A') }}
                                                {{ ucwords($application->user->middle_name ?? '') }}
                                                {{ ucwords($application->user->last_name ?? 'N/A') }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Date Submitted -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2 text-gray-700">
                                            <i class="fas fa-calendar-alt text-blue-500"></i>
                                            {{ $application->created_at->format('M d, Y') }}
                                        </div>
                                    </td>

                                    <!-- Approved By -->
                                    <td class="px-6 py-4 text-center text-gray-700">
                                        @if ($application->status == 'approved')
                                            <span
                                                class="font-medium">{{ $application->approver->first_name ?? '--' }}</span>
                                        @else
                                            <span class="text-gray-400">--</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusConfig = [
                                                'submitted' => [
                                                    'icon' => 'fas fa-paper-plane',
                                                    'bg' => 'bg-gray-100',
                                                    'text' => 'text-gray-700',
                                                    'label' => 'Submitted',
                                                ],
                                                'approved' => [
                                                    'icon' => 'fas fa-check-circle',
                                                    'bg' => 'bg-green-100',
                                                    'text' => 'text-green-700',
                                                    'label' => 'Approved',
                                                ],
                                                'disapproved' => [
                                                    'icon' => 'fas fa-times-circle',
                                                    'bg' => 'bg-red-100',
                                                    'text' => 'text-red-700',
                                                    'label' => 'Disapproved',
                                                ],
                                                'resubmit' => [
                                                    'icon' => 'fas fa-sync-alt',
                                                    'bg' => 'bg-amber-100',
                                                    'text' => 'text-amber-700',
                                                    'label' => 'Resubmit',
                                                ],
                                                'under_review' => [
                                                    'icon' => 'fas fa-hourglass-half',
                                                    'bg' => 'bg-blue-100',
                                                    'text' => 'text-blue-700',
                                                    'label' => 'Under Review',
                                                ],
                                            ];
                                            $status = $statusConfig[$application->status] ?? [
                                                'icon' => 'fas fa-question-circle',
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-600',
                                                'label' => 'Unknown',
                                            ];
                                        @endphp

                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold rounded-full {{ $status['bg'] }} {{ $status['text'] }}">
                                            <i class="{{ $status['icon'] }}"></i>
                                            {{ $status['label'] }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- View Button -->
                                            <a href="{{ route('obo.obo.building_view', $application->id) }}"
                                                class="relative inline-block p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition duration-200"
                                                x-data="{ open: false }" @mouseenter="open = true"
                                                @mouseleave="open = false" title="View Details">
                                                <i class="fas fa-eye"></i>
                                                <div x-show="open" x-transition
                                                    class="absolute -bottom-8 left-1/2 -translate-x-1/2 px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded shadow-lg z-50 whitespace-nowrap"
                                                    style="display: none;">
                                                    View Details
                                                </div>
                                            </a>

                                            <!-- Approve Button (Under Review) -->
                                            @if ($application->status === 'under_review')
                                                <button type="button"
                                                    @click="$dispatch('open-remarks-modal', { id: '{{ $application->id }}', title: 'Approve', action: 'approve'})"
                                                    class="p-2 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition duration-200"
                                                    title="Approve Application">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
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

    <!-- Remarks Modal -->
    <div x-data="{ open: false, appId: null, appTitle: '', appAction: '' }"
        x-on:open-remarks-modal.window="open = true; appId = $event.detail.id; appTitle = $event.detail.title; appAction = $event.detail.action"
        x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/20 backdrop-blur-md p-4"
        style="background: rgba(0, 0, 0, 0.1); backdrop-filter: blur(8px);">
        <div @click.away="open = false"
            class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 transform transition-all">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-comment-dots text-blue-600"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-900">
                    Add Remarks
                </h2>
            </div>

            <p class="text-sm text-gray-600 mb-4">
                Please provide remarks for: <span x-text="appTitle" class="font-semibold text-gray-900"></span>
            </p>

            <form :action="`/obo/building_application_record/${appId}/${appAction}`" method="POST" class="space-y-4">
                @csrf
                <textarea name="remarks" rows="5" required placeholder="Enter your remarks here..."
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none resize-none"></textarea>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Alert -->
    @if (session('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Success!",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    @endif

    <script src="{{ asset('asset/js/buildingRecordFilter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
