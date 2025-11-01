@extends('layout.applicant.app')

@section('title', 'Zoning Applications Review')

@section('content')
    <div class="bg-white rounded-xl p-8 space-y-8" x-data="{ openModal: false, selectedDocs: [] }">

        <!-- Header Section -->
        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-file-signature text-red-600"></i>
                    Building Applications Review
                </h1>
                <p class="text-gray-500 text-sm mt-1">Review and approve submitted applicant documents.</p>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        toast: true,
                        position: 'top-end',
                        background: '#f0fdf4',
                        color: '#166534'
                    });
                });
            </script>
        @endif


        {{-- No Documents --}}
        @if ($documents->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-lg shadow-sm">
                <i class="fas fa-folder-open text-gray-400 text-5xl mb-3"></i>
                <p class="text-gray-500 text-lg">No pending documents to review.</p>
            </div>
        @else
            @php
                $groupedDocs = $documents->groupBy(fn($doc) => $doc->application->application_no);
            @endphp

            <!-- Documents Table Card -->
            <div class="bg-white rounded-md overflow-hidden  border-gray-100">
                <div
                    class="flex flex-col sm:flex-row justify-between items-center px-6 py-6 border-b border-gray-200 gap-4">
                    <div class="w-full sm:w-1/2">
                        <h1 class="text-xl font-semibold text-red-800">Building Applications Documents</h1>

                    </div>

                    <div class="w-full sm:w-1/2 flex flex-col sm:flex-row justify-end items-center gap-3">
                        <!-- Search -->
                        <div class="relative w-full sm:w-3/4"> <!-- ⬅ made wider here -->
                            <input type="search" id="customSearch" placeholder="Search applications..."
                                class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:ring-2 focus:ring-red-500 focus:outline-none transition">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-800 text-lg flex items-center gap-2">
                        <i class="fas fa-file-alt text-red-500"></i>
                        Pending Documents
                    </h2>
                    <span class="text-sm text-gray-500">{{ $documents->count() }} total documents</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700" id="example">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-center font-semibold">#</th>
                                <th class="px-6 py-3 text-left font-semibold">Applicant</th>
                                <th class="px-6 py-3 text-left font-semibold">Application No</th>
                                <th class="px-6 py-3 text-left font-semibold">Status</th>
                                <th class="px-6 py-3 text-left font-semibold">Documents</th>
                                <th class="px-6 py-3 text-center font-semibold">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($groupedDocs as $appNo => $docs)
                                @php
                                    $firstDoc = $docs->first();
                                    $applicant = $firstDoc->application->user;
                                @endphp
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4 text-center font-semibold text-gray-800">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <i class="fas fa-user text-gray-400 mr-2"></i>
                                        {{ $applicant->first_name }} {{ $applicant->last_name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700">
                                        <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2.5 py-1 rounded">
                                            {{ $appNo }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @php
                                            $status = ucfirst($docs->first()->status ?? 'Pending');
                                            $statusColor = match (strtolower($status)) {
                                                'approved' => 'bg-green-100 text-green-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                                'resubmit' => 'bg-yellow-100 text-yellow-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $statusColor }}">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <ul class="list-disc pl-5 space-y-1 text-gray-600">
                                            @foreach ($docs as $doc)
                                                <li class="capitalize flex items-center gap-2">
                                                    <i class="fas fa-file text-red-400"></i>
                                                    {{ str_replace('_', ' ', $doc->document_type) }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button @click="openModal = true; selectedDocs = {{ $docs->toJson() }}"
                                            class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition">
                                            <i class="fas fa-eye"></i>
                                            Review
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Review Modal -->
        <div x-show="openModal" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4" x-cloak>
            <div @click.away="openModal = false"
                class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-6 relative overflow-hidden">

                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-5 pb-3">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-clipboard-check text-red-600"></i>
                        Review Submitted Documents
                    </h2>


                    <button @click="openModal = false" class="text-gray-400 hover:text-red-600 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>


                <!-- Modal Content -->
                <template x-if="selectedDocs.length">
                    <form method="POST" action="{{ route('zoning.review.multiple') }}" class="space-y-5">
                        @csrf

                        <div class="overflow-x-auto  border border-gray-100 shadow-inner">
                            <table class="min-w-full text-sm text-gray-700">
                                <thead class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
                                    <tr class="text-left text-gray-700 text-xs uppercase tracking-wider">
                                        <th class="py-3 px-4 font-semibold">Document</th>
                                        <th class="py-3 px-4 font-semibold">File</th>
                                        <th class="py-3 px-4 font-semibold text-center">Action</th>
                                        <th class="py-3 px-4 font-semibold">Remarks</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 bg-white">
                                    <template x-for="(doc, index) in selectedDocs" :key="doc.id">
                                        <tr class="hover:bg-blue-50/50 transition-all duration-150 ease-in-out">
                                            <!-- Document Type -->
                                            <td class="py-4 px-4 flex items-center gap-3">
                                                <div class="bg-blue-100 text-red-600 p-2 rounded-lg">
                                                    <i class="fas fa-file-alt"></i>
                                                </div>
                                                <span class="capitalize font-medium text-gray-800"
                                                    x-text="doc.document_type.replaceAll('_', ' ')"></span>
                                            </td>

                                            <!-- File Link -->
                                            <td class="py-4 px-4">
                                                <a :href="`/storage/${doc.file_path}`" target="_blank"
                                                    class="inline-flex items-center gap-2 text-red-600 hover:text-red-800 font-medium transition">
                                                    <i class="fas fa-external-link-alt"></i> View File
                                                </a>
                                            </td>

                                            <!-- Status Select -->
                                            <td class="py-4 px-4 text-center">
                                                <div class="relative">
                                                    <select :name="`documents[${index}][status]`"
                                                        class="border-gray-300 rounded-lg border outline-none px-3 py-1.5 text-sm w-44 focus:ring-2 focus:ring-red-400 focus:red-blue-400 transition"
                                                        required>
                                                        <option value="">Select...</option>
                                                        <option value="approved">Approve</option>
                                                        <option value="rejected">Reject</option>
                                                        <option value="resubmit">Resubmit</option>
                                                    </select>
                                                    <input type="hidden" :name="`documents[${index}][id]`"
                                                        :value="doc.id">
                                                </div>
                                            </td>

                                            <!-- Remarks -->
                                            <td class="py-4 px-4">
                                                <div class="relative">
                                                    <textarea :name="`documents[${index}][remarks]`" rows="1"
                                                        class="border-gray-300 rounded-lg p-3 border outline-none px-3 py-1.5 w-full text-sm focus:ring-2 focus:ring-red-400 focus:border-red-400 transition resize-none"
                                                        placeholder="Add reviewer remarks..."></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal Footer -->
                        <div
                            class="sticky bottom-0 left-0 right-0 flex justify-between items-center px-6 py-4 border-t bg-gradient-to-r from-gray-50 to-white rounded-b-xl shadow-inner">

                            <div class="text-sm text-gray-500 flex items-center gap-2">
                                <i class="fas fa-info-circle text-red-500"></i>
                                Review all documents before submitting.
                            </div>

                            <div class="flex gap-3">
                                <button type="button" @click="openModal = false"
                                    class="px-4 py-2 text-gray-700 bg-gray-100">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </button>
                                <button type="submit" class="px-5 py-2 text-white bg-red-500 rounded-md">
                                    <i class="fas fa-paper-plane mr-1"></i> Submit Review
                                </button>
                            </div>
                        </div>
                    </form>
                </template>


                <!-- Empty Modal -->
                <template x-if="!selectedDocs.length">
                    <div class="text-center text-gray-500 py-10">
                        <i class="fas fa-folder-open text-3xl mb-2"></i>
                        <p>No documents selected for review.</p>
                    </div>
                </template>
            </div>
        </div>

    </div>

    <script src="{{ asset('asset/js/datatable.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
@endsection
