<?php

namespace App\Http\Controllers;
use App\Services\LocationService;
use Illuminate\Http\Request;

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

    public function form()
    {
        $locations = new LocationService();
        $regionCode = '05'; // Region V - Bicol

        // Get provinces only from Region V
        $provinces = $locations->getProvincesByRegion($regionCode);

        return view('applicant.forms.form', compact('provinces', 'regionCode'));
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
