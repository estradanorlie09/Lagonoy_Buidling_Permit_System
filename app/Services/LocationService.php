<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class LocationService
{
    protected $data;

    public function __construct()
    {
        $path = storage_path('app/ph_locations.json');
        if (file_exists($path)) {
            $json = file_get_contents($path);
            $this->data = json_decode($json, true);
        } else {
            dd('File not found: ' . $path);
        }
    }

    public function getRegions()
    {
        return $this->data;
    }

    public function getProvincesByRegion($regionCode)
    {
        return $this->data[$regionCode]['province_list'] ?? [];
    }

    public function getMunicipalities($regionCode, $province)
    {
        $provinceList = $this->data[$regionCode]['province_list'] ?? [];

        if (!isset($provinceList[$province])) {
            return [];
        }

        $municipalityList = $provinceList[$province]['municipality_list'];

        $municipalities = [];

        foreach ($municipalityList as $municipality) {
            foreach ($municipality as $name => $details) {
                $municipalities[$name] = $details;
            }
        }

        return $municipalities;
    }

    public function getBarangays($regionCode, $province, $municipality)
    {
        $provinceList = $this->data[$regionCode]['province_list'] ?? [];

        if (!isset($provinceList[$province])) {
            return [];
        }

        $municipalityList = $provinceList[$province]['municipality_list'] ?? [];

        foreach ($municipalityList as $municipalityEntry) {
            foreach ($municipalityEntry as $name => $details) {
                if ($name === $municipality) {
                    return $details['barangay_list'] ?? [];
                }
            }
        }

        return [];
    }
}
