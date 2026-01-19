@extends('layout.applicant.app')

@section('title', 'Applicant Information')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('obo.buildingApplicantRecord') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                   bg-white border border-blue-200 text-blue-600
                   font-semibold text-sm shadow-sm
                   hover:bg-blue-50 hover:text-blue-700
                   transition-all duration-200">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Records
                </a>
            </div>

            {{-- Header Banner --}}
            <div
                class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-600
                shadow-lg mb-8 p-6 md:p-8 flex items-center justify-between gap-4">

                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-12 h-12 flex items-center justify-center bg-white bg-opacity-20 rounded-full
                            border-2 border-white">
                            <i class="fa-solid fa-user-shield text-blue-700 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white">
                            Applicant Information
                        </h2>
                    </div>
                    <p class="text-blue-100 text-sm max-w-lg">
                        Review and manage applicant details and submitted documents
                    </p>
                </div>

                <div class="hidden lg:block absolute right-6 top-1/2 -translate-y-1/2 opacity-10">
                    <i class="fa-solid fa-user-tie text-white text-8xl"></i>
                </div>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

                {{-- Profile Header --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 md:px-8 py-8 border-b border-blue-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 
                                flex items-center justify-center border-2 border-blue-200">
                                <i class="fa-solid fa-user text-blue-600 text-3xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">
                                    {{ $applicant->first_name }} {{ $applicant->middle_name }} {{ $applicant->last_name }}
                                </h3>
                                <p class="text-sm text-gray-500">Applicant ID: <span
                                        class="font-semibold text-blue-600">#{{ $applicant->id }}</span></p>
                            </div>
                        </div>

                        {{-- Status Badge --}}
                        <span
                            class="inline-block px-5 py-2 rounded-full text-sm font-bold
                            @if ($applicant->pre_registration_status === 'approved') bg-green-100 text-green-700 shadow-sm
                            @elseif($applicant->pre_registration_status === 'pending') 
                                bg-amber-100 text-amber-700 shadow-sm
                            @else 
                                bg-red-100 text-red-700 shadow-sm @endif">
                            <i
                                class="fa-solid 
                                @if ($applicant->pre_registration_status === 'approved') fa-check-circle
                                @elseif($applicant->pre_registration_status === 'pending') fa-clock
                                @else fa-times-circle @endif mr-2"></i>
                            {{ ucfirst($applicant->pre_registration_status) }}
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="px-6 md:px-8 py-8">

                    {{-- Information Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                        {{-- Personal Info --}}
                        <div
                            class="bg-white rounded-xl p-6 border-2 border-blue-50 shadow-sm
                            hover:shadow-md hover:border-blue-200 transition-all duration-200">
                            <h4 class="font-bold text-gray-800 mb-5 flex items-center gap-3">
                                <span class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-lg">
                                    <i class="fa-solid fa-id-card text-blue-600"></i>
                                </span>
                                Personal Information
                            </h4>
                            <div class="space-y-4 text-sm">
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Full Name</span>
                                    <span class="font-semibold text-gray-800">{{ $applicant->first_name }}
                                        {{ $applicant->middle_name }} {{ $applicant->last_name }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Email</span>
                                    <span class="font-semibold text-gray-800 text-right">{{ $applicant->email }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 font-medium">Phone</span>
                                    <span class="font-semibold text-gray-800">{{ $applicant->phone }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Application Info --}}
                        <div
                            class="bg-white rounded-xl p-6 border-2 border-indigo-50 shadow-sm
                            hover:shadow-md hover:border-indigo-200 transition-all duration-200">
                            <h4 class="font-bold text-gray-800 mb-5 flex items-center gap-3">
                                <span class="w-10 h-10 flex items-center justify-center bg-indigo-100 rounded-lg">
                                    <i class="fa-solid fa-file-circle-check text-indigo-600"></i>
                                </span>
                                Application Information
                            </h4>
                            <div class="space-y-4 text-sm">
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Application Date</span>
                                    <span
                                        class="font-semibold text-gray-800">{{ $applicant->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Role</span>
                                    <span class="font-semibold text-gray-800">{{ ucfirst($applicant->role) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 font-medium">Email Verified</span>
                                    <span
                                        class="font-semibold text-gray-800">{{ $applicant->email_verified_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Uploaded Documents --}}
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm mb-8">
                        <h4 class="font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <span class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-lg">
                                <i class="fa-solid fa-file-shield text-blue-600"></i>
                            </span>
                            Uploaded Documents
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Government ID --}}
                            <div class="border rounded-xl p-5 bg-gray-50">
                                <div class="flex items-center justify-between mb-4">
                                    <p class="font-semibold text-gray-700 flex items-center gap-2">
                                        <i class="fa-solid fa-passport text-blue-600"></i>
                                        Government ID
                                    </p>

                                    @if ($applicant->gov_id_file)
                                        <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700">
                                            Uploaded
                                        </span>
                                    @else
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-200 text-gray-500">
                                            Not uploaded
                                        </span>
                                    @endif
                                </div>

                                @if ($applicant->gov_id_file)
                                    <div class="flex gap-3">
                                        <a href="{{ route('applicant.gov-id', $applicant->id) }}" target="_blank"
                                            class="flex-1 text-center px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                                            <i class="fa-solid fa-eye mr-1"></i> Preview
                                        </a>

                                    </div>
                                @else
                                    <p class="text-sm text-gray-400 text-center py-6">
                                        No file uploaded
                                    </p>
                                @endif
                            </div>

                            {{-- Tax Declaration --}}
                            <div class="border rounded-xl p-5 bg-gray-50">
                                <div class="flex items-center justify-between mb-4">
                                    <p class="font-semibold text-gray-700 flex items-center gap-2">
                                        <i class="fa-solid fa-receipt text-indigo-600"></i>
                                        Tax Declaration ID
                                    </p>

                                    @if ($applicant->tax_declaration_file)
                                        <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700">
                                            Uploaded
                                        </span>
                                    @else
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-200 text-gray-500">
                                            Not uploaded
                                        </span>
                                    @endif
                                </div>

                                @if ($applicant->tax_declaration_file)
                                    <div class="flex gap-3">
                                        <a href="{{ route('applicant.tax_id', $applicant->id) }}" target="_blank"
                                            class="flex-1 text-center px-4 py-2 text-sm rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                                            <i class="fa-solid fa-eye mr-1"></i> Preview
                                        </a>


                                    </div>
                                @else
                                    <p class="text-sm text-gray-400 text-center py-6">
                                        No file uploaded
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>


                    {{-- Action Buttons --}}
                    @if ($applicant->pre_registration_status === 'pending')
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                            <button type="button" onclick="openApproveModal()"
                                class="px-6 py-2.5 rounded-lg bg-green-50 text-green-700 
            hover:bg-green-100 hover:text-green-800 transition-all duration-200 
            font-bold text-sm shadow-sm border border-green-200">
                                <i class="fa-solid fa-check-circle mr-2"></i> Approve
                            </button>

                            <button type="button" onclick="openRejectModal()"
                                class="px-6 py-2.5 rounded-lg bg-red-50 text-red-700 
            hover:bg-red-100 hover:text-red-800 transition-all duration-200 
            font-bold text-sm shadow-sm border border-red-200">
                                <i class="fa-solid fa-times-circle mr-2"></i> Reject
                            </button>
                        </div>
                    @elseif($applicant->pre_registration_status === 'approved' || $applicant->pre_registration_status === 'rejected')
                        <div
                            class="mt-6 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center">
                            <span
                                class="inline-block px-4 py-2 rounded-lg
            {{ $applicant->pre_registration_status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}
            font-bold text-sm">
                                <i
                                    class="fa-solid {{ $applicant->pre_registration_status === 'approved' ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
                                {{ strtoupper($applicant->pre_registration_status) }}
                            </span>

                            <p class="text-sm text-gray-600 mt-2 sm:mt-0">
                                By: <span class="font-medium">
                                    {{ $applicantlogs->user->first_name  ?? 'System' }} {{ $applicantlogs->user->last_name  ?? 'System' }}
                                </span>
                                on: <span class="font-medium">
                                    {{ optional($applicantlogs->created_at)->format('M d, Y h:i A') ?? 'N/A' }}
                                </span>
                            </p>
                        </div>

                        @if ($applicant->pre_registration_status === 'rejected' && $applicant->rejection_reason)
                            <p class="mt-2 text-sm text-gray-500">
                                Reason: {{ $applicant->rejection_reason }}
                            </p>
                        @endif
                    @endif


                </div>
            </div>

        </div>
    </div>


    {{-- approve modal --}}
    <div id="approveModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40" onclick="closeApproveModal()"></div>

        <div class="relative bg-white rounded-xl max-w-md mx-auto mt-40 p-6 shadow-xl">
            <h3 class="text-lg font-bold text-gray-800 mb-3">
                Confirm Approval
            </h3>

            <p class="text-sm text-gray-600 mb-6">
                Are you sure you want to approve this application?
            </p>

            <form method="POST" action="{{ route('obo.applicant.approve', $applicant->id) }}">
                @csrf

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeApproveModal()"
                        class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-4 py-2 text-sm rounded-lg bg-green-600 text-white hover:bg-green-700">
                        Yes, Approve
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- reject modal --}}
    <div id="rejectModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40" onclick="closeRejectModal()"></div>

        <div class="relative bg-white rounded-xl max-w-md mx-auto mt-32 p-6 shadow-xl">
            <h3 class="text-lg font-bold text-gray-800 mb-3">
                Reject Application
            </h3>

            <p class="text-sm text-gray-600 mb-4">
                Please provide a reason for rejection.
            </p>

            <form method="POST" action="{{ route('obo.applicant.reject', $applicant->id) }}">
                @csrf

                <textarea name="rejection_reason" required rows="4" placeholder="Enter reason..."
                    class="w-full border border-gray-300 rounded-lg p-3 text-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 mb-6"></textarea>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700">
                        Reject Application
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openApproveModal() {
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>

    <script src="{{ asset('asset/js/buildingRecordFilter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
