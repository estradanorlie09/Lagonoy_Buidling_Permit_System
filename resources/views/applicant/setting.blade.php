@extends('layout.applicant.app')

@section('title', 'Settings')

@section('content')
    <div class="w-full h-auto p-10 bg-white shadow rounded">
        <div class="flex flex-col md:flex-row justify-between items-center pb-4 mb-8">
            <h1 class="text-3xl font-bold text-red-600 flex items-center gap-3">
                <i class="fas fa-cog text-2xl"></i> User Settings
            </h1>
            <a href="{{ route('applicant.forms.profile.update_form') }}"
                class="mt-4 md:mt-0 border border-red-500 text-red-500 px-5 py-2 rounded-lg hover:bg-red-500 hover:text-white transition duration-300">
                <i class="fas fa-pen me-1"></i> Update Profile
            </a>
        </div>


        <div class="w-full flex justify-center">
            <div class="w-[95%]">
                <h2 class="text-xl font-semibold mb-3 flex items-center gap-2 text-red-500">
                    <i class="fas fa-user text-red-500"></i> Personal Details
                </h2>
                <hr class="border border-gray-300">
                <div class="w-full flex flex-col lg:flex-row justify-between gap-5">
                    <!-- Left Column -->
                    <div class="w-full lg:w-[48%]">
                        <div class="m-5 space-y-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Account Type</h4>
                                <span>:</span>
                                <div class="text-sm">{{ ucwords(Auth::user()->role) }}</div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">First Name</h4>
                                <span>:</span>
                                <div class="text-sm">{{ ucwords(Auth::user()->first_name) }}</div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Middle Name</h4>
                                <span>:</span>
                                <div class="text-sm">
                                    {{ !empty(Auth::user()->middle_name) ? ucwords(Auth::user()->middle_name) : 'N/A' }}

                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Last Name</h4>
                                <span>:</span>
                                <div class="text-sm">{{ ucwords(Auth::user()->last_name) }}</div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Suffix</h4>
                                <span>:</span>
                                <div class="text-sm">
                                    {{ !empty(ucwords(Auth::user()->suffix)) ? Auth::user()->suffix : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="w-full lg:w-[48%]">
                        <div class="m-5 space-y-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Gender</h4>
                                <span>:</span>
                                <div class="text-sm">{{ ucwords(Auth::user()->gender) }}</div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Birthday</h4>
                                <span>:</span>
                                <div class="text-sm">
                                    {{ \Carbon\Carbon::parse(Auth::user()->birth_date)->format('F d, Y') }}
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Email</h4>
                                <span>:</span>
                                <div class="text-sm">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Phone Number</h4>
                                <span>:</span>
                                <div class="text-sm">{{ ucwords(Auth::user()->phone) }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="w-full flex justify-center">
            <div class="w-[95%]">
                <h2 class="text-xl font-semibold mt-3 mb-3 flex items-center gap-2 text-red-500">
                    <i class="fas fa-map-marker-alt text-red-500"></i> Address / Other Details
                </h2>
                <hr class="border border-gray-300">
                <div class="w-full flex flex-col lg:flex-row justify-between gap-5">
                    <!-- Left Column -->
                    <div class="w-full lg:w-[48%]">
                        <div class="m-5 space-y-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Province</h4>
                                <span>:</span>
                                <div class="text-sm">
                                    {{ !empty(ucwords(Auth::user()->province)) ? Auth::user()->province : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Municipalty</h4>
                                <span>:</span>
                                <div class="text-sm">
                                    {{ !empty(ucwords(Auth::user()->municipality)) ? Auth::user()->municipality : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Barangay</h4>
                                <span>:</span>
                                <div class="text-sm">
                                    {{ !empty(ucwords(Auth::user()->barangay)) ? Auth::user()->barangay : 'N/A' }}
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Lot No./Blk No./Street</h4>
                                <span>:</span>
                                <div class="text-sm">
                                    {{ !empty(ucwords(Auth::user()->street)) ? Auth::user()->street : 'N/A' }}
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="w-full lg:w-[48%]">
                        <div class="m-5 space-y-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Created At</h4>
                                <span>:</span>
                                <div class="text-sm">{{ Auth::user()->created_at }}</div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-gray-400 text-sm w-40">Updated At</h4>
                                <span>:</span>
                                <div class="text-sm">{{ ucwords(Auth::user()->updated_at) }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
