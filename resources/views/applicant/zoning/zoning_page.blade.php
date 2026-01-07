@extends('layout.applicant.app')

@section('title', 'Zoning Applications')

@section('content')
    <div x-data="{ open: false }" class="bg-white rounded-xl max-w-10xl mx-auto px-6 py-8">

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

        <div class="bg-gray-100 p-4 sm:p-6 lg:p-10">
            <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">

                <!-- Header Section -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-center px-6 py-6 border-b border-gray-200 gap-4">
                    <div class="w-full sm:w-1/2">
                        <h1 class="text-xl font-semibold text-gray-800">Zoning Applications</h1>
                        <p class="text-sm text-gray-500">Manage your zoning permit applications.</p>
                    </div>

                    <div class="w-full sm:w-1/2 flex flex-col sm:flex-row justify-end items-center gap-3">
                        <!-- Search -->
                        <div class="relative w-full sm:w-3/4"> <!-- ⬅ made wider here -->
                            <input type="search" id="customSearch" placeholder="Search applications..."
                                class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:ring-2 focus:ring-red-500 focus:outline-none transition">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <!-- Create Button -->
                        <button @click="open = true"
                            class="w-full sm:w-auto px-5 py-3 border border-red-500 bg-red-500 text-white rounded-lg text-sm shadow-md flex items-center justify-center gap-2 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Application
                        </button>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-gray-50 p-4 sm:p-6 overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700" id="example">
                        <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-center w-10 !font-bold">#</th>
                                <th class="px-6 py-3 text-center !font-bold">Application ID</th>
                                <th class="px-6 py-3 text-center !font-bold">Date Submitted</th>
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
                                            class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full {{ $status['bg'] }} {{ $status['text'] }}">
                                            <i class="{{ $status['icon'] }}"></i>
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>

                                    <!-- Action -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('applicant.zoning.zoning_application_view', $application->id) }}"
                                                class="inline-flex items-center gap-2 px-3 py-1 border border-blue-500 text-blue-600 text-sm rounded-lg hover:bg-blue-500 hover:text-white transition">
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

    <script src="{{ asset('asset/js/datatable.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
