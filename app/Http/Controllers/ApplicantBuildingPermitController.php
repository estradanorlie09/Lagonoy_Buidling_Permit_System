<?php

namespace App\Http\Controllers;

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
        $applications = BuildingApplication::with('property')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('applicant.buildingPermitRecords', compact('applications'));
    }

    public function buildingPermitForms()
    {
        $locations = new LocationService;
        $regionCode = '05'; // Region V - Bicol

        // Get provinces only from Region V
        $provinces = $locations->getProvincesByRegion($regionCode);

        return view('applicant.forms.obo.buidlingPermitForm', compact('provinces', 'regionCode'));
    }

    public function store(Request $request)
    {
        $messages = [
            'documents.architecture_plans.required' => 'The Architecture Plans file is required.',
            'documents.architecture_plans.file' => 'The Architecture Plans must be a valid file.',
            'documents.architecture_plans.mimes' => 'The Architecture Plans must be a file of type: pdf, jpg, png.',
            'documents.architecture_plans.max' => 'The Architecture Plans file may not be greater than 40MB.',

            'documents.structure_plans.required' => 'The Structure Plans file is required.',
            'documents.structure_plans.file' => 'The Structure Plans must be a valid file.',
            'documents.structure_plans.mimes' => 'The Structure Plans must be a file of type: pdf, jpg, png.',
            'documents.structure_plans.max' => 'The Structure Plans file may not be greater than 40MB.',

            'documents.plumbing_plans.required' => 'The Plumbing Plans file is required.',
            'documents.plumbing_plans.file' => 'The Plumbing Plans must be a valid file.',
            'documents.plumbing_plans.mimes' => 'The Plumbing Plans must be a file of type: pdf, jpg, png.',
            'documents.plumbing_plans.max' => 'The Plumbing Plans file may not be greater than 40MB.',

            'documents.mechanical_plans.required' => 'The Mechanical Plans file is required.',
            'documents.mechanical_plans.file' => 'The Mechanical Plans must be a valid file.',
            'documents.mechanical_plans.mimes' => 'The Mechanical Plans must be a file of type: pdf, jpg, png.',
            'documents.mechanical_plans.max' => 'The Mechanical Plans file may not be greater than 40MB.',

            'documents.electronics_plans.required' => 'The Electronics Plans file is required.',
            'documents.electronics_plans.file' => 'The Electronics Plans must be a valid file.',
            'documents.electronics_plans.mimes' => 'The Electronics Plans must be a file of type: pdf, jpg, png.',
            'documents.electronics_plans.max' => 'The Electronics Plans file may not be greater than 40MB.',

            'documents.estimated_cost.required' => 'The Estimated Cost file is required.',
            'documents.estimated_cost.file' => 'The Estimated Cost must be a valid file.',
            'documents.estimated_cost.mimes' => 'The Estimated Cost must be a file of type: pdf, jpg, png.',
            'documents.estimated_cost.max' => 'The Estimated Cost file may not be greater than 40MB.',

            'documents.electrical_plans.required' => 'The Electrical Plans file is required.',
            'documents.electrical_plans.file' => 'The Electrical Plans must be a valid file.',
            'documents.electrical_plans.mimes' => 'The Electrical Plans must be a file of type: pdf, jpg, png.',
            'documents.electrical_plans.max' => 'The Electrical Plans file may not be greater than 40MB.',

            'documents.dos.required' => 'The DOS file is required.',
            'documents.dos.file' => 'The DOS must be a valid file.',
            'documents.dos.mimes' => 'The DOS must be a file of type: pdf, jpg, png.',
            'documents.dos.max' => 'The DOS file may not be greater than 40MB.',

            'documents.crptx.required' => 'The CRPTX file is required.',
            'documents.crptx.file' => 'The CRPTX must be a valid file.',
            'documents.crptx.mimes' => 'The CRPTX must be a file of type: pdf, jpg, png.',
            'documents.crptx.max' => 'The CRPTX file may not be greater than 40MB.',

            'documents.site_plan.required' => 'The Site Plan file is required.',
            'documents.site_plan.file' => 'The Site Plan must be a valid file.',
            'documents.site_plan.mimes' => 'The Site Plan must be a file of type: pdf, jpg, png.',
            'documents.site_plan.max' => 'The Site Plan file may not be greater than 40MB.',

            'documents.SPA.required' => 'The SPA file is required.',
            'documents.SPA.file' => 'The SPA must be a valid file.',
            'documents.SPA.mimes' => 'The SPA must be a file of type: pdf, jpg, png.',
            'documents.SPA.max' => 'The SPA file may not be greater than 40MB.',

            'documents.zoning_clearance.required' => 'The Zoning Clearance file is required.',
            'documents.zoning_clearance.file' => 'The Zoning Clearance must be a valid file.',
            'documents.zoning_clearance.mimes' => 'The Zoning Clearance must be a file of type: pdf, jpg, png.',
            'documents.zoning_clearance.max' => 'The Zoning Clearance file may not be greater than 40MB.',

            'documents.bfp_certificate.required' => 'The BFP Certificate file is required.',
            'documents.bfp_certificate.file' => 'The BFP Certificate must be a valid file.',
            'documents.bfp_certificate.mimes' => 'The BFP Certificate must be a file of type: pdf, jpg, png.',
            'documents.bfp_certificate.max' => 'The BFP Certificate file may not be greater than 40MB.',

            'documents.Environmental_clearance.required' => 'The Environmental Clearance file is required.',
            'documents.Environmental_clearance.file' => 'The Environmental Clearance must be a valid file.',
            'documents.Environmental_clearance.mimes' => 'The Environmental Clearance must be a file of type: pdf, jpg, png.',
            'documents.Environmental_clearance.max' => 'The Environmental Clearance file may not be greater than 40MB.',

            'prof_type.required' => 'Please provide at least one professional type.',
            'prof_type.array' => 'Professional type must be an array.',

            'prof_type.*.required' => 'Professional #:position - Professional Type is required.',
            'prof_type.*.string' => 'Professional #:position - Professional Type must be a string.',

            'prof_name.required' => 'Please provide at least one full name.',
            'prof_name.array' => 'Full name must be an array.',

            'prof_name.*.required' => 'Professional #:position - Full Name is required.',
            'prof_name.*.string' => 'Professional #:position - Full Name must be a string.',

            'prc_no.required' => 'Please provide at least one PRC number.',
            'prc_no.array' => 'PRC number must be an array.',

            'prc_no.*.required' => 'Professional #:position - PRC Number is required.',
            'prc_no.*.string' => 'Professional #:position - PRC Number must be a string.',

            'ptr_no.required' => 'Please provide at least one PTR number.',
            'ptr_no.array' => 'PTR number must be an array.',

            'ptr_no.*.required' => 'Professional #:position - PTR Number is required.',
            'ptr_no.*.string' => 'Professional #:position - PTR Number must be a string.',

            'birthday.required' => 'Please provide at least one birthday.',
            'birthday.array' => 'Birthday must be an array.',

            'birthday.*.required' => 'Professional #:position - Birthday is required.',
            'birthday.*.date' => 'Professional #:position - Birthday must be a valid date.',

            'email.required' => 'Please provide at least one email address.',
            'email.array' => 'Email must be an array.',

            'email.*.required' => 'Professional #:position - Email is required.',
            'email.*.email' => 'Professional #:position - Email must be a valid email address.',

            'phone_number.required' => 'Please provide at least one phone number.',
            'phone_number.array' => 'Phone number must be an array.',

            'phone_number.*.required' => 'Professional #:position - Phone Number is required.',
            'phone_number.*.string' => 'Professional #:position - Phone Number must be a string.',

            'prof_address.required' => 'Please provide at least one address.',
            'prof_address.array' => 'Address must be an array.',

            'prof_address.*.required' => 'Professional #:position - Address is required.',
            'prof_address.*.string' => 'Professional #:position - Address must be a string.',
        ];
        // dd($request);
        $request->validate([
            'occupancy_type' => 'required|string|max:255',
            'project_title' => 'required|string|max:255',
            'number_of_floor' => 'required|integer|min:1',
            'floor_area' => 'required|numeric|min:1',
            'lot_area' => 'required|numeric|min:1',
            'estimated_cost' => 'required|numeric|min:1',
            'property_address' => 'required|string|max:255',
            'province' => 'required|string',
            'municipality' => 'required|string',
            'barangay' => 'required|string',
            'comments' => 'nullable|string|max:100',

            'prof_type' => 'required|array',
            'prof_type.*' => 'required|string',

            'prof_name' => 'required|array',
            'prof_name.*' => 'required|string',

            'prc_no' => 'required|array',
            'prc_no.*' => 'required|string',

            'ptr_no' => 'required|array',
            'ptr_no.*' => 'required|string',

            'birthday' => 'required|array',
            'birthday.*' => 'required|date',

            'email' => 'required|array',
            'email.*' => 'required|email',

            'phone_number' => 'required|array',
            'phone_number.*' => 'required|string',

            'prof_address' => 'required|array',
            'prof_address.*' => 'required|string',

            'documents.architecture_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.structure_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.plumbing_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.mechanical_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.electronics_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.estimated_cost' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.electrical_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.dos' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.crptx' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.site_plan' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.SPA' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.zoning_clearance' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.bfp_certificate' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.Environmental_clearance' => 'required|file|mimes:pdf,jpg,png|max:40000',

            'documents.optional' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
        ], $messages);

        try {
            $application = null;

            DB::transaction(function () use ($request, &$application) {

                $property = BuildingProperty::create([
                    'id' => (string) Str::uuid(),
                    'occupancy_type' => $request->occupancy_type,
                    'project_title' => $request->project_title,
                    'number_of_floor' => $request->number_of_floor,
                    'floor_area' => $request->floor_area,
                    'lot_area' => $request->lot_area,
                    'estimated_cost' => $request->estimated_cost,
                    'property_address' => $request->property_address,
                    'province' => $request->province,
                    'municipality' => $request->municipality,
                    'barangay' => $request->barangay,
                ]);

                $application = BuildingApplication::create([
                    'id' => (string) Str::uuid(),
                    'user_id' => auth()->id(),
                    'property_id' => $property->id,
                    'application_no' => 'BLDGP-'.strtoupper(Str::random(8)),
                    'status' => 'submitted',
                ]);

                if ($request->hasFile('documents')) {
                    foreach ($request->file('documents') as $type => $file) {
                        $path = $file->store('building_permit_docs', 'public');

                        BuildingDocument::create([
                            'id' => (string) Str::uuid(),
                            'building_application_id' => $application->id,
                            'document_type' => $type,
                            'file_path' => $path,
                            'version' => 1,
                        ]);
                    }
                }

                $count = count($request->prof_type);
                for ($i = 0; $i < $count; $i++) {
                    if (! isset(
                        $request->prof_name[$i],
                        $request->prc_no[$i],
                        $request->ptr_no[$i],
                        $request->phone_number[$i],
                        $request->email[$i],
                        $request->birthday[$i],
                        $request->prof_address[$i]
                    )) {
                        continue;
                    }

                    if ($request->filled('prof_type')) {
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
                    }
                }
            });

            try {
                // Mail::to($application->user->email)->send(new SanitaryApplicationSubmitted($application));
            } catch (\Exception $e) {
                \Log::error('Mail sending failed: '.$e->getMessage());

                return redirect()->back()->with('error', 'Failed to send confirmation email.');
            }

            return redirect()->back()->with('success', 'Building Application submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Buildinig Application store failed: '.$e->getMessage(), [
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
