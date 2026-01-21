<?php

namespace App\Http\Controllers;

use App\Models\ApplicantLog;
use App\Models\BuildingApplication;
use App\Models\SanitaryApplication;
use App\Models\User;
use App\Models\Visitation;
use App\Models\ZoningApplication;
use App\Services\LocationService;
use App\Utils\StringHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function schedule()
    {
        return view('applicant.calendar.schedule');
    }

    public function search(Request $request)
    {
        $user = auth()->user(); // Get logged-in user
        $query = $request->get('query');

        // Search in the BuildingApplication model
        $buildingResults = BuildingApplication::where('user_id', $user->id)->where('application_no', 'like', "%{$query}%")
            ->select('id', 'application_no', 'status') // Adjust fields as per your model
            ->limit(10);

        // Search in the ZoningApplication model
        $zoningResults = ZoningApplication::where('user_id', $user->id)->where('application_no', 'like', "%{$query}%")
            ->select('id', 'application_no', 'status') // Adjust fields as per your model
            ->limit(10);

        // Search in the SanitaryApplication model
        $sanitaryResults = SanitaryApplication::where('user_id', $user->id)->where('application_no', 'like', "%{$query}%")
            ->select('id', 'application_no', 'status') // Adjust fields as per your model
            ->limit(10);

        // Combine the results using union
        $results = $buildingResults
            ->union($zoningResults)
            ->union($sanitaryResults)
            ->get();

        return response()->json($results);
    }

    public function getVisitationEvents()
    {
        $visitations = Visitation::whereHas('buildingApplication', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->orWhereHas('sanitaryApplication', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->orWhereHas('zoningApplication', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->orderBy('visit_date', 'desc') // latest date first
            ->orderBy('visit_time', 'desc') // latest time first
            ->get();

        $events = $visitations->map(function ($visitation) {
            if ($visitation->buildingApplication) {
                $applicationNo = $visitation->buildingApplication->application_no;
                $role = 'Building';
            } elseif ($visitation->sanitaryApplication) {
                $applicationNo = $visitation->sanitaryApplication->application_no;
                $role = 'Sanitary';
            } elseif ($visitation->zoningApplication) {
                $applicationNo = $visitation->zoningApplication->application_no;
                $role = 'Zoning';
            } else {
                $applicationNo = 'N/A';
                $role = 'Unknown';
            }

            $roleColor = match ($role) {
                'Zoning' => '#2563eb',
                'Sanitary' => '#8b5cf6',
                'Building' => '#3B82F6',
                default => '#6b7280',
            };

            $statusColor = match ($visitation->status) {
                'completed' => '#16a34a',
                'cancelled' => '#dc2626',
                'rescheduled' => '#f59e0b',
                'absent' => '#6b7280',
                default => $roleColor,
            };

            return [
                'id' => $visitation->id,
                'title' => "{$role} Visitation - {$applicationNo}",
                'start' => $visitation->visit_date.'T'.$visitation->visit_time,
                'status' => $visitation->status,
                'role' => $role,
                'remarks' => $visitation->remarks,
                'color' => $statusColor,
            ];
        });

        return response()->json($events);
    }

    public function index()
    {
        $userId = auth()->id();
        // Fetch only this user's building applications
        $applications = BuildingApplication::where('user_id', $userId)->get();

        $summaries = [
            'building' => [
                'total' => BuildingApplication::where('user_id', $userId)->count(),
                'approved' => BuildingApplication::where('user_id', $userId)->where('status', 'approved')->count(),
                'resubmit' => BuildingApplication::where('user_id', $userId)->where('status', 'resubmit')->count(),
                'disapproved' => BuildingApplication::where('user_id', $userId)->where('status', 'disapproved')->count(),
            ],
            'zoning' => [
                'total' => ZoningApplication::where('user_id', $userId)->count(),
                'approved' => ZoningApplication::where('user_id', $userId)->where('status', 'approved')->count(),
                'resubmit' => ZoningApplication::where('user_id', $userId)->where('status', 'resubmit')->count(),
                'disapproved' => ZoningApplication::where('user_id', $userId)->where('status', 'disapproved')->count(),
            ],
            'sanitary' => [
                'total' => SanitaryApplication::where('user_id', $userId)->count(),
                'approved' => SanitaryApplication::where('user_id', $userId)->where('status', 'approved')->count(),
                'resubmit' => SanitaryApplication::where('user_id', $userId)->where('status', 'resubmit')->count(),
                'disapproved' => SanitaryApplication::where('user_id', $userId)->where('status', 'disapproved')->count(),
            ],
        ];

        // 🔵 QUICK STATS (FOR DASHBOARD CARDS)
        $activeApplications = BuildingApplication::where('user_id', $userId)
            ->whereIn('status', ['submitted', 'pending','under_review'])
            ->count();

        $approvedThisMonth = BuildingApplication::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();

        // $upcomingAppointments = Visitation::where('user_id', $userId)
        //     ->whereNotNull('visit_date')
        //     ->whereDate('visit_date', '>=', Carbon::today())
        //     ->count();

        $pendingReviews = BuildingApplication::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $applicationValidationReason = ApplicantLog::where('applicant_id', $userId)
            ->latest()
            ->value('remarks');

        return view('applicant.dashboard', compact(
            'applications',
            'summaries',
            'activeApplications',
            'approvedThisMonth',
            'applicationValidationReason',
            'pendingReviews'
        ));
    }

    // public function permit()
    // {
    //     // $users = User::all();
    //     return view('applicant.permit');
    // }

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
        $locations = new LocationService;
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
        $locations = new LocationService;
        $regionCode = '05'; // Region V - Bicol

        // Get provinces only from Region V
        $provinces = $locations->getProvincesByRegion($regionCode);

        return view('applicant.forms.form', compact('provinces', 'regionCode'));
    }

    public function zoning_form()
    {
        $locations = new LocationService;
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

        return view('applicant.forms.zoning.zoning_form', compact('provinces', 'regionCode'), [
            'municipalities' => $municipalitiesRaw,
            'barangays' => $barangays,
        ]);
    }

    public function getMunicipalities(Request $request)
    {
        $province = $request->province;
        if (! $province) {
            return response()->json([], 400); // Bad request
        }

        $locations = new LocationService;
        $municipalities = $locations->getMunicipalities('05', $province);

        return response()->json($municipalities);
    }

    public function getBarangays(Request $request)
    {
        $province = $request->province;
        $municipality = $request->municipality;

        if (! $province || ! $municipality) {
            return response()->json([], 400); // Bad request
        }

        $locations = new LocationService;
        $barangays = $locations->getBarangays('05', $province, $municipality);

        return response()->json($barangays);
    }
}
