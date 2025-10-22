<?php

namespace App\Http\Controllers;

use App\Mail\SanitaryApplicationApproved;
use App\Mail\SanitaryApplicationDisapproved;
use App\Mail\SanitaryApplicationResubmit;
use App\Mail\SanitaryApplicationSubmitted;
use App\Models\ApplicationRemark;
use App\Models\SanitaryApplication;
use App\Models\SanitaryDocument;
use App\Models\SanitaryProperty;
use App\Models\Visitation;
use App\Services\LocationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SanitaryContoller extends Controller
{
    public function sanitary_form()
    {

        $locations = new LocationService;
        $regionCode = '05'; // Region V - Bicol

        // Get provinces only from Region V
        $provinces = $locations->getProvincesByRegion($regionCode);

        return view('applicant.forms.sanitary.sanitaryForm', compact('provinces', 'regionCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'occupancy_type' => 'required|string|max:255',
            'property_address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'comments' => 'nullable|string',
            'status' => 'required|in:submitted,approved,disapproved,resubmit,under_review',

            'documents.plumbing_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.bill' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.specification' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.location' => 'required|file|mimes:pdf,jpg,png|max:40000',

            'documents.health_related_cert' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
            'documents.other_doc' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
        ]);

        // dd($request);
        try {
            $application = null;

            DB::transaction(function () use ($request, &$application) {
                // Create property
                $property = SanitaryProperty::create([
                    'id' => (string) Str::uuid(),
                    'occupancy_type	' => $request->occupancy_type,
                    'property_address' => $request->property_address,
                    'province' => $request->province,
                    'municipality' => $request->municipality,
                    'barangay' => $request->barangay,
                    'comments' => $request->comments,
                ]);

                // Create application
                $application = SanitaryApplication::create([
                    'id' => (string) Str::uuid(),
                    'user_id' => auth()->id(),
                    'property_id' => $property->id,
                    'application_no' => 'SNT-'.strtoupper(Str::random(8)),
                    'status' => $request->status,
                ]);

                // Upload documents
                foreach ($request->file('documents') as $type => $files) {
                    $files = is_array($files) ? $files : [$files];
                    $latestVersion = SanitaryDocument::where('sanitary_application_id', $application->id)->where('document_type', $type)->max('version');

                    $newVersion = $latestVersion ? $latestVersion + 1 : 1; // auto-increment
                    foreach ($files as $file) {
                        $path = $file->store('sanitary_documents', 'public');

                        SanitaryDocument::create([
                            'id' => (string) Str::uuid(),
                            'sanitary_application_id' => $application->id,
                            'document_type' => $type,
                            'version' => $newVersion,
                            'file_path' => $path,
                        ]);
                    }
                }
            });

            $application = SanitaryApplication::with('user')->find($application->id);
            // dd($application->relationLoaded('user'), $application->user, $application->user->email);
            try {
                Mail::to($application->user->email)->send(new SanitaryApplicationSubmitted($application));
            } catch (\Exception $e) {
                \Log::error('Mail sending failed: '.$e->getMessage());

                return redirect()->back()->with('error', 'Failed to send confirmation email.');
            }

            return redirect()->back()->with('success', 'Sanitary Application submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Sanitary Application store failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            return redirect()->back()->with('error', 'Failed to submit Zoning Application. Please try again.');
        }
    }

    public function show($id)
    {
        $application = SanitaryApplication::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('applicant.sanitary.sanitary_application_view', compact('application'));
    }






    // Sanitary Officer
    public function sanitary_records()
    {
        $applications = SanitaryApplication::all();

        return view('sanitary_officer.sanitary_records', compact('applications'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = SanitaryApplication::findOrFail($id);
        $application->status = 'approved';
        $application->approved_by = Auth::id();
        $application->save();

        ApplicationRemark::create([
            'officer_id' => Auth::id(),
            'sanitary_application_id' => $application->id,
            'remark' => $request->remarks,
        ]);

        Mail::to($application->user->email)->send(new SanitaryApplicationApproved($application));

        return redirect()->back()->with('success', 'Application sent back for resubmission with remarks.');
    }

    public function disapprove(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = SanitaryApplication::findOrFail($id);
        $application->status = 'disapproved';
        $application->save();

        ApplicationRemark::create([
            'officer_id' => Auth::id(),
            'sanitary_application_id' => $application->id,
            'remark' => $request->remarks,
        ]);

        $application->load('remarks');

        $latestTime = $application->remarks->max('created_at');
        $currentRemarks = $application->remarks->where('created_at', $latestTime)->values();

        Mail::to($application->user->email)
            ->send(new SanitaryApplicationDisapproved($application, $currentRemarks));

        return redirect()->back()->with('success', 'Application sent back for disapproval with remarks.');
    }

    public function resubmit(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = SanitaryApplication::findOrFail($id);
        $application->status = 'resubmit';
        $application->save();

        ApplicationRemark::create([
            'officer_id' => Auth::id(),               // numeric ID
            'sanitary_application_id' => $application->id, // use ID, not model
            'remark' => $request->remarks,
        ]);
        $application->load('remarks');

        $latestTime = $application->remarks->max('created_at');
        $currentRemarks = $application->remarks->where('created_at', $latestTime)->values();

        Mail::to($application->user->email)
            ->send(new SanitaryApplicationResubmit($application, $currentRemarks));

        return redirect()->back()->with('success', 'Application sent back for resubmission with remarks.');
    }

    public function show_sanitary($id)
    {

        $application = SanitaryApplication::where('id', $id)->firstOrFail();
        if ($application->status === 'submitted') {
            $application->update(['status' => 'under_review']);
        }

        return view('sanitary_officer.sanitary.sanitary_view_record', compact('application'));
    }
    // public function show_sanitary($id)
    // {
    //     $application = SanitaryApplication::findOrFail($id);

    //     // If applicant is logged in, only allow if they own the record
    //     if (auth()->user()->role === 'applicant' && $application->user_id !== auth()->id()) {
    //         abort(403, 'Unauthorized');
    //     }

    //     return view('sanitary_officer.sanitary.sanitary_view_record', compact('application'));
    // }

    public function resubmit_doc($id)
    {
        $application = SanitaryApplication::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($application->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        if ($application->status !== 'resubmit') {
            abort(403, 'This application is not allowed for resubmission.');
        }

        return view('applicant.sanitary.resubmit.resubmit_doc', compact('application'));
    }

    public function doc_resubmit(Request $request, $id)
    {
        $request->validate([

            'documents.plumbing_plans' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.bill' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.specification' => 'required|file|mimes:pdf,jpg,png|max:40000',
            'documents.location' => 'required|file|mimes:pdf,jpg,png|max:40000',

            'documents.health_related_cert' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
            'documents.other_doc' => 'nullable|file|mimes:pdf,jpg,png|max:40000',
        ]);

        $application = SanitaryApplication::findOrFail($id);

        if ($application->status !== 'resubmit') {
            abort(403, 'This application cannot be resubmitted.');
        }

        $latestVersion = SanitaryDocument::where('sanitary_application_id', $application->id)->max('version');
        $newVersion = ($latestVersion ?? 1) + 1;

        foreach ($request->file('documents') as $type => $files) {
            $files = is_array($files) ? $files : [$files];

            foreach ($files as $file) {
                $path = $file->store('sanitary_documents', 'public');

                SanitaryDocument::create([
                    'id' => (string) Str::uuid(),
                    'sanitary_application_id' => $application->id,
                    'document_type' => $type,
                    'version' => $newVersion,
                    'file_path' => $path,
                ]);
            }
        }

        // After resubmission, move status back to under_review
        $application->update(['status' => 'under_review']);

        return redirect()
            ->route('applicant.sanitary.sanitary_application_view', $application->id)
            ->with('success', 'Documents resubmitted successfully.');

    }

    public function schedule()
    {
        $data = DB::table('sanitary_applications')
            ->join('users', 'sanitary_applications.user_id', '=', 'users.id')
            ->leftJoin('visitations', 'sanitary_applications.id', '=', 'visitations.sanitary_application_id')
            ->whereIn('sanitary_applications.status', ['submitted', 'under_review'])
            ->select(
                'sanitary_applications.id as application_id',
                'sanitary_applications.application_no',
                'sanitary_applications.status as application_status',
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

        return view('sanitary_officer.sanitary_visitation', compact('applications'));
    }

    public function scheduleVisit(Request $request, $applicationId)
    {
        $request->validate([
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required',
            'remarks' => 'nullable|string|max:500',
        ]);

        $application = SanitaryApplication::findOrFail($applicationId);

        $visitDateTime = Carbon::parse($request->visit_date.' '.$request->visit_time);

        if ($visitDateTime->lessThan(Carbon::now())) {
            return redirect()->back()->with('error', 'You cannot set a time earlier than the current time today.');
        }

        // Only check other sanitary visits
        $exists = Visitation::where('visit_date', $request->visit_date)
            ->where('visit_time', $request->visit_time)
            ->whereNotNull('sanitary_application_id')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This time slot is already taken by another sanitary applicant.');
        }

        Visitation::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'sanitary_application_id' => $application->id,
            'scheduled_by' => Auth::id(),
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()->with('success', 'Sanitary visit scheduled successfully.');
    }

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'visit_date' => 'required|date',
            'visit_time' => 'required',
            'remarks' => 'nullable|string',
        ]);

        $application = SanitaryApplication::findOrFail($id);
        $visitation = $application->visitation;

        $visitDateTime = Carbon::parse($request->visit_date.' '.$request->visit_time);
        if ($visitDateTime->lessThan(Carbon::now())) {
            return redirect()->back()->with('error', 'You cannot set a time earlier than the current time today.');
        }

        // Conflict check: only other Zoning visits, ignore current visit
        $exists = Visitation::where('visit_date', $request->visit_date)
            ->where('visit_time', $request->visit_time)
            ->whereNotNull('sanitary_application_id') // only check zoning visits
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
