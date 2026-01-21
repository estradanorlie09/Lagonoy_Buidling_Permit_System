<?php

namespace App\Http\Controllers;

use App\Models\ApplicantLog;
use App\Models\ApplicationRemark;
use App\Models\BuildingApplication;
use App\Models\BuildingDocument;
use App\Models\User;
use App\Models\Visitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OboOfficialController extends Controller
{
    public function login()
    {
        return view('obo.auth.login');
    }

    public function BuildingApplicationRecord()
    {
        $applications = BuildingApplication::all();

        return view('obo.building_application', compact('applications'));
    }

    public function BuildingApplicantRecord()
    {
        $records = User::where('role', 'applicant')->get();

        $approvedCount = User::where('role', 'applicant')
            ->where('pre_registration_status', 'approved')
            ->count();

        $pendingCount = User::where('role', 'applicant')
            ->where('pre_registration_status', 'pending')
            ->count();

        $rejectedCount = User::where('role', 'applicant')
            ->where('pre_registration_status', 'rejected')
            ->count();

        return view('obo.applicant_record', compact(
            'records',
            'approvedCount',
            'pendingCount',
            'rejectedCount'
        ));
    }

    public function show_applicant_record($id)
    {
        $applicant = User::where('id', $id)->firstOrFail();

        // Fetch logs for this applicant, latest first
        $applicantlogs = ApplicantLog::with('user')
            ->where('applicant_id', $id)
            ->latest()
            ->first(); // only the latest log

        return view('obo.obo.view_applicant_records', compact('applicant', 'applicantlogs'));
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

    // Approved | Reject Applicant
    public function approveApplicant(Request $request, User $applicant)
    {
        $previousStatus = $applicant->pre_registration_status;

        $applicant->update([
            'pre_registration_status' => 'approved',
            'rejection_reason' => null,
        ]);

        ApplicantLog::create([
            'applicant_id' => $applicant->id,
            'user_id' => Auth::id(),
            'action' => 'approved',
            'remarks' => 'Previous status: '.$previousStatus,
        ]);

        return back()->with('success', 'Application approved.');
    }

    public function reject(Request $request, User $applicant)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:5',
        ]);

        $previousStatus = $applicant->pre_registration_status;

        // Update applicant
        $applicant->update([
            'pre_registration_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Log the action
        ApplicantLog::create([
            'applicant_id' => $applicant->id,
            'user_id' => Auth::id(),
            'action' => 'rejected',
            'remarks' => 'Previous status: '.$previousStatus.' | Reason: '.$request->rejection_reason,
        ]);

        return back()->with('success', 'Application rejected.');
    }

    // visitations
    public function schedule()
    {
        $data = DB::table('building_applications')
            ->join('users', 'building_applications.user_id', '=', 'users.id')
            ->leftJoin(
                'visitations',
                'building_applications.id',
                '=',
                'visitations.building_application_id'
            )
            ->whereIn('building_applications.status', ['submitted', 'under_review'])
            ->select(
                'building_applications.id as application_id',
                'building_applications.application_no',
                'building_applications.status as application_status',
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'visitations.id as visitation_id',
                'visitations.visit_date',
                'visitations.visit_time',
                'visitations.status as visitation_status',
                'visitations.created_at',
                'visitations.updated_at'
            )
            ->get();

        $applications = $data->groupBy('application_no')
            ->map(function ($group) {
                // Sort group by the max of created_at and updated_at descending
                return $group->sortByDesc(function ($item) {
                    return max(strtotime($item->created_at), strtotime($item->updated_at));
                })->first();
            })
            ->values();

        return view('obo.scheduler.visitation_scheduler', compact('applications'));
    }

    public function scheduleVisit(Request $request, $applicationId)
    {
        $request->validate([
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required',
            'remarks' => 'nullable|string|max:500',
        ]);

        $application = BuildingApplication::findOrFail($applicationId);

        $visitDateTime = Carbon::parse($request->visit_date.' '.$request->visit_time);

        if ($visitDateTime->lessThan(Carbon::now())) {
            return redirect()->back()->with('error', 'You cannot set a time earlier than the current time today.');
        }

        // Only check other building
        $exists = Visitation::where('visit_date', $request->visit_date)
            ->where('visit_time', $request->visit_time)
            ->whereNotNull('building_application_id')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This time slot is already taken!');
        }

        Visitation::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'building_application_id' => $application->id,
            'scheduled_by' => Auth::id(),
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()->with('success', 'Building Official visit scheduled successfully.');
    }

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'visit_date' => 'required|date',
            'visit_time' => 'required',
            'remarks' => 'nullable|string',
        ]);

        $application = BuildingApplication::findOrFail($id);
        $visitation = $application->visitation;

        $visitDateTime = Carbon::parse($request->visit_date.' '.$request->visit_time);
        if ($visitDateTime->lessThan(Carbon::now())) {
            return redirect()->back()->with('error', 'You cannot set a time earlier than the current time today.');
        }

        // Conflict check: only other Zoning visits, ignore current visit
        $exists = Visitation::where('visit_date', $request->visit_date)
            ->where('visit_time', $request->visit_time)
            ->whereNotNull('building_application_id') //
            ->when($visitation, fn ($q) => $q->where('id', '!=', $visitation->id)) // ignore current
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This time slot is already taken by another zoning applicant.');
        }

        // Update or create visitation
        if ($visitation) {
            $visitation->update([
                'visit_date' => $request->visit_date,
                'visit_time' => $request->visit_time,
                'status' => 'rescheduled',
                'remarks' => $request->remarks,
            ]);
        } else {
            $application->visitation()->create([
                'visit_date' => $request->visit_date,
                'visit_time' => $request->visit_time,
                'status' => 'scheduled',
                'remarks' => $request->remarks,
            ]);
        }

        $application->load('visitation');

        // Send email notification
        // Mail::to($application->user->email)
        //     ->send(new ScheduleRescheduleEmail($application));

        return redirect()->back()->with('success', 'Visitation Rescheduled Successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:completed,absent,cancelled',
            ]);

            $visitation = Visitation::findOrFail($id);

            $remarks = match ($request->status) {
                'completed' => 'Visitation Completed',
                'cancelled' => 'Visitation Canceled',
                'absent' => 'No Show / Absent',
                default => null,
            };

            $visitation->update([
                'status' => $request->status,
                'remarks' => $remarks,
            ]);

            $visitation->loadMissing('application.user');

            // if ($visitation->application && $visitation->application->user) {
            //     $email = $visitation->application->user->email;

            //     match ($request->status) {
            //         'cancelled' => Mail::to($email)->queue(new ScheduleCancelEmail($visitation->application, $visitation)),
            //         'absent' => Mail::to($email)->queue(new ScheduleAbsent($visitation->application, $visitation)),
            //         'completed' => Mail::to($email)->queue(new ScheduleApproved($visitation->application, $visitation)),
            //         default => null,
            //     };
            // }

            return response()->json([
                'success' => true,
                'message' => 'Visitation marked as '.ucfirst($request->status).'.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: '.$e->getMessage(),
            ], 500);
        }
    }
}
