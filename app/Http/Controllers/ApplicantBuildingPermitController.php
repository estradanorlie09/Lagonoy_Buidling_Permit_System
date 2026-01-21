<?php

namespace App\Http\Controllers;

use App\Mail\BuildingApplicationSubmitted;
use App\Models\ApplicantLog;
use App\Models\BuildingApplication;
use App\Models\BuildingDocument;
use App\Models\BuildingProperty;
use App\Models\Professional;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApplicantBuildingPermitController extends Controller
{
    public function buildingPermit()
    {
        $userId = Auth()->id();
        $applications = BuildingApplication::with('property')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $applicationValidationReason = ApplicantLog::where('applicant_id', $userId)
            ->latest()
            ->value('remarks');

        return view('applicant.buildingPermitRecords', compact('applications', 'applicationValidationReason'));
    }

    public function buildingPermitForms()
    {
        $locations = new LocationService;
        $regionCode = '05'; // Region V - Bicol
        $user = auth()->user();
        if ($user->pre_registration_status === 'pending') {
            abort(403, 'Your account is still under review. You cannot access this page.');
        }

        if ($user->pre_registration_status === 'rejected') {
            abort(403, 'Your account is rejected. You cannot access this page.');
        }
        // Get provinces only from Region V
        $provinces = $locations->getProvincesByRegion($regionCode);

        return view('applicant.forms.obo.buidlingPermitForm', compact('provinces', 'regionCode'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // Clean numeric fields first
        $request->merge([
            'estimated_cost' => str_replace(',', '', $request->estimated_cost),
            'floor_area' => str_replace(',', '', $request->floor_area),
            'lot_area' => str_replace(',', '', $request->lot_area),
        ]);

        // Custom validation messages
        $messages = [
            'estimated_cost.min' => 'Estimated Cost must be at least ₱1,000.',
            'estimated_cost.max' => 'Estimated Cost must not exceed ₱1,000,000,000.',
            'documents.architecture_plans.required' => 'The Architecture Plans file is required.',
            'documents.structure_plans.required' => 'The Structure Plans file is required.',
            'documents.plumbing_plans.required' => 'The Plumbing Plans file is required.',
            'documents.mechanical_plans.required' => 'The Mechanical Plans file is required.',
            'documents.electronics_plans.required' => 'The Electronics Plans file is required.',
            'documents.estimated_cost.required' => 'The Estimated Cost file is required.',
            'documents.electrical_plans.required' => 'The Electrical Plans file is required.',
            'documents.dos.required' => 'The DOS file is required.',
            'documents.crptx.required' => 'The CRPTX file is required.',
            'documents.site_plan.required' => 'The Site Plan file is required.',
            'documents.SPA.required' => 'The SPA file is required.',
            'documents.zoning_clearance.required' => 'The Zoning Clearance file is required.',
            'documents.bfp_certificate.required' => 'The BFP Certificate file is required.',
            'documents.Environmental_clearance.required' => 'The Environmental Clearance file is required.',
        ];

        // Validation rules
        $request->validate([
            'type_of_application' => 'required|in:new,renewal,amendatory',
            'occupancy_type' => 'required|string|max:255',
            'classified_as' => 'required|string|max:255',
            'project_title' => 'required|string|max:255',
            'number_of_floor' => 'required|integer|min:1',
            'floor_area' => ['required', 'numeric', 'min:1', 'regex:/^[0-9]+(\.[0-9]{1,2})?$/'],
            'lot_area' => 'required|numeric|min:1',
            'estimated_cost' => ['required', 'numeric', 'min:1000', 'max:1000000000'],
            'scope_of_work' => 'required|string|max:255',
            'tct_no' => 'required|string|max:100',
            'fsec_no' => 'required|string|max:100',
            'fsec_issued_date' => 'required|string|max:100',
            'property_address' => 'required|string|max:255',
            'province' => 'required|string',
            'municipality' => 'required|string',
            'barangay' => 'required|string',
            'comments' => 'nullable|string|max:100',

            // Professional data
            'prof_type' => 'required|array',
            'prof_type.*' => 'required|string',
            'prof_name' => 'required|array',
            'prof_name.*' => 'required|string',
            'prc_no' => 'required|array',
            'prc_no.*' => ['required', 'regex:/^[0-9]{7,9}(-[A-Za-z0-9])?$/'],
            'ptr_no' => 'required|array',
            'ptr_no.*' => ['required', 'regex:/^[0-9]{6,10}$/'],
            'birthday' => 'required|array',
            'birthday.*' => 'required|date',
            'email' => 'required|array',
            'email.*' => 'required|email',
            'phone_number' => 'required|array',
            'phone_number.*' => ['required', 'regex:/^(0|9)\d{9,10}$/'],
            'prof_address' => 'required|array',
            'prof_address.*' => 'required|string',
        ]);
        //     // Documents
        //     'documents.architecture_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.structure_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.plumbing_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.mechanical_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.electronics_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.estimated_cost' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.electrical_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.dos' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.crptx' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.site_plan' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.SPA' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.zoning_clearance' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.bfp_certificate' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.Environmental_clearance' => 'required|file|mimes:pdf,jpg,png|max:40000',
        //     'documents.optional' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
        // ],
        //     [
        //         // Human-readable field names
        //         'prof_type.*' => 'professional type',
        //         'prof_name.*' => 'professional name',
        //         'prc_no.*' => 'PRC number',
        //         'ptr_no.*' => 'PTR number',
        //         'birthday.*' => 'birthday',
        //         'email.*' => 'email address',
        //         'phone_number.*' => 'phone number',
        //         'prof_address.*' => 'address',
        //     ], $messages);
        $floorArea = (float) $request->floor_area;
        $lotArea = (float) $request->lot_area;
        $far = $lotArea > 0 ? round($floorArea / $lotArea, 2) : null;

        try {
            DB::transaction(function () use ($request, $far, &$application) {

                $property = BuildingProperty::create([
                    'id' => (string) Str::uuid(),
                    'occupancy_type' => $request->occupancy_type,
                    'classified_as' => $request->classified_as,
                    'project_title' => $request->project_title,
                    'number_of_floor' => $request->number_of_floor,
                    'floor_area' => $request->floor_area,
                    'lot_area' => $request->lot_area,
                    'estimated_cost' => $request->estimated_cost,
                    'scope_of_work' => $request->scope_of_work,

                    'tct_no' => $request->tct_no,
                    'fsec_no' => $request->fsec_no,
                    'fsec_issued_date' => $request->fsec_issued_date,

                    'floor_area_ratio' => $far,
                    'property_address' => $request->property_address,
                    'province' => $request->province,
                    'municipality' => $request->municipality,
                    'barangay' => $request->barangay,
                ]);

                $application = BuildingApplication::create([
                    'id' => (string) Str::uuid(),
                    'user_id' => auth()->id(),
                    'property_id' => $property->id,
                    'application_no' => 'APPB-'.strtoupper(Str::random(8)),
                    // 'building_permit_no' => 'BLDGP-'.strtoupper(Str::random(8)),
                    'type_of_application' => $request->type_of_application,
                    'status' => 'submitted',
                ]);

                // if ($request->hasFile('documents')) {
                //     foreach ($request->file('documents') as $type => $file) {
                //         $path = $file->store('building_permit_docs', 'public');

                //         BuildingDocument::create([
                //             'id' => (string) Str::uuid(),
                //             'building_application_id' => $application->id,
                //             'document_type' => $type,
                //             'file_path' => $path,
                //             'version' => 1,
                //         ]);
                //     }
                // }

                // 👷 Save professionals
                $count = count($request->prof_type);
                for ($i = 0; $i < $count; $i++) {
                    Professional::create([
                        'id' => (string) Str::uuid(),
                        'building_application_id' => $application->id,
                        'prof_type' => $request->prof_type[$i],
                        'prof_name' => $request->prof_name[$i],
                        'prc_no' => $request->prc_no[$i],
                        'ptr_no' => $request->ptr_no[$i],
                        'phone_number' => $request->phone_number[$i],
                        'email' => $request->email[$i],
                        'birthday' => $request->birthday[$i],
                        'prof_address' => $request->prof_address[$i],
                    ]);
                }
            });

            try {
                Mail::to($application->user->email)->send(new BuildingApplicationSubmitted($application));
            } catch (\Exception $e) {
                \Log::error('Mail sending failed: '.$e->getMessage());

                return redirect()->back()->with('error', 'Failed to send confirmation email.');
            }

            return redirect()->back()->with('success', 'Building Application submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Building Application store failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            return redirect()->back()->with('error', 'Failed to submit Building Application. Please try again.');
        }
    }

    // View
    public function show($id)
    {
        $application = BuildingApplication::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('applicant.obo.building_application_view', compact('application'));
    }

    public function resubmitDocument(Request $request, $docId)
    {
        $document = BuildingDocument::findOrFail($docId);
        $application = $document->application;

        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = $request->file('file')->store('building_docs', 'public');

        $latestVersion = BuildingDocument::where('building_application_id', $application->id)
            ->where('document_type', $document->document_type)
            ->max('version') ?? 1;

        BuildingDocument::create([
            'building_application_id' => $application->id,
            'document_type' => $document->document_type,
            'file_path' => $filePath,
            'version' => $latestVersion + 1,
            'status' => 'pending',
        ]);

        $application->update(['status' => 'under_review']);

        return redirect()->back()->with('success', 'Document resubmitted successfully.');
    }
}
