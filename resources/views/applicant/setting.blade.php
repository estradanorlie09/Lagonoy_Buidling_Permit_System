@extends('layout.applicant.app')

@section('title', 'Settings')

@section('content')
    <div class="w-full h-auto p-4 md:p-6">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg p-4 md:p-6 mb-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <i class="fas fa-cog text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">User Settings</h1>
                        <p class="text-blue-100 text-xs mt-0.5">Manage your account information</p>
                    </div>
                </div>
                <a href="{{ route('applicant.forms.profile.update_form') }}"
                    class="inline-flex items-center gap-2 bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-all duration-300 shadow-md hover:shadow-lg font-medium text-sm">
                    <i class="fas fa-pen"></i> Update Profile
                </a>
            </div>
        </div>

        <!-- Personal Details Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-4 border border-blue-100">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 border-b border-blue-100">
                <h2 class="text-lg font-semibold flex items-center gap-2 text-blue-800">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-sm"></i>
                    </div>
                    Personal Details
                </h2>
            </div>

            <div class="p-4 md:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Left Column -->
                    <div class="space-y-3">
                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Account Type</h4>
                                <div class="text-gray-800 font-semibold text-sm">{{ ucwords(Auth::user()->role) }}</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">First Name</h4>
                                <div class="text-gray-800 font-semibold text-sm">{{ ucwords(Auth::user()->first_name) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Middle Name</h4>
                                <div class="text-gray-800 font-semibold text-sm">
                                    {{ !empty(Auth::user()->middle_name) ? ucwords(Auth::user()->middle_name) : 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Last Name</h4>
                                <div class="text-gray-800 font-semibold text-sm">{{ ucwords(Auth::user()->last_name) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Suffix</h4>
                                <div class="text-gray-800 font-semibold text-sm">
                                    {{ !empty(ucwords(Auth::user()->suffix)) ? Auth::user()->suffix : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-3">
                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Gender</h4>
                                <div class="text-gray-800 font-semibold text-sm">{{ ucwords(Auth::user()->gender) }}</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Birthday</h4>
                                <div class="text-gray-800 font-semibold text-sm">
                                    {{ \Carbon\Carbon::parse(Auth::user()->birth_date)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Email</h4>
                                <div class="text-gray-800 font-semibold break-all text-sm">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Phone Number</h4>
                                <div class="text-gray-800 font-semibold text-sm">{{ ucwords(Auth::user()->phone) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address & Other Details Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 border-b border-blue-100">
                <h2 class="text-lg font-semibold flex items-center gap-2 text-blue-800">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-blue-600 text-sm"></i>
                    </div>
                    Address / Other Details
                </h2>
            </div>

            <div class="p-4 md:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Left Column -->
                    <div class="space-y-3">
                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Province</h4>
                                <div class="text-gray-800 font-semibold text-sm">
                                    {{ !empty(ucwords(Auth::user()->province)) ? Auth::user()->province : 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Municipality</h4>
                                <div class="text-gray-800 font-semibold text-sm">
                                    {{ !empty(ucwords(Auth::user()->municipality)) ? Auth::user()->municipality : 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Barangay</h4>
                                <div class="text-gray-800 font-semibold text-sm">
                                    {{ !empty(ucwords(Auth::user()->barangay)) ? Auth::user()->barangay : 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Lot No./Blk No./Street</h4>
                                <div class="text-gray-800 font-semibold text-sm">
                                    {{ !empty(ucwords(Auth::user()->street)) ? Auth::user()->street : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-3">
                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Created At</h4>
                                <div class="text-gray-800 font-semibold text-sm">
                                    {{ Auth::user()->created_at->format('F d, Y h:i A') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Last Updated</h4>
                                <div class="text-gray-800 font-semibold text-sm">
                                    {{ Auth::user()->updated_at->format('F d, Y h:i A') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Email Status</h4>
                                <div class="mt-1">
                                    @if (Auth::user()->email_verified_at)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 text-green-700 font-semibold text-xs shadow-sm">
                                            <i class="fas fa-check-circle"></i>
                                            Verified
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-100 text-red-700 font-semibold text-xs shadow-sm">
                                            <i class="fas fa-times-circle"></i>
                                            Not Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="flex-1">
                                <h4 class="text-gray-500 text-xs font-medium mb-0.5">Account Status</h4>
                                <div class="mt-1">
                                    @if (Auth::user()->pre_registration_status === 'approved')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 text-green-700 font-semibold text-xs shadow-sm">
                                            <i class="fas fa-check-circle"></i>
                                            Approved
                                        </span>
                                    @elseif (Auth::user()->pre_registration_status === 'rejected')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-100 text-red-700 font-semibold text-xs shadow-sm">
                                            <i class="fas fa-times-circle"></i>
                                            Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-100 text-amber-700 font-semibold text-xs shadow-sm">
                                            <i class="fas fa-clock"></i>
                                            Pending Review
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
