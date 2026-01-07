<?php

namespace App\Http\Controllers;

use App\Mail\ZoningApplicationSubmitted;
use App\Models\BuildingDocument;
use App\Models\ZoningApplication;
use App\Models\ZoningDocument;
use App\Models\ZoningProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ZoningController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'property_address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'lot_area' => 'required|numeric|min:1',
            'tax_declaration' => [
                'required',
                'string',
                'regex:/^(TD-)?05-\d{4}-\d{3,5}(-[A-Z])?$/',
                'max:20', 
            ],

            'comments' => 'nullable|string',
            'status' => 'required|in:submitted,approved,disapproved,resubmit,under_review',

            'documents.vicinity_map' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.lot_plan' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.proof_of_ownership' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.ctc' => 'required|file|mimes:pdf,jpg,png|max:40000',

            'documents.authorization_letter' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
            'documents.other_doc' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
        ], [
            'tax_declaration.required' => 'The Tax Declaration Number is required.',
            'tax_declaration.string' => 'The Tax Declaration Number must be a valid string.',
            'tax_declaration.max' => 'The Tax Declaration Number may not exceed 25 characters.',
            'tax_declaration.regex' => 'The Tax Declaration Number must follow this format: 05-1718-XXXXX (e.g. 05-1718-00123).',
        ]);

        try {
            $application = null;

            DB::transaction(function () use ($request, &$application) {
                // Create property
                $property = ZoningProperty::create([
                    'id' => (string) Str::uuid(),
                    'property_address' => $request->property_address,
                    'province' => $request->province,
                    'municipality' => $request->municipality,
                    'barangay' => $request->barangay,
                    'lot_area' => $request->lot_area,
                    'tax_declaration' => $request->tax_declaration,
                    'ownership_type' => $request->ownership_type,
                    'comments' => $request->comments,
                ]);

                // Create application
                $application = ZoningApplication::create([
                    'id' => (string) Str::uuid(),
                    'user_id' => auth()->id(),
                    'property_id' => $property->id,
                    'application_no' => 'ZN-'.strtoupper(Str::random(8)),
                    'status' => $request->status,
                ]);

                // Upload documents
                foreach ($request->file('documents') as $type => $files) {
                    $files = is_array($files) ? $files : [$files];
                    $latestVersion = ZoningDocument::where('zoning_application_id', $application->id)->where('document_type', $type)->max('version');

                    $newVersion = $latestVersion ? $latestVersion + 1 : 1; // auto-increment
                    foreach ($files as $file) {
                        $path = $file->store('zoning_documents', 'public');

                        ZoningDocument::create([
                            'id' => (string) Str::uuid(),
                            'zoning_application_id' => $application->id,
                            'document_type' => $type,
                            'version' => $newVersion,
                            'file_path' => $path,
                        ]);
                    }
                }
            });

            $application = ZoningApplication::with('user')->find($application->id);
            // dd($application->relationLoaded('user'), $application->user, $application->user->email);
            try {
                Mail::to($application->user->email)->send(new ZoningApplicationSubmitted($application));
            } catch (\Exception $e) {
                \Log::error('Mail sending failed: '.$e->getMessage());

                return redirect()->back()->with('error', 'Failed to send confirmation email.');
            }

            return redirect()->back()->with('success', 'Zoning Application submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Zoning Application store failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            return redirect()->back()->with('error', 'Failed to submit Zoning Application. Please try again.');
        }
    }

    public function show($id)
    {
        $application = ZoningApplication::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('applicant.zoning.zoning_application_view', compact('application'));
    }

    public function resubmit($id)
    {
        $application = ZoningApplication::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // dd($application);

        if ($application->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        if ($application->status !== 'resubmit') {
            abort(403, 'This application is not allowed for resubmission.');
        }

        return view('applicant.zoning.resubmit.resubmit_doc', compact('application'));
    }

    public function doc_resubmit(Request $request, $id)
    {
        $request->validate([
            'documents.vicinity_map' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.lot_plan' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.proof_of_ownership' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.ctc' => 'required|file|mimes:pdf,jpg,png|max:40000',

            'documents.authorization_letter' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
            'documents.other_doc' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
        ]);

        $application = ZoningApplication::findOrFail($id);

        if ($application->status !== 'resubmit') {
            abort(403, 'This application cannot be resubmitted.');
        }

        $latestVersion = ZoningDocument::where('zoning_application_id', $application->id)->max('version');
        $newVersion = ($latestVersion ?? 1) + 1;

        foreach ($request->file('documents') as $type => $files) {
            $files = is_array($files) ? $files : [$files];

            foreach ($files as $file) {
                $path = $file->store('zoning_documents', 'public');

                ZoningDocument::create([
                    'id' => (string) Str::uuid(),
                    'zoning_application_id' => $application->id,
                    'document_type' => $type,
                    'version' => $newVersion,
                    'file_path' => $path,
                ]);
            }
        }

        // After resubmission, move status back to under_review
        $application->update(['status' => 'under_review']);

        return redirect()
            ->route('applicant.zoning.zoning_application_view', $application->id)
            ->with('success', 'Documents resubmitted successfully.');

    }

    // Zoning Documents Review
    public function zoningApplicationDoc()
    {
        $user = Auth::user();

        $roleResponsibilities = [
            'zoning_officer' => ['zoning_clearance', 'land_use_certificate'],
            'sanitary_officer' => ['environmental_clearance', 'sanitation_plan'],
            'obo' => ['dos', 'crptx', 'SPA', 'bfp_certificate', 'optional'],
        ];

        $role = $user->role ?? null;
        $docTypes = $roleResponsibilities[$role] ?? [];

        if (empty($docTypes)) {
            return redirect()->back()->with('error', 'No assigned document type(s) for your role.');
        }
        $documents = BuildingDocument::with(['application', 'application.user'])
            ->whereIn('document_type', $docTypes)
            ->where('status', 'pending')
            ->get();

        return view('zoning_officer.zoning_document', compact('documents', 'user'));
    }

    public function reviewMultiple(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'documents' => 'required|array',
            'documents.*.id' => 'required|uuid|exists:building_documents,id',
            'documents.*.status' => 'required|string|in:approved,rejected,resubmit',
            'documents.*.remarks' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        DB::beginTransaction();

        try {
            foreach ($validated['documents'] as $docData) {
                $document = BuildingDocument::find($docData['id']);

                $document->status = $docData['status'];
                $document->remarks = $docData['remarks'] ?? null;
                $document->reviewed_by = $user->id;
                // $document->reviewed_at = now();
                $document->save();
            }

            DB::commit();

            return back()->with('success', 'Documents reviewed successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()->with('error', 'Something went wrong while reviewing documents.');
        }
    }

    public function reviewZoningDoc(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'documents' => 'required|array',
            'documents.*.id' => 'required|uuid|exists:zoning_documents,id',
            'documents.*.status' => 'required|string|in:approved,rejected,resubmit',
            'documents.*.remarks' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        DB::beginTransaction();

        try {
            foreach ($validated['documents'] as $docData) {
                $document = ZoningDocument::find($docData['id']);

                $document->status = $docData['status'];
                $document->remarks = $docData['remarks'] ?? null;
                $document->reviewed_by = $user->id;
                // $document->reviewed_at = now();
                $document->save();
            }

            DB::commit();

            return back()->with('success', 'Documents reviewed successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()->with('error', 'Something went wrong while reviewing documents.');
        }
    }
}
