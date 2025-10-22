@extends('layout.applicant.app')

@section('title', 'Resubmit')

@section('content')
    <div class="w-full mx-auto mt-10 p-6 bg-white rounded shadow" x-data="formTabs()">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <strong>Whoops!</strong> Please fix the following:
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-red-600">Resubmit Needed Documents</h1>
            <div>
                <a href="{{ route('applicant.zoning.zoning_application_view', $application->id) }}"
                    class="text-red-600 underline">Back</a>
            </div>
        </div>
        <form method="POST" action="{{ route('zoning.resubmit', $application->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="mt-5">
                <h1 class="text-xl font-bold">Attached Requirements 📂</h1>
            </div>
            <div class="flex flex-col md:flex-row md:space-x-5">
                <!-- Left side: Form fields -->
                <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <!-- File icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                        </svg>
                        Upload Documents (Vicinity Map (signed by Engineer/Architect))<span class="text-red-500">*</span>
                    </label>

                    <!-- Hidden file input -->
                    <input type="file" id="documents-2" class="hidden" name="documents[vicinity_map]" multiple
                        onchange="handleFiles(this, 'file-info-2','vicinity_map')" />

                    <!-- Styled label acting as button -->
                    <label for="documents-2"
                        class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Choose Files
                    </label>

                    <!-- File names list and preview button container -->
                    <div id="file-info-2" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                </div>

                <!-- Right side: File upload -->
                <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <!-- File icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                        </svg>
                        Upload Documents (Lot Plan (signed by Geodetic Engineer))<span class="text-red-500">*</span>

                    </label>

                    <!-- Hidden file input -->
                    <input type="file" id="documents-3" class="hidden" name="documents[lot_plan]" multiple
                        onchange="handleFiles(this, 'file-info-3','lot_plan')" />

                    <!-- Styled label acting as button -->
                    <label for="documents-3"
                        class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Choose Files
                    </label>

                    <!-- File names list and preview button container -->
                    <div id="file-info-3" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row md:space-x-5">
                <!-- Left side: Form fields -->
                <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <!-- File icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                        </svg>
                        Upload Documents (Proof of Ownership / Tax Declaration)<span class="text-red-500">*</span>
                    </label>

                    <!-- Hidden file input -->
                    <input type="file" id="documents-4" class="hidden" name="documents[proof_of_ownership]" multiple
                        onchange="handleFiles(this, 'file-info-4','proof_of_ownership')" />

                    <!-- Styled label acting as button -->
                    <label for="documents-4"
                        class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Choose Files
                    </label>

                    <!-- File names list and preview button container -->
                    <div id="file-info-4" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                </div>

                <!-- Right side: File upload -->
                <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <!-- File icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                        </svg>
                        Upload Documents (Community Tax Certificate (CTC))<span class="text-red-500">*</span>
                    </label>

                    <!-- Hidden file input -->
                    <input type="file" id="documents-5" class="hidden" name="documents[ctc]" multiple
                        onchange="handleFiles(this, 'file-info-5','CTC')" />
                    <!-- Styled label acting as button -->
                    <label for="documents-5"
                        class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Choose Files
                    </label>

                    <!-- File names list and preview button container -->
                    <div id="file-info-5" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row md:space-x-5">
                <!-- Left side: Form fields -->
                <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <!-- File icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                        </svg>
                        Upload Documents (Authorization Letter (optional))
                    </label>

                    <!-- Hidden file input -->
                    <input type="file" id="documents-6" class="hidden" name="documents[authorization_letter]"
                        multiple onchange="handleFiles(this, 'file-info-6')" />

                    <!-- Styled label acting as button -->
                    <label for="documents-6"
                        class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Choose Files
                    </label>

                    <!-- File names list and preview button container -->
                    <div id="file-info-6" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                </div>

                <!-- Right side: File upload -->
                <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <!-- File icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                        </svg>
                        Upload Documents (Other Supporting Documents (optional))
                    </label>

                    <!-- Hidden file input -->
                    <input type="file" id="documents-7" class="hidden"name="documents[other_doc]" multiple
                        onchange="handleFiles(this, 'file-info-7')" />

                    <!-- Styled label acting as button -->
                    <label for="documents-7"
                        class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Choose Files
                    </label>

                    <!-- File names list and preview button container -->
                    <div id="file-info-7" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
                </div>
            </div>
            <div id="docsMessage" class="mt-6 text-sm text-gray-600"></div>


            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Submit</button>
            </div>
        </form>
    </div>

  <script src="{{ asset('asset/js/zoningDocumentChecker.js') }}"></script>


@endsection
