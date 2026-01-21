@extends('layout.applicant.app')

@section('title', 'Building Applications')

@section('content')
    <div x-data="{ open: false }" class="max-w-10xl bg-white rounded-xl mx-auto px-6 py-8">
        {{-- Banner for accounts still under review --}}
        <!-- Verification Alert -->
        @if (Auth::check() && Auth::user()->pre_registration_status === 'pending')
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-5 mb-6 shadow-sm">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-amber-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-amber-900 mb-1">Account Under Review</h4>
                            <p class="text-sm text-amber-700 leading-relaxed">
                                Your account is being verified by the <span class="font-semibold">Office of the Building
                                    Official (OBO)</span>. You'll be notified once approved.
                            </p>
                        </div>
                    </div>
                    <a href="#"
                        class="inline-flex items-center justify-center bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors whitespace-nowrap">
                        Contact Support
                    </a>
                </div>
            </div>
        @elseif (Auth::check() && Auth::user()->pre_registration_status === 'rejected')
            <div class="bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-2xl p-5 mb-6 shadow-sm">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-red-900 mb-1">Application Rejected</h4>
                            <p class="text-sm text-red-700 leading-relaxed">
                                Your application was rejected. <span class="font-semibold">Reason:</span>
                                <span class="block mt-1">{{ $applicationValidationReason ?? 'No reason provided' }}</span>
                            </p>
                        </div>
                    </div>
                    <a href="#"
                        class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors whitespace-nowrap">
                        Resubmit Application
                    </a>
                </div>
            </div>
        @endif


        <div
            class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-blue-50 via-indigo-100 to-blue-200 shadow-lg mb-6 p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6 border border-blue-100">

            <!-- Left Section -->
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-14 h-14 flex items-center justify-center bg-white/70 backdrop-blur-sm rounded-full shadow-md border border-blue-200">
                        <i class="fas fa-building text-blue-600 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-blue-800 tracking-tight">
                        Building Application Details
                    </h2>
                </div>
                <p class="text-gray-700 text-sm md:text-base max-w-xl leading-relaxed">
                    Review all submitted information, supporting documents, and monitor the current status of your
                    building
                    permit application.
                </p>
            </div>

            <!-- Right Decorative Illustration -->
            <div class="hidden md:block relative">
                <img src="{{ asset('asset/img/architecture-and-city.png') }}" alt="Building Illustration"
                    class="w-32 opacity-90 drop-shadow-md hover:scale-105 transition-transform duration-300">
            </div>

            <!-- Decorative Overlays -->
            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-blue-200/40 pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-300/20 rounded-full blur-3xl"></div>
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-200/30 rounded-full blur-3xl"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total -->
            <div
                class="flex items-center gap-4 bg-blue-50 rounded-xl p-5 shadow-sm border border-blue-100 hover:shadow-md transition-shadow">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Applications</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $applications->count() }}</h3>
                </div>
            </div>

            <!-- Approved -->
            <div
                class="flex items-center gap-4 bg-green-50 rounded-xl p-5 shadow-sm border border-green-100 hover:shadow-md transition-shadow">
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
            <div
                class="flex items-center gap-4 bg-red-50 rounded-xl p-5 shadow-sm border border-red-100 hover:shadow-md transition-shadow">
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
            <div
                class="flex items-center gap-4 bg-amber-50 rounded-xl p-5 shadow-sm border border-amber-100 hover:shadow-md transition-shadow">
                <div class="p-3 bg-amber-100 text-amber-600 rounded-lg">
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

        <div class="bg-gradient-to-br from-gray-50 to-blue-50 p-4 sm:p-6 lg:p-10 rounded-xl">
            <div class="bg-white shadow-xl rounded-xl border border-blue-100 overflow-hidden">

                <!-- Header Section -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-center px-6 py-6 bg-gradient-to-r from-blue-500 to-indigo-600 gap-4">

                    <!-- Title -->
                    <div class="w-full sm:w-1/2">
                        <h1 class="text-xl font-semibold text-white">Building Applications</h1>
                        <p class="text-sm text-blue-100">Manage your building permit applications.</p>
                    </div>

                    <!-- Search + Button -->
                    <div class="w-full sm:w-1/2 flex flex-col sm:flex-row justify-end items-center gap-3">

                        <!-- Search -->
                        <div class="relative w-full sm:w-3/4">
                            <input type="search" id="customSearch" placeholder="Search applications..."
                                class="w-full pl-10 pr-4 py-3 border border-blue-200 rounded-lg shadow-sm text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition bg-white">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-blue-400"></i>
                        </div>

                        <!-- New Application Button -->
                        <a href="{{ route('applicant.forms.obo.buidlingPermitForm') }}"
                            @if (in_array(Auth::user()->pre_registration_status, ['pending', 'rejected'])) aria-disabled="true"
                class="flex items-center justify-center px-4 py-2 text-xs bg-gray-400 text-white rounded-md shadow-md cursor-not-allowed opacity-70"
            @else
                @click="open = true"
                class="flex items-center justify-center px-4 py-2 text-sm bg-white text-blue-600 hover:bg-blue-50 rounded-md shadow-md font-medium transition-all hover:shadow-lg" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="hidden sm:inline">New Application</span>
                        </a>

                    </div>
                </div>


                <!-- Table Section -->
                <div class="bg-white p-4 sm:p-6 overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700" id="example">
                        <thead
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b-2 border-blue-200 text-blue-800 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-center w-10 !font-bold">#</th>
                                <th class="px-6 py-4 text-center !font-bold">Application ID</th>
                                <th class="px-6 py-4 text-center !font-bold">Date Submitted</th>
                                <th class="px-6 py-4 text-center !font-bold">Status</th>
                                <th class="px-6 py-4 text-center !font-bold">Action</th>
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
                                            <i class="fas fa-file-alt text-blue-600 bg-blue-100 p-1.5 rounded-md"></i>
                                            <span class="text-gray-800">{{ $application->application_no }}</span>
                                        </div>
                                    </td>

                                    <!-- Date -->
                                    <td class="px-6 py-4 text-center text-gray-700">
                                        <div class="flex items-center justify-center gap-2">
                                            <i
                                                class="fas fa-calendar-alt text-indigo-500 bg-indigo-100 p-1.5 rounded-md"></i>
                                            <span class="text-gray-700">
                                                {{ $application->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </td>

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
                                            class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold rounded-full {{ $status['bg'] }} {{ $status['text'] }} shadow-sm">
                                            <i class="{{ $status['icon'] }}"></i>
                                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                        </span>

                                    </td>

                                    <!-- Action -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('applicant.obo.building_application_view', $application->id) }}"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        {{-- <div x-show="open" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm">
            <div @click.away="open = false"
                class="bg-white rounded-xl m-5 shadow-2xl max-w-lg w-full p-6 relative transform transition-all border border-blue-100">
                <!-- Close Button -->
                <button @click="open = false"
                    class="absolute top-3 right-3 text-gray-400 hover:text-blue-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
                <!-- Modal Content -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-blue-800">Data Privacy Notice</h2>
                </div>
                <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                    By creating a new application, you agree to the collection and processing of your personal data in
                    compliance with the Data Privacy Act. Your information will only be used for building application
                    purposes and will be kept strictly confidential.
                </p>
                <div class="flex justify-end gap-3">
                    <button @click="open = false"
                        class="px-5 py-2.5 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                        Cancel
                    </button>
                    <a href="{{ route('applicant.forms.obo.buidlingPermitForm') }}"
                        onclick="event.preventDefault(); localStorage.clear(); window.location.href=this.href;"
                        class="px-5 py-2.5 text-sm bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-lg font-medium transition-all shadow-md hover:shadow-lg">
                        I Agree
                    </a>
                </div>
            </div>
        </div> --}}

    </div>
    <script src="{{ asset('asset/js/datatable.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">

@endsection
