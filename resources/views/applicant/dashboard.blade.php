@extends('layout.applicant.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white rounded-xl max-w-10xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 px-4 sm:px-8">
            <!-- Left Section: "Lagonoy System" Title -->
            <div class="flex-shrink-0 text-center sm:text-left w-full sm:w-auto">
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-700">Lagonoy Building Permit System</h1>
            </div>

            <!-- Center Section: Search Bar -->
            <div x-data="searchApplications()" class="relative w-full sm:w-1/2 max-w-3xl mx-4 sm:mx-8">
                <!-- Search Input -->
                <input type="text" placeholder="Search applications..." x-model="query"
                    @input.debounce.300ms="filterApplications"
                    class="w-full pl-10 pr-4 py-2.5 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-1 text-sm sm:text-base placeholder-gray-400" />
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <!-- Dropdown Results -->
                <div x-show="query.length > 0" x-transition
                    class="absolute mt-1 w-full bg-white shadow-lg rounded-lg max-h-60 overflow-y-auto z-50">
                    <!-- Show "No record found" when there are no filtered results -->
                    <template x-if="filtered.length === 0">
                        <p class="text-red-500 px-4 py-2">No record found</p>
                    </template>

                    <!-- Results Loop -->
                    <template x-for="item in filtered" :key="item.id">
                        <div class="px-4 py-2 hover:bg-red-50 cursor-pointer rounded-lg" @click="selectApplication(item)">
                            <p class="text-sm font-semibold text-red-700" x-text="getApplicationTitle(item)">
                            </p>
                            <p class="text-xs text-gray-500" x-text="item.application_no"></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Right Section: Notifications + Profile -->
            <div class="flex items-center gap-4 w-full sm:w-auto mt-4 sm:mt-0">
                <!-- Notification Bell -->
                <div x-data="{ open: false }" class="relative w-max">
                    <!-- Bell Icon -->
                    <button @click="open = !open"
                        class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow hover:bg-gray-50 transition duration-200 relative">
                        <i class="fas fa-bell text-gray-600 text-lg"></i>
                        <span
                            class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full">
                            3
                        </span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute top-full right-0 mt-2 w-[90vw] sm:w-80 bg-white rounded-xl shadow-2xl z-50">

                        <!-- Header -->
                        <div class="flex justify-between items-center px-4 py-3 bg-red-50 rounded-t-xl">
                            <h3 class="text-sm font-semibold text-red-700">Notifications</h3>
                            <button class="text-xs text-red-500 hover:underline">Mark all as read</button>
                        </div>

                        <!-- Scrollable List -->
                        <div
                            class="max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-red-300 scrollbar-track-red-100 hover:scrollbar-thumb-red-400 transition-all duration-200">
                            @for ($i = 1; $i <= 5; $i++)
                                <div
                                    class="flex items-start gap-3 p-3 hover:bg-red-50 transition-all duration-200 rounded-lg cursor-pointer">
                                    <div
                                        class="w-10 h-10 flex items-center justify-center bg-red-100 text-red-600 rounded-full flex-shrink-0 mt-0.5">
                                        <i class="fas fa-bell text-base"></i>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <p class="text-sm text-gray-700 leading-snug">
                                            <span class="font-semibold">Admin</span> posted a new announcement about system
                                            updates.
                                        </p>
                                        <span class="text-xs text-gray-400 mt-1 block">5 mins ago</span>
                                    </div>
                                </div>
                                <div
                                    class="flex items-start gap-3 p-3 hover:bg-yellow-50 transition-all duration-200 rounded-lg cursor-pointer">
                                    <div
                                        class="w-10 h-10 flex items-center justify-center bg-yellow-100 text-yellow-600 rounded-full flex-shrink-0 mt-0.5">
                                        <i class="fas fa-exclamation-triangle text-base"></i>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <p class="text-sm text-gray-700 leading-snug">
                                            <span class="font-semibold">System</span> warning: maintenance scheduled for
                                            tonight.
                                        </p>
                                        <span class="text-xs text-gray-400 mt-1 block">1 hour ago</span>
                                    </div>
                                </div>
                                <div
                                    class="flex items-start gap-3 p-3 hover:bg-green-50 transition-all duration-200 rounded-lg cursor-pointer">
                                    <div
                                        class="w-10 h-10 flex items-center justify-center bg-green-100 text-green-600 rounded-full flex-shrink-0 mt-0.5">
                                        <i class="fas fa-check-circle text-base"></i>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <p class="text-sm text-gray-700 leading-snug">
                                            <span class="font-semibold">System</span> update completed successfully.
                                        </p>
                                        <span class="text-xs text-gray-400 mt-1 block">2 hours ago</span>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Footer -->
                        <div class="text-center py-2">
                            <a href="#" class="text-sm text-red-600 hover:underline font-medium">View all
                                notifications</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Icon -->
                <div
                    class="flex items-center gap-2 bg-white rounded-full px-3 py-1.5 shadow-sm hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-user-circle text-red-600 text-xl"></i>
                    <span class="text-sm font-semibold text-gray-700 hidden sm:block">
                        {{ ucwords(Auth::user()->first_name) }}
                    </span>
                </div>
            </div>
        </div>






        <!-- Top Section: Welcome + Announcement/Updates -->
        <div class="flex flex-col lg:flex-row gap-4 w-full">

            <div class="flex flex-col lg:flex-row gap-6 w-full">
                <div class="flex flex-col lg:flex-row gap-6 w-full items-stretch">
                    <!-- LEFT: Welcome Card -->
                    <div
                        class="relative lg:w-2/3 w-full rounded-2xl overflow-hidden bg-gradient-to-br from-red-50 via-pink-100 to-red-200 shadow-lg p-6 sm:p-8 lg:p-10 flex flex-col lg:flex-row items-center justify-between gap-6 border border-red-100">

                        <div class="relative z-10 flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center bg-white/70 backdrop-blur-sm rounded-full shadow-md border border-red-200">
                                    <i class="fas fa-user-circle text-red-600 text-2xl sm:text-3xl"></i>
                                </div>
                                <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-red-800 tracking-tight">
                                    Welcome, {{ ucwords(Auth::user()->first_name) }}!
                                </h2>
                            </div>

                            <p class="text-gray-700 text-sm sm:text-base max-w-xl leading-relaxed">
                                We’re glad to have you back! You can now continue managing your applications, check their
                                statuses, or explore new services available to you.
                            </p>

                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="{{ route('applicant.forms.obo.buidlingPermitForm') }}"
                                    class="bg-red-600 text-white text-sm font-medium px-4 sm:px-5 py-2.5 rounded-lg shadow hover:bg-red-700 transition-all duration-200">
                                    <i class="fas fa-building mr-2"></i> Apply Building Permit
                                </a>

                                <a href="{{ route('applicant.forms.zoning.zoning_form') }}"
                                    class="bg-red-600 text-white text-sm font-medium px-4 sm:px-5 py-2.5 rounded-lg shadow hover:bg-red-700 transition-all duration-200">
                                    <i class="fas fa-location mr-2"></i> Apply Zoning Permit
                                </a>
                                <a href="{{ route('sanitary.forms.sanitary.sanitary_form') }}"
                                    class="bg-red-600 text-white text-sm font-medium px-4 sm:px-5 py-2.5 rounded-lg shadow hover:bg-red-700 transition-all duration-200">
                                    <i class="fas fa-faucet mr-2"></i> Apply Sanitary Permit
                                </a>
                                {{-- <a href="#"
                                    class="bg-white text-red-700 border border-red-300 text-sm font-medium px-4 sm:px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-50 transition-all duration-200">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a> --}}
                            </div>
                        </div>

                        <div class="hidden lg:block relative flex-shrink-0">
                            <img src="{{ asset('asset/img/welcome.png') }}" alt="Welcome Illustration"
                                class="w-52 xl:w-60 opacity-90 drop-shadow-md hover:scale-105 transition-transform duration-300">
                        </div>

                        <!-- Decorative Overlays -->
                        <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-red-100/30 pointer-events-none">
                        </div>
                        <div
                            class="absolute -bottom-10 -right-10 w-32 sm:w-40 h-32 sm:h-40 bg-red-300/20 rounded-full blur-3xl">
                        </div>
                        <div
                            class="absolute -top-10 -left-10 w-32 sm:w-40 h-32 sm:h-40 bg-pink-200/30 rounded-full blur-3xl">
                        </div>
                    </div>

                    <!-- RIGHT: Short Scrollable Announcements -->
                    <div
                        class="lg:w-1/3 w-full bg-gradient-to-br from-rose-50 via-white to-red-50 border border-red-100 rounded-2xl shadow-md p-5 sm:p-6 flex flex-col text-center hover:shadow-lg transition-shadow duration-300">

                        <!-- Header -->
                        <div class="flex items-center justify-center gap-2 mb-3">
                            <div
                                class="w-10 h-10 sm:w-11 sm:h-11 flex items-center justify-center bg-red-100 text-red-600 rounded-full shadow-sm">
                                <i class="fas fa-bullhorn text-base sm:text-lg"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-semibold text-red-700">Announcements</h3>
                        </div>

                        <!-- Scrollable Content -->
                        <div
                            class="overflow-y-auto flex-1 max-h-[260px] space-y-2 pr-1 scrollbar-thin scrollbar-thumb-rose-300 scrollbar-track-rose-100 hover:scrollbar-thumb-rose-400 transition-all duration-200">

                            @for ($i = 1; $i <= 10; $i++)
                                <div
                                    class="bg-white/80 border border-red-100 rounded-lg p-3 text-left hover:bg-rose-50 transition-all duration-200">
                                    <h4 class="font-semibold text-red-700 text-sm mb-1">Announcement #{{ $i }}
                                    </h4>
                                    <p class="text-gray-700 text-sm leading-snug">
                                        This is a sample announcement number {{ $i }} for testing shorter layout
                                        behavior.
                                    </p>
                                    <span class="text-xs text-gray-400 mt-1 block">{{ $i }} hrs ago</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>




            </div>

            {{-- <!-- Notification Center -->
            <div
                class="bg-gradient-to-br from-gray-50 via-white to-gray-100 border border-gray-200 rounded-2xl shadow-md p-6 flex flex-col justify-between min-h-[250px] sm:min-h-[300px] max-h-[400px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-bell text-yellow-500"></i>
                        Notifications
                    </h3>
                    <button class="text-xs sm:text-sm text-blue-600 hover:text-blue-800 transition-all duration-200">
                        Mark all as read
                    </button>
                </div>

                <!-- Notification List (scrollable area) -->
                <div
                    class="overflow-y-auto flex-1 space-y-3 pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 hover:scrollbar-thumb-gray-400 transition-all duration-200">

                    <!-- Notification Item 1 -->
                    <div
                        class="flex items-start gap-3 bg-white/80 hover:bg-gray-50 border border-gray-200 rounded-xl p-3 transition-all duration-200">
                        <div
                            class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-yellow-100 text-yellow-600 rounded-full">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-700 text-sm leading-snug">
                                <strong>System Maintenance</strong> scheduled for <strong>Oct 28, 2025</strong>.
                            </p>
                            <span class="text-xs text-gray-400 mt-1 block">5 mins ago</span>
                        </div>
                        <div class="w-3 h-3 bg-red-500 rounded-full mt-1"></div>
                    </div>

                    <!-- Notification Item 2 -->
                    <div
                        class="flex items-start gap-3 bg-white/80 hover:bg-gray-50 border border-gray-200 rounded-xl p-3 transition-all duration-200">
                        <div
                            class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-700 text-sm leading-snug">
                                Your <strong>Building Permit</strong> has been approved.
                            </p>
                            <span class="text-xs text-gray-400 mt-1 block">2 hours ago</span>
                        </div>
                    </div>

                    <!-- Notification Item 3 -->
                    <div
                        class="flex items-start gap-3 bg-white/80 hover:bg-gray-50 border border-gray-200 rounded-xl p-3 transition-all duration-200">
                        <div
                            class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-700 text-sm leading-snug">
                                A new feature has been added to your applicant dashboard.
                            </p>
                            <span class="text-xs text-gray-400 mt-1 block">1 day ago</span>
                        </div>
                    </div>

                    <!-- Example of many notifications -->
                    @for ($i = 1; $i <= 10; $i++)
                        <div
                            class="flex items-start gap-3 bg-white/80 hover:bg-gray-50 border border-gray-200 rounded-xl p-3 transition-all duration-200">
                            <div
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-red-100 text-red-600 rounded-full">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-700 text-sm leading-snug">
                                    Sample notification #{{ $i }} — new message from LGU office.
                                </p>
                                <span class="text-xs text-gray-400 mt-1 block">{{ $i }} hours ago</span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div> --}}

        </div>

        <!-- Application Overview Section -->
        <div class="mt-10 bg-white rounded-2xl shadow-md border border-red-100 p-5 sm:p-6 lg:p-8">
            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-red-700 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-red-600 text-base sm:text-xl"></i>
                Your Application Overview
            </h3>

            <p class="text-gray-600 text-sm sm:text-base mb-6">
                Here’s a quick snapshot of your current applications and their progress. Stay updated on approvals,
                pending actions, and new announcements.
            </p>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Total Applications -->
                <div class="flex items-center gap-4 bg-red-50 rounded-xl p-5 shadow-sm border border-red-100">
                    <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                        <i class="fas fa-folder-open text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Applications</p>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $applications->count() }}</h3>
                    </div>
                </div>

                <!-- Approved -->
                <div class="flex items-center gap-4 bg-green-50 rounded-xl p-5 shadow-sm border border-green-100">
                    <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Approved</p>
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $applications->where('status', 'approved')->count() }}</h3>
                    </div>
                </div>

                <!-- Under Review -->
                <div class="flex items-center gap-4 bg-blue-50 rounded-xl p-5 shadow-sm border border-blue-100">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Under Review</p>
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $applications->where('status', 'under_review')->count() }}</h3>
                    </div>
                </div>

                <!-- Disapproved -->
                <div class="flex items-center gap-4 bg-red-50 rounded-xl p-5 shadow-sm border border-red-100">
                    <div class="p-3 bg-red-200 text-red-700 rounded-lg">
                        <i class="fas fa-times-circle text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Disapproved</p>
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $applications->where('status', 'disapproved')->count() }}</h3>
                    </div>
                </div>
            </div>

            <!-- Quick Tip -->
            <div
                class="mt-6 bg-red-50 border border-red-100 text-sm text-gray-600 p-4 rounded-lg flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <i class="fas fa-info-circle text-red-500 text-lg"></i>
                <p class="leading-relaxed">
                    Tip: You can click on each application in your dashboard to view detailed progress and upload additional
                    documents if needed.
                </p>
            </div>
        </div>
    </div>
    <script>
        function searchApplications() {
            return {
                query: '',
                filtered: [],
                getApplicationTitle(item) {
                    if (item.application_no.startsWith('BLDGP')) {
                        return 'Building Permit applications';
                    } else if (item.application_no.startsWith('ZN')) {
                        return 'Zoning applications';
                    } else if (item.application_no.startsWith('SNT')) {
                        return 'Sanitary applications';
                    } else {
                        return item.title; // Default title if no prefix matches
                    }
                },
                // This function filters applications based on the query
                async filterApplications() {
                    if (this.query.length < 1) {
                        this.filtered = []; // Clear filtered list if query is empty
                        return;
                    }

                    try {
                        // API request to fetch the filtered applications based on the query
                        const res = await fetch(`/search-applications?query=${this.query}`);
                        const data = await res.json();

                        // Update the filtered list with the response data
                        this.filtered = data;

                        // Handle the case where no results are found (empty list)
                        if (data.length === 0) {
                            this.filtered = []; // You can also set a flag to show "No record found" text
                        }
                    } catch (error) {
                        console.error('Search error:', error);
                        this.filtered = []; // Clear filtered results in case of an error
                    }
                },

                // This function handles the selection of an application
                selectApplication(item) {
                    // Example condition based on application_no prefix
                    if (item.application_no.startsWith('BLDGP')) {
                        // Redirect to Building Permit application details page
                        window.location.href = `/applicant/building_permit/view_application/${item.id}`;
                    } else if (item.application_no.startsWith('ZN')) {
                        // Redirect to Zoning application details page
                        window.location.href = `/applicant/zoning/view_application/${item.id}`;
                    } else if (item.application_no.startsWith('SNT')) {
                        // Redirect to Sanitary application details page
                        window.location.href = `/applicant/sanitary/view_application/${item.id}`;
                    } else {
                        // Default redirect (for other types)
                        window.location.href = `/applications/${item.id}`;
                    }
                }

            };
        }
    </script>
@endsection
