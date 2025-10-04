<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Services\LocationService;
use App\Models\ZoningApplication;
use App\Models\Visitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Utils\StringHelper;

class ApplicantController extends Controller
{
    public function records()
    {
        return view('applicant.records');
    }

    public function schedule()
    {
        return view('applicant.calendar.schedule');
    }

   public function getVisitationEvents()
{
    $visitations = Visitation::whereHas('application', function($q) {
        $q->where('user_id', auth()->id()); 
    })->get();

    $events = $visitations->map(function ($visitation) {
        return [
            'id'    => $visitation->id,
            'title' => 'Visitation - ' . $visitation->application->application_no,
            'start' => $visitation->visit_date . 'T' . $visitation->visit_time,
            'status' => $visitation->status,
            'remarks' => $visitation->remarks,
            'color' => match($visitation->status) {
                'completed' => '#16a34a',   // green
                'cancelled' => '#dc2626',   // red
                'rescheduled' => '#f59e0b', // yellow
                'absent' => '#6b7280',      // gray
                default => '#2563eb',       // blue
            },
        ];
    });

    return response()->json($events);
}


    public function safety()
    {
        // $users = User::all();
        return view('applicant.safety');
    }
    public function permit()
    {
        // $users = User::all();
        return view('applicant.permit');
    }
    public function setting()
    {
        // $users = User::all();
        return view('applicant.setting');
    }
    
    public function zoning_page()
    {
       $applications = ZoningApplication::with('property')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        return view('applicant.zoning.zoning_page', compact('applications'));
    }
    public function update_profile()
    {
        $locations = new LocationService();
        $regionCode = '05';

        $user = auth()->user();

        $provinceRaw = $user->province ?? '';
        $municipalityRaw = $user->municipality ?? '';

        // Normalize user data
        $provinceName = StringHelper::normalizeName($provinceRaw);
        $municipalityName = StringHelper::normalizeName($municipalityRaw);

        $provincesRaw = $locations->getProvincesByRegion($regionCode);

        $originalProvinceKey = null;
        foreach ($provincesRaw as $key => $_) {
            if (StringHelper::normalizeName($key) === $provinceName) {
                $originalProvinceKey = $key;
                break;
            }
        }

        $municipalitiesRaw = [];
        $barangays = [];

        if ($originalProvinceKey !== null) {
            $municipalitiesRaw = $locations->getMunicipalities($regionCode, $originalProvinceKey);

            $originalMunicipalityKey = null;
            foreach ($municipalitiesRaw as $key => $_) {
                if (StringHelper::normalizeName($key) === $municipalityName) {
                    $originalMunicipalityKey = $key;
                    break;
                }
            }

            if ($originalMunicipalityKey !== null) {
                $barangays = $locations->getBarangays($regionCode, $originalProvinceKey, $originalMunicipalityKey);
            }
        }

        // dd($provinceRaw, $municipalityRaw, $originalProvinceKey, $originalMunicipalityKey, $barangays);

        return view('applicant.forms.profile.update_form', [
            'provinces' => $provincesRaw,
            'municipalities' => $municipalitiesRaw,
            'barangays' => $barangays,
            'regionCode' => $regionCode,
        ]);
    }

    public function form()
    {
        $locations = new LocationService();
        $regionCode = '05'; // Region V - Bicol

        // Get provinces only from Region V
        $provinces = $locations->getProvincesByRegion($regionCode);

        return view('applicant.forms.form', compact('provinces', 'regionCode'));
    }

    public function zoning_form()
    {
        $locations = new LocationService();
        $regionCode = '05'; // Region V - Bicol

        // Get provinces only from Region V
        $provinces = $locations->getProvincesByRegion($regionCode);

        $user = auth()->user();

        $provinceRaw = $user->province ?? '';
        $municipalityRaw = $user->municipality ?? '';

        // Normalize user data
        $provinceName = StringHelper::normalizeName($provinceRaw);
        $municipalityName = StringHelper::normalizeName($municipalityRaw);

        $provincesRaw = $locations->getProvincesByRegion($regionCode);

        $originalProvinceKey = null;
        foreach ($provincesRaw as $key => $_) {
            if (StringHelper::normalizeName($key) === $provinceName) {
                $originalProvinceKey = $key;
                break;
            }
        }

        $municipalitiesRaw = [];
        $barangays = [];

        if ($originalProvinceKey !== null) {
            $municipalitiesRaw = $locations->getMunicipalities($regionCode, $originalProvinceKey);

            $originalMunicipalityKey = null;
            foreach ($municipalitiesRaw as $key => $_) {
                if (StringHelper::normalizeName($key) === $municipalityName) {
                    $originalMunicipalityKey = $key;
                    break;
                }
            }

            if ($originalMunicipalityKey !== null) {
                $barangays = $locations->getBarangays($regionCode, $originalProvinceKey, $originalMunicipalityKey);
            }
        }


        return view('applicant.forms.zoning.zoning_form', compact('provinces', 'regionCode'),[
            'municipalities' => $municipalitiesRaw,
            'barangays' => $barangays,
        ]);
    }

    public function getMunicipalities(Request $request)
    {
        $province = $request->province;
        if (!$province) {
            return response()->json([], 400); // Bad request
        }

        $locations = new LocationService();
        $municipalities = $locations->getMunicipalities('05', $province);

        return response()->json($municipalities);
    }

    public function getBarangays(Request $request)
    {
        $province = $request->province;
        $municipality = $request->municipality;

        if (!$province || !$municipality) {
            return response()->json([], 400); // Bad request
        }

        $locations = new LocationService();
        $barangays = $locations->getBarangays('05', $province, $municipality);

        return response()->json($barangays);
    }
}
