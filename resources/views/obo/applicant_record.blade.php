@extends('layout.applicant.app')

@section('title', 'Building Application Users')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-blue-100 md:p-0">
        <div class="w-full">
            <!-- Hero Section -->
           

            <!-- Statistics Cards -->
            <div class="px-4 md:px-8 mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Approved Card -->
                    <div
                        class="group bg-white rounded-xl shadow-md border-l-4 border-blue-500 p-6 hover:shadow-lg hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-600 text-sm font-medium mb-2">Approved Applicants</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-bold text-blue-700">{{ $approvedCount ?? 0 }}</span>
                                    <span class="text-xs text-slate-500">verified users</span>
                                </div>
                                <p class="text-xs text-blue-600 mt-3">Ready to proceed</p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded-full group-hover:bg-blue-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Card -->
                    <div
                        class="group bg-white rounded-xl shadow-md border-l-4 border-yellow-500 p-6 hover:shadow-lg hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-600 text-sm font-medium mb-2">Pending Applications</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-bold text-yellow-700">{{ $pendingCount ?? 0 }}</span>
                                    <span class="text-xs text-slate-500">awaiting review</span>
                                </div>
                                <p class="text-xs text-yellow-600 mt-3">Need attention</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-full group-hover:bg-yellow-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-600" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Rejected Card -->
                    <div
                        class="group bg-white rounded-xl shadow-md border-l-4 border-red-500 p-6 hover:shadow-lg hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-600 text-sm font-medium mb-2">Rejected Applications</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-bold text-red-700">{{ $rejectedCount ?? 0 }}</span>
                                    <span class="text-xs text-slate-500">declined users</span>
                                </div>
                                <p class="text-xs text-red-600 mt-3">Resubmission needed</p>
                            </div>
                            <div class="bg-red-100 p-4 rounded-full group-hover:bg-red-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main Content Section -->
            <div class="mx-4 md:mx-8 mb-8 bg-white rounded-xl shadow-lg overflow-hidden ">

                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 md:px-8 py-6 md:py-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">Manage Applicant Accounts</h1>
                            <p class="text-blue-100 text-sm mt-2">Review, verify, and manage all building permit applicant
                                records</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition font-medium text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Export Report
                            </button>
                            <button
                                class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition font-medium text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Advanced Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search Section -->
                <div class="px-6 md:px-8 py-6 border-b border-slate-200 bg-slate-50">
                    <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center">
                        <div class="relative flex-1 md:flex-1">
                            <input type="search" id="customSearch"
                                placeholder="🔍 Search by name, email, phone, or application number..."
                                class="w-full pl-12 pr-4 py-3 border-2 border-slate-300 rounded-lg shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <select id="statusFilter"
                            class="px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition text-sm md:w-auto whitespace-nowrap">
                            <option value="">All Statuses</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto ">
                    <table id="applicantTable" class="w-full text-sm mb-5 text-slate-700 divide-y divide-slate-200">
                        <!-- Table Header -->
                        <thead
                            class="bg-gradient-to-r from-blue-100 to-blue-50 border-b-2 border-blue-300 text-slate-700 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-center w-12">#</th>
                                <th class="px-6 py-4 text-left">Full Name</th>
                                <th class="px-6 py-4 text-left">Email Address</th>
                                <th class="px-6 py-4 text-center">Phone Number</th>
                                <th class="px-6 py-4 text-center">Account Status</th>
                                <th class="px-6 py-4 text-center">Registered Date</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($records as $index => $record)
                                <tr class="transition-colors duration-200 group">
                                    <!-- Row Number -->
                                    <td
                                        class="px-6 py-4 text-center font-semibold text-slate-700 group-hover:text-blue-600">
                                        {{ $index + 1 }}
                                    </td>

                                    <!-- Full Name -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 flex items-center justify-center text-white font-bold text-sm">
                                                {{ substr($record->first_name ?? 'A', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $record->first_name }}
                                                    {{ $record->last_name }}</p>
                                                <p class="text-xs text-slate-500">Applicant ID: #{{ $record->id }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-slate-700">{{ $record->email }}</span>
                                        </div>
                                    </td>

                                    <!-- Phone -->
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex items-center justify-center gap-2 text-slate-700">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $record->phone ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <!-- Account Status -->
                                    <td class="px-6 py-5 text-center">
                                        <span
                                            class="px-3 py-1.5 rounded-full text-sm font-semibold inline-block
                                            @if ($record->pre_registration_status === 'approved') bg-blue-100 text-blue-700
                                            @elseif($record->pre_registration_status === 'pending')
                                                bg-yellow-100 text-yellow-700
                                            @elseif($record->pre_registration_status === 'rejected')
                                                bg-cyan-100 text-cyan-700
                                            @else
                                                bg-slate-100 text-slate-700 @endif
                                        ">
                                            @if ($record->pre_registration_status === 'approved')
                                                ✓ Approved
                                            @elseif($record->pre_registration_status === 'pending')
                                                ⏳ Pending
                                            @elseif($record->pre_registration_status === 'rejected')
                                                ✗ Rejected
                                            @else
                                                {{ ucfirst($record->pre_registration_status ?? 'Unknown') }}
                                            @endif
                                        </span>
                                    </td>

                                    <!-- Registered Date -->
                                    <td class="px-6 py-5 text-center text-slate-700 text-sm">
                                        {{ $record->created_at ? $record->created_at->format('M d, Y') : 'N/A' }}
                                    </td>

                                    <!-- Action Buttons -->
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center items-center gap-3">
                                            <!-- View Button -->
                                            <a href="{{ route('obo.obo.view_applicant_records', $record->id) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-200"
                                                title="View Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <!-- Edit Button -->
                                          
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-slate-300 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="text-slate-500 text-lg font-medium">No applicant records found</p>
                                            <p class="text-slate-400 text-sm">Try adjusting your filters or search criteria
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>

        </div>
    </div>

    <script src="{{ asset('asset/js/buildingRecordFilter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
