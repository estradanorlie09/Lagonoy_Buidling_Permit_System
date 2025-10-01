<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZoningApplication;
use App\Models\ApplicationRemark;
use Illuminate\Support\Facades\Auth;

class OboController extends Controller
{
    public function zoning_records(){
        $applications = ZoningApplication::all();
        return view('obo.zoning_records', compact('applications'));
    }

    public function approve(Request $request, $id)
    {
      $request->validate([
        'remarks' => 'required|string|max:1000',
    ]);

    $application = ZoningApplication::findOrFail($id);
    $application->status = 'approved';
    $application->save();

    ApplicationRemark::create([
        'officer_id' => Auth::id(),             
        'zoning_application_id'=> $application->id, 
        'remark' => $request->remarks,
    ]);

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
