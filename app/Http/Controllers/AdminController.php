<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LocationService;
use App\Utils\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login_admin()
    {
        return view('admin.auth.login');
    }

    public function loginAdmin(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->isAdmin()) {
            // dd($user);
            // dd($request);
            return redirect()->intended(route('admin.dashboard'));
        } else {
            // fallback route if role doesn't match any
            Auth::logout();

            return redirect('/login')->withErrors(['role' => 'Your role is not authorized']);
        }
    }

    public function index()
    {
        $records = User::all();

        // Quick stats
        $totalUsers = User::count();
        $totalApplicants = User::where('role', 'applicant')->count();
        $totalOBO = User::where('role', 'obo')->count();

        // $buildingApplications = User::where('role', 'applicant')->count();
        // $zoningOfficers = User::where('role', 'zoning_officer')->count();
        // $sanitaryOfficers = User::where('role', 'sanitary_officer')->count();

        // Users by Role
        $roles = ['applicant', 'admin', 'obo', 'zoning_officer', 'sanitary_officer', 'professional'];
        $counts = collect([
            'applicant' => $records->where('role', 'applicant')->count(),
            'admin' => $records->where('role', 'admin')->count(),
            'obo' => $records->where('role', 'obo')->count(),
            'zoning_officer' => $records->where('role', 'zoning_officer')->count(),
            'sanitary_officer' => $records->where('role', 'sanitary_officer')->count(),
            'professional' => $records->where('role', 'professional')->count(),

        ]);

        // Applicants by City
        $cities = User::where('role', 'applicant')->select('municipality')->distinct()->pluck('municipality');
        $cityCounts = collect();
        foreach ($cities as $city) {
            $cityCounts->push(User::where('municipality', $city)->count());
        }

        // User Growth (Last 6 months)
        $months = [];
        $monthlyCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('M Y');
            $months[] = $month;
            $monthlyCounts[] = User::whereMonth('created_at', now()->subMonths($i)->month)->count();
        }

        return view('admin.dashboard', compact(
            'records',
            'totalUsers',
            'totalApplicants',
            'totalOBO',
            'roles',
            'counts',
            'cities',
            'cityCounts',
            'months',
            'monthlyCounts'
        ));
    }

    // Admin User Records
    public function addUser()
    {
        $locations = new LocationService;
        $regionCode = '05'; // Region V - Bicol

        // Get provinces only from Region V
        $provinces = $locations->getProvincesByRegion($regionCode);

        return view('admin.forms.addUser', compact('provinces', 'regionCode'));
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

    public function user_record()
    {
        // $records = User::all();
        $records = User::whereIn('role', ['applicant', 'zoning_officer', 'obo', 'sanitary_officer', 'professional'])->get();

        return view('admin.user_record', compact('records'));
    }

    public function admin_record()
    {
        // $records = User::all();
        $records = User::whereIn('role', ['admin'])->get();

        return view('admin.admin_account', compact('records'));
    }

    // Show User
    public function show_user($id)
    {
        $records = User::where('id', $id)->firstOrFail();

        return view('admin.show_user', compact('records'));
    }

    // show admin
    public function show_admin($id)
    {
        $records = User::where('id', $id)->firstOrFail();

        return view('admin.show_admin', compact('records'));
    }

    public function addAdmin()
    {
        $locations = new LocationService;
        $regionCode = '05'; // Region V - Bicol

        // Get provinces only from Region V
        $provinces = $locations->getProvincesByRegion($regionCode);

        return view('admin.forms.addAdmin', compact('provinces', 'regionCode'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account while logged in.');
        }

        if (strtolower($user->role) === 'admin') {
            $adminCount = User::where('role', 'admin')->count();

            if ($adminCount <= 1) {
                return redirect()->back()->with('error', 'You cannot delete the last remaining admin account.');
            }
        }
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    public function createAdmin(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value !== 'admin') {
                        $fail('Only admin role is allowed.');
                    }
                },
            ],

            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street' => 'required|string|max:255',

        ]);

        // dd($validator);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); // keeps old input
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'province' => $request->province,
            'municipality' => $request->municipality,
            'barangay' => $request->barangay,
            'street' => $request->street,

        ]);

        return redirect()->back()->with('success', 'Admin account created');

        // return redirect()->back()->with('success', 'User registered successfully!');
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:applicant,obo,sanitary_officer,zoning_officer,professional',
            'profession' => $request->role === 'professional'
                ? 'required|string|max:255'
                : 'nullable|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role' => $request->role,
                'profession' => $request->profession,
                'province' => $request->province,
                'municipality' => $request->municipality,
                'barangay' => $request->barangay,
                'street' => $request->street,
            ]);

            return redirect()->back()->with('success', 'User account created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error saving user: '.$e->getMessage());
        }
    }

    public function update_admin($id)
    {
        // load locations
        $locations = new LocationService;
        $regionCode = '05';

        $user = User::where('id', $id)->firstOrFail();

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

        //     // dd($provinceRaw, $municipalityRaw, $originalProvinceKey, $originalMunicipalityKey, $barangays);

        return view('admin.forms.update.updateAdmin', [
            'user' => $user,
            'provinces' => $provincesRaw,
            'municipalities' => $municipalitiesRaw,
            'barangays' => $barangays,
            'regionCode' => $regionCode,
        ]);
    }

    public function update_user($id)
    {
        // load locations
        $locations = new LocationService;
        $regionCode = '05';

        $user = User::where('id', $id)->firstOrFail();

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

        //     // dd($provinceRaw, $municipalityRaw, $originalProvinceKey, $originalMunicipalityKey, $barangays);

        return view('admin.forms.update.updateUser', [
            'user' => $user,
            'provinces' => $provincesRaw,
            'municipalities' => $municipalitiesRaw,
            'barangays' => $barangays,
            'regionCode' => $regionCode,
        ]);
    }

    public function update_userAdmin_submit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // if (auth()->user()->role !== 'superadmin' && $user->role === 'admin') {
        //     abort(403, 'Unauthorized action.');
        // }
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:15',
            'province' => 'nullable|string|max:255',
            'municipality' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'password' => 'nullable|confirmed|min:8',
        ]);

        // dd($validated);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'Admin account updated successfully!');
    }

    public function update_user_submit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // if (auth()->user()->role !== 'superadmin' && $user->role === 'admin') {
        //     abort(403, 'Unauthorized action.');
        // }
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:applicant,obo,sanitary_officer,zoning_officer,professional',
            'profession' => $request->role === 'professional'
                ? 'required|string|max:255'
                : 'nullable|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street' => 'required|string|max:255',
        ]);

       // dd($validated);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'User account updated successfully!');
    }
}
