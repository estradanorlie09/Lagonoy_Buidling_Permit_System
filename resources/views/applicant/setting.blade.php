@extends('layout.applicant.app')

@section('title', 'Settings')

@section('content')
    <div class="w-full h-auto bg-white shadow rounded">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-red-500 mb-3 p-5">User Settings ⚙️</h1>
            <a href="{{ route('applicant.forms.profile.update_form') }}" class="m-5 border-b-1 text-red-400 ">✏️Update
                Your
                Profile</a>
        </div>


        <div class="w-full flex justify-center">
            <div class="w-[95%]">
                <h1 class="m-5 text-xl">Personal Details 👤</h1>
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
                                    {{ !empty(ucwords(Auth::user()->middle_name)) ? Auth::user()->middle_name : 'N/A' }}
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
                <h1 class="m-5 text-xl">Address 🗺️ / Other Details</h1>
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
