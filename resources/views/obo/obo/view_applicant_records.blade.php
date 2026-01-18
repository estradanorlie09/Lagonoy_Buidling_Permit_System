@extends('layout.applicant.app')

@section('title', 'Applicant Information')

@section('content')
    <div class="bg-white max-w-10xl mx-auto px-6 py-2">
        <div class="max-w-10xl mx-auto m-3 flex justify-end">
            <a href="{{ route('obo.buildingApplicantRecord') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
               bg-white border border-red-200 text-red-600
               font-semibold text-sm shadow-sm
               hover:bg-red-50 hover:text-red-700
               transition-all duration-200">

                <i class="fa-solid fa-arrow-left"></i>
                Back to Records
            </a>
        </div>

        <div
            class="relative rounded-xl overflow-hidden bg-gradient-to-br from-red-50 to-rose-100
           shadow-sm mb-4 p-5 md:p-6 flex items-center justify-between gap-4
           border border-red-100">

            <!-- Left Section -->
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-1">
                    <div
                        class="w-11 h-11 flex items-center justify-center bg-white rounded-full
                       border border-red-200">
                        <i class="fa-solid fa-user-shield text-red-500 text-xl"></i>
                    </div>
                    <h2 class="text-xl md:text-2xl font-bold text-red-800">
                        Applicant Information
                    </h2>
                </div>

                <p class="text-gray-600 text-sm max-w-lg">
                    Review applicant details and submitted documents.
                </p>
            </div>

            <!-- Right Illustration -->
            <div class="hidden md:block">
                <img src="{{ asset('asset/img/download.png') }}" alt="Building Illustration" class="w-24 opacity-80">
            </div>
        </div>


        {{-- Applicant Profile --}}
        <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fa-solid fa-user text-red-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $applicant->first_name }} {{ $applicant->middle_name }} {{ $applicant->last_name }}
                        </h3>
                        <p class="text-sm text-gray-500">Applicant ID: #{{ $applicant->id }}</p>
                    </div>
                </div>

                {{-- Status --}}
                <span
                    class="px-4 py-2 rounded-full text-sm font-semibold
            @if ($applicant->pre_registration_status === 'approved') bg-green-100 text-green-700
            @elseif($applicant->pre_registration_status === 'pending') bg-yellow-100 text-yellow-700
            @else bg-red-100 text-red-700 @endif">
                    {{ ucfirst($applicant->pre_registration_status) }}
                </span>
            </div>

            {{-- Information Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Personal Info --}}
                <div class="bg-gray-50 rounded-xl p-5 shadow-sm">
                    <h4 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-id-card text-red-500"></i>
                        Personal Information
                    </h4>
                    <div class="space-y-3 text-sm text-gray-700">
                        <div class="flex justify-between"><span class="text-gray-500">Full Name</span><span
                                class="font-medium">{{ $applicant->first_name }} {{ $applicant->middle_name }}
                                {{ $applicant->last_name }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Email</span><span
                                class="font-medium">{{ $applicant->email }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Phone</span><span
                                class="font-medium">{{ $applicant->phone }}</span></div>
                    </div>
                </div>

                {{-- Application Info --}}
                <div class="bg-gray-50 rounded-xl p-5 shadow-sm">
                    <h4 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-file-circle-check text-red-500"></i>
                        Application Information
                    </h4>
                    <div class="space-y-3 text-sm text-gray-700">
                        <div class="flex justify-between"><span class="text-gray-500">Application Date</span><span
                                class="font-medium">{{ $applicant->created_at->format('M d, Y') }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Role</span><span
                                class="font-medium">{{ ucfirst($applicant->role) }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Email Verified At</span><span
                                class="font-medium">{{ $applicant->email_verified_at->format('M d, Y') }}</span></div>
                    </div>
                </div>
            </div>

            {{-- Uploaded Documents --}}
            <div class="mt-6 bg-gray-50 rounded-xl p-5 shadow-sm">
                <h4 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-file-shield text-red-500"></i>
                    Uploaded Documents
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Government ID --}}
                    <div class="bg-white rounded-lg p-3 shadow-sm">
                        <p class="text-sm font-medium text-gray-600 mb-2">Government ID</p>
                        @if ($applicant->gov_id_file)
                            @php $govExt = pathinfo($applicant->gov_id_file, PATHINFO_EXTENSION); @endphp

                            <iframe src="{{ route('applicant.gov-id', $applicant->id) }}"
                                class="w-full h-64 rounded-md border-0 shadow-sm"></iframe>
                        @else
                            <div
                                class="h-64 flex items-center justify-center text-gray-400 text-sm rounded-md border border-dashed border-gray-300">
                                No file uploaded
                            </div>
                        @endif
                    </div>

                    {{-- Tax Declaration ID --}}
                    <div class="bg-white rounded-lg p-3 shadow-sm">
                        <p class="text-sm font-medium text-gray-600 mb-2">Tax Declaration ID</p>
                        @if ($applicant->tax_declaration_file)
                            @php $taxExt = pathinfo($applicant->tax_declaration_file, PATHINFO_EXTENSION); @endphp

                            <iframe src="{{ route('applicant.tax_id', $applicant->id) }}"
                                class="w-full h-64 rounded-md border-0 shadow-sm"></iframe>
                        @else
                            <div
                                class="h-64 flex items-center justify-center text-gray-400 text-sm rounded-md border border-dashed border-gray-300">
                                No file uploaded
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Action Buttons --}}
            @if ($applicant->pre_registration_status === 'pending')
                <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8">
                    <button
                        class="px-5 py-2 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 transition font-semibold text-sm">
                        <i class="fa-solid fa-check mr-1"></i> Approve
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 transition font-semibold text-sm">
                        <i class="fa-solid fa-xmark mr-1"></i> Reject
                    </button>
                </div>
            @elseif($applicant->pre_registration_status === 'approved')
                <div class="mt-4 font-semibold text-green-700">APPROVED</div>
            @endif

        </div>


    </div>
    <script src="{{ asset('asset/js/buildingRecordFilter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
