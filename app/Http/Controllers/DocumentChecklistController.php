<?php

namespace App\Http\Controllers;

use App\Models\BuildingApplication;
use App\Models\DocChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocumentChecklistController extends Controller
{
    public function index($applicationId)
    {
        $documents = DocChecklist::where('application_id', $applicationId)
            ->with('submitter:id,first_name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $documents,
        ]);
    }

    public function toggle(Request $request, $applicationId)
    {
        $request->validate([
            'document_key' => 'required|string',
            'is_submitted' => 'required|boolean',
            'remarks' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Update or create the document record
            $document = DocChecklist::updateOrCreate(
                [
                    'application_id' => $applicationId,
                    'document_key' => $request->document_key,
                ],
                [
                    'is_submitted' => $request->is_submitted,
                    'submitted_at' => $request->is_submitted ? now() : null,
                    'submitted_by' => $request->is_submitted ? Auth::id() : null,
                    'remarks' => $request->remarks,
                ]
            );

            // Check if all documents are submitted
            $allSubmitted = DocChecklist::where('application_id', $applicationId)
                ->where('is_submitted', false)
                ->count() === 0;

            // If all submitted, update application status to 'payment'
            if ($allSubmitted) {
                $application = BuildingApplication::find($applicationId);
                if ($application && $application->status !== 'payment') {
                    $application->update(['status' => 'payment']);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $request->is_submitted
                    ? 'Document marked as submitted'
                    : 'Document unmarked',
                'allSubmitted' => $allSubmitted, // <-- send to frontend if needed
                'data' => $document->load('submitter:id,first_name'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update document status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function toggleAll(Request $request, $applicationId)
    {
        $request->validate([
            'is_submitted' => 'required|boolean',
            'remarks' => 'nullable|string',
        ]);

        $documentKeys = [
            'architectural_plans',
            'structural_plans',
            'sanitary_plumbing_plans',
            'electrical_plans',
            'mechanical_plans',
            'electronics_alarm_cctv_plans',
            'bill_of_materials_cost_estimates',
            'deed_of_sale_title',
            'current_real_property_tax_receipt',
            'lot_site_plan',
            'authorization_spa',
            'zoning_clearance',
            'fire_safety_clearance_bfp',
            'environmental_clearance_denr',
            'other_required_clearances',
        ];

        try {
            DB::beginTransaction();

            foreach ($documentKeys as $key) {
                DocChecklist::updateOrCreate(
                    [
                        'application_id' => $applicationId,
                        'document_key' => $key,
                    ],
                    [
                        'is_submitted' => $request->is_submitted,
                        'submitted_at' => $request->is_submitted ? now() : null,
                        'submitted_by' => $request->is_submitted ? Auth::id() : null,
                        'remarks' => $request->remarks,
                    ]
                );
            }

            // If all documents are now submitted, update application status to 'payment'
            if ($request->is_submitted) {
                $application = BuildingApplication::find($applicationId);
                if ($application && $application->status !== 'payment') {
                    $application->update(['status' => 'payment']);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $request->is_submitted
                    ? 'All documents marked as submitted'
                    : 'All documents unmarked',
                'allSubmitted' => $request->is_submitted, // can be used in frontend
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update documents',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
