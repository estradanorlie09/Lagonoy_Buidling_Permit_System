<?php

namespace App\Http\Controllers;

use App\Models\BuildingDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfessionalController extends Controller
{
    public function buildingApplication()
    {
        $user = Auth::user();

        $professionResponsibilities = [
            'architect' => ['architecture_plans', 'estimated_cost'],
            'civil_engineer' => ['structure_plans', 'estimated_cost'],
            'electrical_engineer' => ['electrical_plans', 'electronics_plans'],
            'sanitary_engineer' => ['Environmental_clearance'],
            'mechanical_engineer' => ['mechanical_plans'],
            'master_plumber' => ['plumbing_plans'],
            'geodetic_engineer' => ['site_plan'],
        ];

        $docTypes = $professionResponsibilities[$user->profession] ?? [];

        if (empty($docTypes)) {
            return redirect()->back()->with('error', 'No assigned document type(s) for your profession.');
        }

        $documents = BuildingDocument::with(['application', 'application.user'])
            ->whereIn('document_type', $docTypes)
            ->where('status', 'pending')
            ->get();

        return view('professional.buildingApplications', compact('documents', 'user'));
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
