@extends('layout.applicant.app')

@section('title', 'Applicant | Dashboard')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">
        <div class="w-full px-6 lg:px-8 xl:px-12 py-6 sm:py-8">

            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6 mb-6">
                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

                    <!-- System Title -->
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg overflow-hidden">
                            <img src="{{ asset('asset/icon/logo.png') }}" alt="Building Icon" class="w-12 h-12 object-contain">
                        </div>

                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">Lagonoy Building Permit System</h1>
                            <p class="text-sm text-slate-500">Lagonoy Municipal Office</p>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div x-data="searchApplications()" class="relative flex-1 max-w-2xl xl:max-w-3xl">
                        <input type="text" placeholder="Search applications by number or type..." x-model="query"
                            @input.debounce.300ms="filterApplications"
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm shadow-sm transition-all" />
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                        <!-- Search Results Dropdown -->
                        <div x-show="query.length > 0" x-transition
                            class="absolute mt-2 w-full bg-white shadow-xl rounded-xl max-h-72 overflow-y-auto z-50 border border-slate-200">

                            <template x-if="filtered.length === 0">
                                <div class="text-center py-8 px-4">
                                    <div
                                        class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-folder-open text-3xl text-slate-400"></i>
                                    </div>
                                    <p class="text-base font-semibold text-slate-700 mb-1">No records found</p>
                                    <p class="text-sm text-slate-500">Try adjusting your search terms</p>
                                </div>
                            </template>

                            <template x-for="item in filtered" :key="item.id">
                                <div class="px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors border-b border-slate-100 last:border-0"
                                    @click="selectApplication(item)">
                                    <p class="text-sm font-semibold text-slate-800" x-text="getApplicationTitle(item)"></p>
                                    <p class="text-xs text-slate-500 mt-0.5" x-text="item.application_no"></p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Right Section: Notifications + Profile -->
                    <div class="flex items-center gap-3">
                        <!-- Notification Bell -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="relative w-11 h-11 flex items-center justify-center bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                                <i class="fas fa-bell text-slate-600 text-lg"></i>
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full">3</span>
                            </button>

                            <!-- Notification Dropdown -->
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute top-full right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 z-50">

                                <div class="flex justify-between items-center px-5 py-4 border-b border-slate-200">
                                    <h3 class="text-base font-semibold text-slate-800">Notifications</h3>
                                    <button class="text-xs text-blue-600 hover:text-blue-700 font-medium">Mark all
                                        read</button>
                                </div>

                                <div class="max-h-96 overflow-y-auto">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div
                                            class="flex items-start gap-3 p-4 hover:bg-slate-50 transition-colors border-b border-slate-100 last:border-0">
                                            <div
                                                class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-xl flex-shrink-0">
                                                <i class="fas fa-bell text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm text-slate-700 leading-relaxed">
                                                    <span class="font-semibold">Admin</span> posted a new announcement about
                                                    system updates.
                                                </p>
                                                <span class="text-xs text-slate-400 mt-1 block">5 mins ago</span>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                                <div class="text-center py-3 border-t border-slate-200">
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all
                                        notifications</a>
                                </div>
                            </div>
                        </div>

                        <!-- Profile -->
                        {{-- <div
                            class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 rounded-xl px-4 py-2.5 transition-colors cursor-pointer">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 hidden sm:block">
                                {{ ucwords(Auth::user()->first_name) }}
                            </span>
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Verification Alert -->
            @if (Auth::check() && Auth::user()->pre_registration_status === 'pending')
                <!-- PENDING BANNER -->
                <div
                    class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-5 mb-6 shadow-sm">
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

                <!-- PENDING MODAL -->
                @if (session('show_pending_modal'))
                    <div x-data="{ open: !localStorage.getItem('pending_modal_dismissed') }" x-show="open" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gradient-to-br from-slate-900/40 via-slate-800/30 to-slate-900/40 backdrop-blur-sm flex items-center justify-center z-50">

                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4">

                            <!-- Loading Animation SVG -->
                            <div class="flex justify-center mb-6">
                                <div class="relative w-32 h-32">
                                    <!-- Outer circle with spinning animation -->
                                    <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        style="animation: spin 3s linear infinite;">
                                        <!-- Face background -->
                                        <circle cx="50" cy="50" r="45" fill="#FEF3C7" stroke="#F59E0B"
                                            stroke-width="2" />

                                        <!-- Left eye -->
                                        <circle cx="35" cy="40" r="6" fill="#F59E0B" />
                                        <circle cx="35" cy="40" r="3" fill="white" opacity="0.6" />

                                        <!-- Right eye -->
                                        <circle cx="65" cy="40" r="6" fill="#F59E0B" />
                                        <circle cx="65" cy="40" r="3" fill="white" opacity="0.6" />

                                        <!-- Neutral mouth -->
                                        <path d="M 35 65 L 65 65" stroke="#F59E0B" stroke-width="2.5" fill="none"
                                            stroke-linecap="round" />
                                    </svg>

                                    <!-- Animated clock overlay -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <i class="fa-solid fa-hourglass-half text-amber-600 text-5xl"
                                            style="animation: bounce 2s infinite;"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Header -->
                            <div class="text-center mb-4">
                                <h2 class="text-2xl font-bold text-amber-600 mb-2">
                                    Account Under Review
                                </h2>
                                <p class="text-sm text-gray-500">Your application is being processed.</p>
                            </div>

                            <!-- Info Message -->
                            <div class="bg-amber-50 border-l-4 border-amber-600 rounded-lg p-4 mb-6">
                                <p class="text-sm text-gray-600 mb-2 font-semibold">What's Next:</p>
                                <p class="text-gray-800 font-medium leading-relaxed">
                                    Your account is being verified by the Office of the Building Official (OBO). This
                                    process typically takes 3-5 business days. We'll send you an email notification once
                                    your account has been reviewed.
                                </p>
                            </div>

                            <!-- Info Message -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-6">
                                <p class="text-xs text-blue-800">
                                    <i class="fa-solid fa-info-circle mr-2"></i>
                                    Need help? Contact our support team for more information.
                                </p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex flex-col gap-3 justify-center sm:justify-end">
                                <div class="flex gap-3">
                                    <button @click="open = false"
                                        class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 
                        font-semibold text-sm transition-all duration-200">
                                        Close
                                    </button>
                                    <a href="#"
                                        class="px-5 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 
                        font-semibold text-sm transition-all duration-200 inline-flex items-center gap-2">
                                        <i class="fa-solid fa-headset"></i> Contact Support
                                    </a>
                                </div>
                                <label
                                    class="flex items-center gap-2 text-xs text-gray-600 cursor-pointer hover:text-gray-800">
                                    <input type="checkbox"
                                        @change="localStorage.setItem('pending_modal_dismissed', $el.checked)"
                                        class="rounded">
                                    <span>Don't show this again</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <style>
                        @keyframes spin {
                            0% {
                                transform: rotate(0deg);
                            }

                            100% {
                                transform: rotate(360deg);
                            }
                        }

                        @keyframes bounce {

                            0%,
                            100% {
                                transform: translateY(0);
                            }

                            50% {
                                transform: translateY(-10px);
                            }
                        }
                    </style>
                @endif
            @elseif (Auth::check() && Auth::user()->pre_registration_status === 'rejected')
                <!-- REJECTED BANNER -->
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
                                    <span
                                        class="block mt-1">{{ Auth::user()->rejection_reason ?? 'No reason provided' }}</span>
                                </p>
                            </div>
                        </div>
                        <a href="#"
                            class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors whitespace-nowrap">
                            Resubmit Application
                        </a>
                    </div>
                </div>

                <!-- REJECTED MODAL -->
                @if (session('show_rejected_modal'))
                    <div x-data="{ open: !localStorage.getItem('rejected_modal_dismissed') }" x-show="open" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gradient-to-br from-slate-900/40 via-slate-800/30 to-slate-900/40 backdrop-blur-sm flex items-center justify-center z-50">

                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4">

                            <!-- Sad Animation SVG -->
                            <div class="flex justify-center mb-6">
                                <div class="relative w-32 h-32">
                                    <!-- Outer circle -->
                                    <svg class="w-full h-full animate-pulse" viewBox="0 0 100 100"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <!-- Face background -->
                                        <circle cx="50" cy="50" r="45" fill="#FEE2E2" stroke="#DC2626"
                                            stroke-width="2" />

                                        <!-- Left eye -->
                                        <circle cx="35" cy="40" r="6" fill="#DC2626" />
                                        <circle cx="35" cy="40" r="3" fill="white" opacity="0.6" />

                                        <!-- Right eye -->
                                        <circle cx="65" cy="40" r="6" fill="#DC2626" />
                                        <circle cx="65" cy="40" r="3" fill="white" opacity="0.6" />

                                        <!-- Tear left -->
                                        <ellipse cx="35" cy="48" rx="2.5" ry="5"
                                            fill="#93C5FD" opacity="0.7" />

                                        <!-- Tear right -->
                                        <ellipse cx="65" cy="48" rx="2.5" ry="5"
                                            fill="#93C5FD" opacity="0.7" />

                                        <!-- Sad mouth -->
                                        <path d="M 35 65 Q 50 58 65 65" stroke="#DC2626" stroke-width="2.5"
                                            fill="none" stroke-linecap="round" />
                                    </svg>

                                    <!-- Animated X mark overlay -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="animate-bounce" style="animation: bounce 2s infinite; opacity: 0.8;">
                                            <i class="fa-solid fa-times-circle text-red-600 text-5xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Header -->
                            <div class="text-center mb-4">
                                <h2 class="text-2xl font-bold text-red-600 mb-2">
                                    Application Rejected
                                </h2>
                                <p class="text-sm text-gray-500">Unfortunately, your application could not be approved.</p>
                            </div>

                            <!-- Reason Box -->
                            <div class="bg-red-50 border-l-4 border-red-600 rounded-lg p-4 mb-6">
                                <p class="text-sm text-gray-600 mb-2 font-semibold">Reason for Rejection:</p>
                                <p class="text-gray-800 font-medium leading-relaxed">
                                    {{ Auth::user()->rejection_reason ?? 'No reason provided' }}
                                </p>
                            </div>

                            <!-- Info Message -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-6">
                                <p class="text-xs text-blue-800">
                                    <i class="fa-solid fa-info-circle mr-2"></i>
                                    You can resubmit your application after reviewing the requirements.
                                </p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex flex-col gap-3 justify-center sm:justify-end">
                                <div class="flex gap-3">
                                    <button @click="open = false"
                                        class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 
                        font-semibold text-sm transition-all duration-200">
                                        Close
                                    </button>
                                    <a href="#"
                                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 
                        font-semibold text-sm transition-all duration-200 inline-flex items-center gap-2">
                                        <i class="fa-solid fa-arrow-right"></i> Back to Records
                                    </a>
                                </div>
                                <label
                                    class="flex items-center gap-2 text-xs text-gray-600 cursor-pointer hover:text-gray-800">
                                    <input type="checkbox"
                                        @change="localStorage.setItem('rejected_modal_dismissed', $el.checked)"
                                        class="rounded">
                                    <span>Don't show this again</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <style>
                        @keyframes bounce {

                            0%,
                            100% {
                                transform: translateY(0);
                            }

                            50% {
                                transform: translateY(-10px);
                            }
                        }
                    </style>
                @endif
            @elseif (Auth::check() && Auth::user()->pre_registration_status === 'approved')
                <!-- APPROVED MODAL -->
                @if (session('show_approved_modal'))
                    <div x-data="{ open: !localStorage.getItem('approved_modal_dismissed') }" x-show="open" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gradient-to-br from-slate-900/40 via-slate-800/30 to-slate-900/40 backdrop-blur-sm flex items-center justify-center z-50">

                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4">

                            <!-- Happy Animation SVG with Checkmark -->
                            <div class="flex justify-center mb-6">
                                <div class="relative w-32 h-32">
                                    <!-- Outer circle -->
                                    <svg class="w-full h-full animate-pulse" viewBox="0 0 100 100"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <!-- Face background -->
                                        <circle cx="50" cy="50" r="45" fill="#DCFCE7" stroke="#16A34A"
                                            stroke-width="2" />

                                        <!-- Left eye -->
                                        <circle cx="35" cy="40" r="6" fill="#16A34A" />
                                        <circle cx="35" cy="40" r="3" fill="white" opacity="0.6" />

                                        <!-- Right eye -->
                                        <circle cx="65" cy="40" r="6" fill="#16A34A" />
                                        <circle cx="65" cy="40" r="3" fill="white" opacity="0.6" />

                                        <!-- Happy mouth -->
                                        <path d="M 35 62 Q 50 70 65 62" stroke="#16A34A" stroke-width="2.5"
                                            fill="none" stroke-linecap="round" />
                                    </svg>

                                    <!-- Animated Checkmark overlay -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="animate-bounce" style="animation: bounce 2s infinite; opacity: 0.9;">
                                            <i class="fa-solid fa-check-circle text-green-600 text-5xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Header -->
                            <div class="text-center mb-4">
                                <h2 class="text-2xl font-bold text-green-600 mb-2">
                                    Application Approved
                                </h2>
                                <p class="text-sm text-gray-500">Congratulations! Your application has been approved.</p>
                            </div>

                            <!-- Success Message -->
                            <div class="bg-green-50 border-l-4 border-green-600 rounded-lg p-4 mb-6">
                                <p class="text-sm text-gray-600 mb-2 font-semibold">Status:</p>
                                <p class="text-gray-800 font-medium leading-relaxed">
                                    Your application has been successfully approved by the Office of the Building Official
                                    (OBO). You can now proceed with your building project.
                                </p>
                            </div>

                            <!-- Info Message -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-6">
                                <p class="text-xs text-blue-800">
                                    <i class="fa-solid fa-info-circle mr-2"></i>
                                    Your permit has been issued. Please download and keep a copy for your records.
                                </p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex flex-col gap-3 justify-center sm:justify-end">
                                <div class="flex gap-3">
                                    <button @click="open = false"
                                        class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 
                        font-semibold text-sm transition-all duration-200">
                                        Close
                                    </button>
                                    <a href="#"
                                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 
                        font-semibold text-sm transition-all duration-200 inline-flex items-center gap-2">
                                        <i class="fa-solid fa-arrow-right"></i> View Permit
                                    </a>
                                </div>
                                <label
                                    class="flex items-center gap-2 text-xs text-gray-600 cursor-pointer hover:text-gray-800">
                                    <input type="checkbox"
                                        @change="localStorage.setItem('approved_modal_dismissed', $el.checked)"
                                        class="rounded">
                                    <span>Don't show this again</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <style>
                        @keyframes bounce {

                            0%,
                            100% {
                                transform: translateY(0);
                            }

                            50% {
                                transform: translateY(-10px);
                            }
                        }
                    </style>
                @endif

            @endif

            <!-- Welcome Banner -->
            <div
                class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl shadow-xl h-90 p-6 sm:p-8 mb-6 flex items-center overflow-hidden">
                <!-- Decorative Background Elements -->
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-indigo-400/20 rounded-full blur-3xl"></div>

                <!-- Decorative Icons -->
                <div class="absolute top-8 right-32 opacity-10">
                    <i class="fas fa-compass text-white text-6xl"></i>
                </div>
                <div class="absolute top-30 right-12 opacity-10">
                    <i class="fas fa-building text-white text-6xl"></i>
                </div>

                <div class="absolute bottom-8 right-64 opacity-10">
                    <i class="fas fa-user text-white text-5xl"></i>
                </div>

                <div class="absolute bottom-20 right-30 opacity-10">
                    <i class="fas fa-shield text-white text-5xl"></i>
                </div>

                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 w-full">
                    <!-- Welcome Message with Icon -->
                    <div class="flex-1 text-white">
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-xl border border-white/30">
                                <i class="fas fa-user-circle text-3xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl sm:text-4xl font-bold drop-shadow-lg">
                                    Welcome back, {{ ucwords(Auth::user()->first_name) }}!
                                </h2>
                                <p class="text-blue-100 text-sm sm:text-base mt-1">Manage your building permits
                                    efficiently
                                </p>
                            </div>
                        </div>
                        <p class="text-blue-50 text-sm leading-relaxed max-w-2xl mb-5">
                            Track your applications, schedule appointments, and stay updated with your building permit
                            progress all in one place.
                        </p>
                        <a href="{{ route('applicant.buildingPermit') }}"
                            class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-semibold px-6 py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200">
                            <i class="fas fa-plus-circle text-lg"></i>
                            <span>New Application</span>
                        </a>
                        <a href="{{ route('applicant.calendar.schedule') }}"
                            class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white font-semibold px-6 py-3.5 rounded-xl border border-white/30 hover:bg-white/20 transition-all duration-200">
                            <i class="fas fa-calendar-alt text-lg"></i>
                            <span>View Schedule</span>
                        </a>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:flex-shrink-0">

                    </div>
                </div>
            </div>

            <!-- Quick Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                @php
                    $quickStats = [
                        [
                            'icon' => 'fas fa-file-alt',
                            'label' => 'Active Applications',
                            'value' => $activeApplications,
                            'color' => 'blue',
                        ],
                        [
                            'icon' => 'fas fa-check-circle',
                            'label' => 'Approved This Month',
                            'value' => $approvedThisMonth,
                            'color' => 'green',
                        ],
                        [
                            'icon' => 'fas fa-calendar-check',
                            'label' => 'Upcoming Appointments',
                            'value' => '3',
                            'color' => 'purple',
                        ],
                        [
                            'icon' => 'fas fa-clock',
                            'label' => 'Pending Reviews',
                            'value' => $pendingReviews,
                            'color' => 'amber',
                        ],
                    ];
                @endphp

                @foreach ($quickStats as $stat)
                    <div class="bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md transition-all group">
                        <div class="flex items-center justify-between mb-3">
                            <div
                                class="w-12 h-12 bg-{{ $stat['color'] }}-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="{{ $stat['icon'] }} text-{{ $stat['color'] }}-600 text-xl"></i>
                            </div>
                            <i
                                class="fas fa-arrow-right text-slate-300 group-hover:text-{{ $stat['color'] }}-600 transition-colors"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900 mb-1">{{ $stat['value'] }}</h3>
                        <p class="text-sm font-medium text-slate-600">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-blue-700">Recent Applications</h3>
                </div>

                <div class="p-6">

                    @php
                        $statusConfig = [
                            'submitted' => [
                                'bg' => 'bg-gray-100',
                                'text' => 'text-gray-700',
                                'label' => 'Submitted',
                            ],
                            'under_review' => [
                                'bg' => 'bg-blue-50',
                                'text' => 'text-blue-700',
                                'label' => 'Under Review',
                            ],
                            'approved' => [
                                'bg' => 'bg-green-50',
                                'text' => 'text-green-700',
                                'label' => 'Approved',
                            ],
                            'disapproved' => [
                                'bg' => 'bg-red-50',
                                'text' => 'text-red-700',
                                'label' => 'Disapproved',
                            ],
                            'resubmit' => [
                                'bg' => 'bg-amber-50',
                                'text' => 'text-amber-700',
                                'label' => 'Resubmit',
                            ],
                        ];
                    @endphp

                    <!-- ================= DESKTOP / TABLET TABLE ================= -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="border-b-2 border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-blue-700">Application No.
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-blue-700">Project Type</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-blue-700">Date Submitted
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-blue-700">Status</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-blue-700">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 text-center">
                                @foreach ($applications as $application)
                                    @php
                                        $status = $statusConfig[$application->status] ?? [
                                            'bg' => 'bg-gray-100',
                                            'text' => 'text-gray-700',
                                            'label' => ucfirst($application->status),
                                        ];
                                    @endphp

                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                            {{ $application->application_no }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ ucfirst($application->type_of_application ?? 'New Construction') }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $application->created_at->format('M d, Y') }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex px-3 py-1 rounded-md text-sm font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                                {{ $status['label'] }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('applicant.obo.building_application_view', $application->id) }}"
                                                class="inline-flex items-center px-4 py-2 rounded-lg text-white text-sm font-semibold
                                   {{ $application->status === 'approved' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }}">
                                                {{ $application->status === 'approved' ? 'Download' : 'View' }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- ================= MOBILE CARD VIEW ================= -->
                    <div class="space-y-4 md:hidden">
                        @foreach ($applications as $application)
                            @php
                                $status = $statusConfig[$application->status] ?? [
                                    'bg' => 'bg-gray-100',
                                    'text' => 'text-gray-700',
                                    'label' => ucfirst($application->status),
                                ];
                            @endphp

                            <div class="border border-slate-200 rounded-lg p-4 shadow-sm">

                                <div class="flex justify-between items-center mb-3">
                                    <span class="font-semibold text-slate-900">
                                        {{ $application->application_no }}
                                    </span>

                                    <span class="text-xs px-2 py-1 rounded {{ $status['bg'] }} {{ $status['text'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                </div>

                                <div class="text-sm text-slate-700 space-y-1">
                                    <p><span class="font-medium">Project:</span>
                                        {{ ucfirst($application->type_of_application ?? 'New Construction') }}
                                    </p>
                                    <p><span class="font-medium">Date:</span>
                                        {{ $application->created_at->format('M d, Y') }}
                                    </p>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('applicant.obo.building_application_view', $application->id) }}"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 rounded-lg text-white text-sm font-semibold
                           {{ $application->status === 'approved' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }}">
                                        {{ $application->status === 'approved' ? 'Download Permit' : 'View Application' }}
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <!-- DataTables CSS -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css">

            <!-- jQuery (required for DataTables) -->
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

            <!-- DataTables JS -->
            <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.7/js/dataTables.tailwindcss.min.js"></script>

            <!-- Custom DataTables Styling -->
            <style>
                /* Custom DataTables styling to match design */
                #applicationsTable_wrapper .dataTables_length,
                #applicationsTable_wrapper .dataTables_filter,
                #applicationsTable_wrapper .dataTables_info,
                #applicationsTable_wrapper .dataTables_paginate {
                    padding: 0.75rem 0;
                }

                #applicationsTable_wrapper .dataTables_filter input {
                    border: 1px solid #e2e8f0;
                    border-radius: 0.5rem;
                    padding: 0.5rem 1rem;
                    margin-left: 0.5rem;
                    outline: none;
                    transition: all 0.2s;
                }

                #applicationsTable_wrapper .dataTables_filter input:focus {
                    border-color: #3b82f6;
                    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                }

                #applicationsTable_wrapper .dataTables_length select {
                    border: 1px solid #e2e8f0;
                    border-radius: 0.5rem;
                    padding: 0.375rem 2rem 0.375rem 0.75rem;
                    margin: 0 0.5rem;
                    outline: none;
                }

                #applicationsTable_wrapper .dataTables_paginate .paginate_button {
                    padding: 0.375rem 0.75rem;
                    margin: 0 0.125rem;
                    border-radius: 0.375rem;
                    border: 1px solid #e2e8f0;
                    background: white;
                    color: #475569;
                    transition: all 0.2s;
                }

                #applicationsTable_wrapper .dataTables_paginate .paginate_button:hover {
                    background: #f1f5f9;
                    border-color: #cbd5e1;
                    color: #1e293b;
                }

                #applicationsTable_wrapper .dataTables_paginate .paginate_button.current {
                    background: #1d4ed8;
                    border-color: #1d4ed8;
                    color: white;
                }

                #applicationsTable_wrapper .dataTables_paginate .paginate_button.current:hover {
                    background: #1e40af;
                    border-color: #1e40af;
                    color: white;
                }

                #applicationsTable_wrapper .dataTables_paginate .paginate_button.disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                }

                /* Remove default DataTables sorting icons */
                table.dataTable thead th {
                    position: relative;
                }

                table.dataTable thead .sorting:before,
                table.dataTable thead .sorting_asc:before,
                table.dataTable thead .sorting_desc:before,
                table.dataTable thead .sorting:after,
                table.dataTable thead .sorting_asc:after,
                table.dataTable thead .sorting_desc:after {
                    opacity: 0.3;
                    font-size: 0.75rem;
                }
            </style>

            <script>
                $(document).ready(function() {
                    var table = $('#applicationsTable').DataTable({
                        responsive: true,
                        pageLength: 15,
                        order: [
                            [2, 'desc']
                        ], // Sort by date submitted (newest first)
                        searching: false, // Disable search box
                        lengthChange: false, // Disable show entries dropdown
                        info: false, // Disable info display
                        language: {
                            emptyTable: "No applications available",
                            zeroRecords: "No matching applications found",
                            paginate: {
                                first: "First",
                                last: "Last",
                                next: "Next",
                                previous: "Previous"
                            }
                        },
                        columnDefs: [{
                            targets: 4, // Action column
                            orderable: false,
                            searchable: false
                        }],
                        drawCallback: function(settings) {
                            var api = this.api();
                            var pagination = $(this).closest('.dataTables_wrapper').find(
                                '.dataTables_paginate');

                            // Hide pagination if total records are less than page length (15)
                            if (api.page.info().recordsTotal <= 15) {
                                pagination.hide();
                            } else {
                                pagination.show();
                            }
                        }
                    });
                });
            </script>

        </div>
    </div>

    <script>
        function searchApplications() {
            return {
                query: '',
                filtered: [],
                getApplicationTitle(item) {
                    if (item.application_no.startsWith('APPB')) {
                        return 'Building Permit Application';
                    } else if (item.application_no.startsWith('ZN')) {
                        return 'Zoning Application';
                    } else if (item.application_no.startsWith('SNT')) {
                        return 'Sanitary Application';
                    }
                    return item.title || 'Application';
                },
                async filterApplications() {
                    if (this.query.length < 1) {
                        this.filtered = [];
                        return;
                    }
                    try {
                        const res = await fetch(`/search-applications?query=${this.query}`);
                        const data = await res.json();
                        this.filtered = data;
                    } catch (error) {
                        console.error('Search error:', error);
                        this.filtered = [];
                    }
                },
                selectApplication(item) {
                    if (item.application_no.startsWith('APPB')) {
                        window.location.href = `/applicant/building_permit/view_application/${item.id}`;
                    } else if (item.application_no.startsWith('ZN')) {
                        window.location.href = `/applicant/zoning/view_application/${item.id}`;
                    } else if (item.application_no.startsWith('SNT')) {
                        window.location.href = `/applicant/sanitary/view_application/${item.id}`;
                    } else {
                        window.location.href = `/applications/${item.id}`;
                    }
                }
            };
        }

        const filterSelect = document.getElementById('applicationFilter');
        const summaries = @json($summaries);

        const updateCards = (type) => {
            document.getElementById('totalCount').innerText = summaries[type]['total'];
            document.getElementById('approvedCount').innerText = summaries[type]['approved'];
            document.getElementById('resubmitCount').innerText = summaries[type]['resubmit'];
            document.getElementById('disapprovedCount').innerText = summaries[type]['disapproved'];
        };

        updateCards(filterSelect.value);
        filterSelect.addEventListener('change', function() {
            updateCards(this.value);
        });
    </script>
@endsection
