<?php

namespace App\Http\Controllers;

use App\Models\ApplicationRemark;
use App\Models\BuildingApplication;
use App\Models\BuildingDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OboOfficialController extends Controller
{
    public function BuildingApplicationRecord()
    {
        $applications = BuildingApplication::all();

        return view('obo.building_application', compact('applications'));
    }

    public function show($id)
    {

        $application = BuildingApplication::where('id', $id)->firstOrFail();
        if ($application->status === 'submitted') {
            $application->update(['status' => 'under_review']);
        }

        return view('obo.obo.building_view', compact('application'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = BuildingApplication::findOrFail($id);
        $application->status = 'approved';
        $application->approved_by = Auth::id();
        $application->building_permit_no = 'BLDGP-'.strtoupper(Str::random(8));
        $application->issued_date = now();
        $application->expiration_date = now()->addYear();
        $application->save();

        ApplicationRemark::create([
            'officer_id' => Auth::id(),
            'building_application_id' => $application->id,

            'remark' => $request->remarks,
        ]);

        // Mail::to($application->user->email)->send(new SanitaryApplicationApproved($application));

        return redirect()->back()->with('success', 'Application sent back for resubmission with remarks.');
    }

    public function disapprove(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = BuildingApplication::findOrFail($id);
        $application->status = 'disapproved';
        $application->save();

        ApplicationRemark::create([
            'officer_id' => Auth::id(),
            'building_application_id' => $application->id,
            'remark' => $request->remarks,
        ]);

        $application->load('remarks');

        $latestTime = $application->remarks->max('created_at');
        $currentRemarks = $application->remarks->where('created_at', $latestTime)->values();

        // Mail::to($application->user->email)
        //     ->send(new SanitaryApplicationDisapproved($application, $currentRemarks));

        return redirect()->back()->with('success', 'Application sent back for disapproval with remarks.');
    }

    public function resubmit(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = BuildingApplication::findOrFail($id);
        $application->status = 'resubmit';
        $application->save();

        ApplicationRemark::create([
            'officer_id' => Auth::id(),
            'building_application_id' => $application->id,
            'remark' => $request->remarks,
        ]);
        $application->load('remarks');

        $latestTime = $application->remarks->max('created_at');
        $currentRemarks = $application->remarks->where('created_at', $latestTime)->values();

        // Mail::to($application->user->email)
        //     ->send(new SanitaryApplicationResubmit($application, $currentRemarks));

        return redirect()->back()->with('success', 'Application sent back for resubmission with remarks.');
    }

    public function buildingApplicationDoc()
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

        return view('obo.building_document', compact('documents', 'user'));
    }

    public function reviewMultiple(Request $request)
    {
        $validated = $request->validate([
            'documents' => 'required|array',
            'documents.*.id' => 'required|uuid|exists:building_documents,id',
            'documents.*.status' => 'required|string|in:approved,rejected,resubmit',
            'documents.*.remarks' => 'nullable|string|max:500',
        ]);
        // dd($validated);

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
}
