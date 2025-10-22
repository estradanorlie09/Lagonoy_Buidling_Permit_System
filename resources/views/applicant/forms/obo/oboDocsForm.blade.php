<div x-show="currentTab === 3" class="space-y-4">
    <div class="mt-5">
        <h1 class="text-xl font-bold">Attached Requirements 📂</h1>
    </div>
    <h1>
        I. Technical Documents
    </h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">

        <div class="flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Architectural Plans (signed & sealed) <span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-2" class="hidden" name="documents[architecture_plans]" multiple
                onchange="handleFiles(this, 'file-info-2','architecture_plans')" />
            <label for="documents-2"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-2" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
        <div class="flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Structural Plans (signed & sealed) <span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-3" class="hidden" name="documents[structure_plans]" multiple
                onchange="handleFiles(this, 'file-info-3','structure_plans')" />
            <label for="documents-3"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-3" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>

        {{-- Sanitary --}}
        <div class="flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Sanitary / Plumbing Plans (signed & sealed) <span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-4" class="hidden" name="documents[plumbing_plans]" multiple
                onchange="handleFiles(this, 'file-info-4','plumbing_plans')" />
            <label for="documents-4"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-4" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>

        {{-- Mechanical --}}
        <div class="flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Mechanical Plans (signed & sealed)<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-6" class="hidden" name="documents[mechanical_plans]" multiple
                onchange="handleFiles(this, 'file-info-6','mechanical_plans')" />
            <label for="documents-6"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-6" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>

        {{-- Electronics --}}
        <div class="flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Electronics / Alarm / CCTV Plans (signed & sealed)<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-7" class="hidden" name="documents[electronics_plans]" multiple
                onchange="handleFiles(this, 'file-info-7','electronics_plans')" />
            <label for="documents-7"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-7" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>

        {{-- Bill of Materials --}}
        <div class="flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Bill of Materials & Cost Estimates (signed & sealed)<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-8" class="hidden" name="documents[estimated_cost]" multiple
                onchange="handleFiles(this, 'file-info-8','estimated_cost')" />
            <label for="documents-8"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-8" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>

        {{-- Electrical --}}
        <div class="flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Electrical Plans (signed & sealed)<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-5" class="hidden" name="documents[electrical_plans]" multiple
                onchange="handleFiles(this, 'file-info-5','electrical_plans')" />
            <label for="documents-5"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-5" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
    </div>



    <h1>
        II. Proof of Ownership
    </h1>
    <div class="flex flex-col md:flex-row md:space-x-5">
        {{-- -------------------------------------------------------------------------------------------------------------------------------- --}}
        <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Deed of Sale / Transfer Certificate of Title / Title documents<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-9" class="hidden" name="documents[dos]" multiple
                onchange="handleFiles(this, 'file-info-9','dos')" />
            <label for="documents-9"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-9" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
        {{-- -------------------------------------------------------------------------------------------------------------------------------- --}}
        <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Current Real Property Tax Receipt<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-10" class="hidden" name="documents[crptx]" multiple
                onchange="handleFiles(this, 'file-info-10','crptx')" />
            <label for="documents-10"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-10" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row md:space-x-5">


        {{-- -------------------------------------------------------------------------------------------------------------------------------- --}}
        {{-- -------------------------------------------------------------------------------------------------------------------------------- --}}
        <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Lot / Site Plan (signed & sealed by Geodetic Engineer)<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-11" class="hidden" name="documents[site_plan]" multiple
                onchange="handleFiles(this, 'file-info-11','site_plan')" />
            <label for="documents-11"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-11" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
        <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Authorization / SPA (if applicant is not registered owner)<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-12" class="hidden" name="documents[SPA]" multiple
                onchange="handleFiles(this, 'file-info-12','SPA')" />
            <label for="documents-12"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-12" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
    </div>


    <h1>
        III. Written Clearances / Certifications (When Necessary)
    </h1>
    <div class="flex flex-col md:flex-row md:space-x-5">
        {{-- -------------------------------------------------------------------------------------------------------------------------------- --}}
        <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Zoning Clearance<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-13" class="hidden" name="documents[zoning_clearance]" multiple
                onchange="handleFiles(this, 'file-info-13','zoning_clearance')" />
            <label for="documents-13"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-13" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
        {{-- -------------------------------------------------------------------------------------------------------------------------------- --}}
        <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Fire Safety Clearance / FSEC (BFP)<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-14" class="hidden" name="documents[bfp_certificate]" multiple
                onchange="handleFiles(this, 'file-info-14','bfp_certificate')" />
            <label for="documents-14"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-14" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row md:space-x-5">


        {{-- -------------------------------------------------------------------------------------------------------------------------------- --}}
        {{-- -------------------------------------------------------------------------------------------------------------------------------- --}}
        <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Environmental Clearance / DENR (if applicable)<span class="text-red-500">*</span>
            </label>
            <input type="file" id="documents-15" class="hidden" name="documents[Environmental_clearance]"
                multiple onchange="handleFiles(this, 'file-info-15','Environmental_clearance')" />
            <label for="documents-15"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-15" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
        <div class="w-full md:w-1/2 mt-6 md:mt-0 flex flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 16V4a1 1 0 011-1h6a1 1 0 011 1v12M7 16h10M7 16l-2 4h14l-2-4" />
                </svg>
                Other clearances (DOH, DPWH, etc.) as required
            </label>
            <input type="file" id="documents-16" class="hidden" name="documents[optional]" multiple
                onchange="handleFiles(this, 'file-info-16','optional')" />
            <label for="documents-16"
                class="cursor-pointer inline-flex items-center justify-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Choose Files
            </label>
            <div id="file-info-16" class="mt-3 text-sm text-gray-600 flex flex-col gap-2"></div>
        </div>
    </div>
</div>
<div id="docsMessage" class="mt-6 text-sm text-gray-600"></div>
<script src="{{ asset('asset/js/buildingDocumentChecker.js') }}"></script>
