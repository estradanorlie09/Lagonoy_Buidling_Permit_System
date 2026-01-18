<?php

namespace App\Http\Controllers;

use App\Mail\ScheduleAbsent;
use App\Mail\ScheduleApproved;
use App\Mail\ScheduleCancelEmail;
use App\Mail\ScheduleEmail;
use App\Mail\ScheduleRescheduleEmail;
use App\Mail\ZoningApplicationDisapproved;
use App\Mail\ZoningApplicationResubmit;
use App\Mail\ZoningApproved;
use App\Models\ApplicationRemark;
use App\Models\Visitation;
use App\Models\ZoningApplication;
use App\Models\ZoningDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OboController extends Controller
{
   

    public function zoning_records()
    {
        $applications = ZoningApplication::all();

        return view('zoning_officer.zoning_records', compact('applications'));
    }

    public function schedule()
    {
        $data = DB::table('zoning_applications')
            ->join('users', 'zoning_applications.user_id', '=', 'users.id')
            ->leftJoin('visitations', 'zoning_applications.id', '=', 'visitations.zoning_application_id')
            ->whereIn('zoning_applications.status', ['submitted', 'under_review'])
            ->select(
                'zoning_applications.id as application_id',
                'zoning_applications.application_no',
                'zoning_applications.status as application_status',
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

        return view('zoning_officer.schedule_visitation', compact('applications'));
    }

    public function scheduleVisit(Request $request, $applicationId)
    {
        // Validate input
        $request->validate([
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required',
            'remarks' => 'nullable|string|max:500',
        ]);

        $application = ZoningApplication::findOrFail($applicationId);

        $visitDateTime = Carbon::parse($request->visit_date.' '.$request->visit_time);

        if ($visitDateTime->lessThan(Carbon::now())) {
            return redirect()->back()->with('error', 'You cannot set a time earlier than the current time today.');
        }

        $exists = Visitation::where('visit_date', $request->visit_date)
            ->where('visit_time', $request->visit_time)
            ->whereNotNull('zoning_application_id')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This time slot is already taken by another zoning applicant.');
        }

        Visitation::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'zoning_application_id' => $application->id,
            'scheduled_by' => Auth::id(),
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'remarks' => $request->remarks,
        ]);

        $application->load('visitation');

        Mail::to($application->user->email)
            ->send(new ScheduleEmail($application));

        return redirect()->back()->with('success', 'Zoning visit scheduled successfully.');
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'visit_date' => 'required|date',
            'visit_time' => 'required',
            'remarks' => 'nullable|string',
        ]);

        //  dd($request);
        $application = ZoningApplication::findOrFail($id);

        // Check if visitation exists for this application
        $visitation = $application->visitation;

        if ($visitation) {
            // update existing visitation
            $visitation->update([
                'visit_date' => $request->visit_date,
                'visit_time' => $request->visit_time,
                'status' => 'cancelled',
                'remarks' => $request->remarks,
            ]);
        } else {
            // create new visitation if none exists
            $application->visitation()->create([
                'visit_date' => $request->visit_date,
                'visit_time' => $request->visit_time,
                'status' => 'cancelled',
                'remarks' => $request->remarks,
            ]);
        }

        $application->load('visitation');
        // Send cancellation email
        Mail::to($application->user->email)
            ->send(new ScheduleCancelEmail($application));

        return redirect() - back() - with('success', 'Visitation Cancelled');
    }

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'visit_date' => 'required|date',
            'visit_time' => 'required',
            'remarks' => 'nullable|string',
        ]);

        $application = ZoningApplication::findOrFail($id);

        $visitation = $application->visitation;

        $visitDateTime = Carbon::parse($request->visit_date.' '.$request->visit_time);
        if ($visitDateTime->lessThan(Carbon::now())) {
            return redirect()->back()->with('error', 'You cannot set a time earlier than the current time today.');
        }

        $exists = Visitation::where('visit_date', $request->visit_date)
            ->where('visit_time', $request->visit_time)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This time slot is already taken by another applicant.');
        }

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

        Mail::to($application->user->email)
            ->send(new ScheduleRescheduleEmail($application));

        return redirect()->back()->with('success', 'Visitation Rescheduled');
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

            if ($visitation->application && $visitation->application->user) {
                $email = $visitation->application->user->email;

                match ($request->status) {
                    'cancelled' => Mail::to($email)->queue(new ScheduleCancelEmail($visitation->application, $visitation)),
                    'absent' => Mail::to($email)->queue(new ScheduleAbsent($visitation->application, $visitation)),
                    'completed' => Mail::to($email)->queue(new ScheduleApproved($visitation->application, $visitation)),
                    default => null,
                };
            }

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

    public function approve(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = ZoningApplication::findOrFail($id);
        $application->status = 'approved';
        $application->approved_by = Auth::id();
        $application->save();

        ApplicationRemark::create([
            'officer_id' => Auth::id(),
            'zoning_application_id' => $application->id,
            'remark' => $request->remarks,
        ]);

        Mail::to($application->user->email)->send(new ZoningApproved($application));

        return redirect()->back()->with('success', 'Application sent back for resubmission with remarks.');
    }

    public function disapprove(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = ZoningApplication::findOrFail($id);
        $application->status = 'disapproved';
        $application->save();

        // Save new remark
        ApplicationRemark::create([
            'officer_id' => Auth::id(),
            'zoning_application_id' => $application->id,
            'remark' => $request->remarks,
        ]);

        $application->load('remarks');

        $latestTime = $application->remarks->max('created_at');
        $currentRemarks = $application->remarks->where('created_at', $latestTime);

        Mail::to($application->user->email)
            ->send(new ZoningApplicationDisapproved($application, $currentRemarks));

        return redirect()->back()->with('success', 'Application sent back for disapproved with remarks.');
    }

    public function resubmit(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = ZoningApplication::findOrFail($id);
        $application->status = 'resubmit';
        $application->save();

        // Save new remark
        ApplicationRemark::create([
            'officer_id' => Auth::id(),
            'zoning_application_id' => $application->id,
            'remark' => $request->remarks,
        ]);

        $application->load('remarks');

        $latestTime = $application->remarks->max('created_at');
        $currentRemarks = $application->remarks->where('created_at', $latestTime);

        Mail::to($application->user->email)
            ->send(new ZoningApplicationResubmit($application, $currentRemarks));

        return redirect()->back()->with('success', 'Application sent back for resubmission with remarks.');
    }

    public function show($id)
    {
        $user = Auth::user();
        $application = ZoningApplication::where('id', $id)->firstOrFail();

        //  dd($application);
        if ($application->status === 'submitted') {
            $application->update(['status' => 'under_review']);
        }

        $roleResponsibilities = [
            'zoning_officer' => ['vicinity_map', 'lot_plan', 'proof_of_ownership', 'CTC'],
        ];

        $role = $user->role ?? null;
        $docTypes = $roleResponsibilities[$role] ?? [];

        if (empty($docTypes)) {
            return redirect()->back()->with('error', 'No assigned document type(s) for your role.');
        }
        $documents = ZoningDocument::with(['application', 'application.user'])
            ->whereIn('document_type', $docTypes)
            ->where('status', 'pending')
            ->get();

        return view('zoning_officer.zoning.zoning_view_record', compact('application', 'documents', 'user'));
    }
}
