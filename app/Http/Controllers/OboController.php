<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZoningApplication;
use App\Models\ApplicationRemark;
use App\Models\Visitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ZoningApproved;
use App\Mail\ScheduleEmail;
use App\Mail\ScheduleCancelEmail;
use App\Mail\ScheduleRescheduleEmail;


class OboController extends Controller
{
    public function zoning_records(){
        $applications = ZoningApplication::all();
        return view('obo.zoning_records', compact('applications'));
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


    return view('obo.schedule_visitation', compact('applications'));
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

       Visitation::create([
            'id' => \Illuminate\Support\Str::uuid(), // generate UUID
            'zoning_application_id'=> $application->id,
            'scheduled_by' => Auth::id(),
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'remarks' => $request->remarks,
        ]);

        Mail::to($application->user->email)->send(new ScheduleEmail($application));

        return redirect()->back()->with('success', 'Zoning visit scheduled successfully.');
    }


public function cancel(Request $request, $id)
{
    $request->validate([
        'visit_date' => 'required|date',
        'visit_time' => 'required',
        'remarks'    => 'nullable|string',
    ]);

    $application = ZoningApplication::findOrFail($id);

    // Check if visitation exists for this application
    $visitation = $application->visitation;

    if ($visitation) {
        // update existing visitation
        $visitation->update([
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'status'     => 'cancelled',
            'remarks'    => $request->remarks,
        ]);
    } else {
        // create new visitation if none exists
        $application->visitation()->create([
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'status'     => 'cancelled',
            'remarks'    => $request->remarks,
        ]);
    }

     // Send cancellation email
    Mail::to($application->user->email)
        ->send(new ScheduleCancelEmail($application));


    return redirect()-back()-with('success','Visitation Cancelled');
}

public function reschedule(Request $request, $id)
{
    $request->validate([
        'visit_date' => 'required|date',
        'visit_time' => 'required',
        'remarks'    => 'nullable|string',
    ]);

    $application = ZoningApplication::findOrFail($id);

 
    $visitation = $application->visitation;

    if ($visitation) {
      
        $visitation->update([
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'status'     => 'rescheduled',
            'remarks'    => $request->remarks,
        ]);
    } else {
       
        $application->visitation()->create([
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'status'     => 'scheduled',
            'remarks'    => $request->remarks,
        ]);
    }

   
    Mail::to($application->user->email)
        ->send(new ScheduleRescheduleEmail($application));

    return redirect()->back()->with('success','Visitation Rescheduled');
}

public function updateStatus(Request $request, $id)
{
    try {
        $request->validate([
            'status' => 'required|in:completed,absent,cancelled'
        ]);

        $visitation = Visitation::findOrFail($id);
        $visitation->update(['status' => $request->status]);

        if($request->status == 'completed'){
            $visitation->update(['status' => $request->status, 'remarks'=>'Visitation Completed']);
        }

        if($request->status == 'cancelled'){
            $visitation->update(['status' => $request->status, 'remarks'=>'Visitation Canceled']);
        }

         if($request->status == 'absent'){
            $visitation->update(['status' => $request->status, 'remarks'=>'No Show / Absent']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Visitation marked as ' . str_replace('_', ' ', $request->status) . '.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong: ' . $e->getMessage(),
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
        'zoning_application_id'=> $application->id, 
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

    ApplicationRemark::create([
        'officer_id' => Auth::id(),               
        'zoning_application_id'=> $application->id,
        'remark' => $request->remarks,
    ]);

    return redirect()->back()->with('success', 'Application sent back for resubmission with remarks.');
}

public function resubmit(Request $request, $id)
{
    $request->validate([
        'remarks' => 'required|string|max:1000',
    ]);

    $application = ZoningApplication::findOrFail($id);
    $application->status = 'resubmit';
    $application->save();

    ApplicationRemark::create([
        'officer_id' => Auth::id(),               // numeric ID
        'zoning_application_id'=> $application->id, // use ID, not model
        'remark' => $request->remarks,
    ]);

    return redirect()->back()->with('success', 'Application sent back for resubmission with remarks.');
}


public function show($id)
{
    
    $application = ZoningApplication::where('id', $id)->firstOrFail();
    if ($application->status === 'submitted') {
        $application->update(['status' => 'under_review']);
    }

   
    return view('obo.zoning.zoning_view_record', compact('application'));
}


}
