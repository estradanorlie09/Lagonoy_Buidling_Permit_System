<?php

namespace App\Http\Controllers;

use App\Models\BuildingApplication;
use App\Models\SanitaryApplication;
use App\Models\ZoningApplication;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function applicationReport($id)
    {

        $application = ZoningApplication::with(['user', 'property', 'documents'])
            ->findOrFail($id);
        $verificationUrl = route('zoning_certificate.verify', $application->id);
        $qrCodeUrl = 'https://quickchart.io/qr?text='.urlencode($verificationUrl);

        $pdf = Pdf::loadView('pdf.zoning_pdf', [
            'application' => $application,
            'qrCodeUrl' => $qrCodeUrl,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Zoning_Certificate_'.$application->application_no.'.pdf');
    }

    public function applicationReportSanitary($id)
    {

        $application = SanitaryApplication::with(['user', 'property', 'documents'])
            ->findOrFail($id);
        $verificationUrl = route('sanitary_certificate.verify', $application->id);
        $qrCodeUrl = 'https://quickchart.io/qr?text='.urlencode($verificationUrl);

        $pdf = Pdf::loadView('pdf.sanitary_pdf', [
            'application' => $application,
            'qrCodeUrl' => $qrCodeUrl,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Sanitary_Certificate_'.$application->application_no.'.pdf');
    }

    public function applicationReportBuilding($id)
    {

        $application = BuildingApplication::with(['user', 'property', 'documents'])
            ->findOrFail($id);
        $verificationUrl = route('building_certificate.verify', $application->id);
        $qrCodeUrl = 'https://quickchart.io/qr?text='.urlencode($verificationUrl);

        $pdf = Pdf::loadView('pdf.building_pdf', [
            'application' => $application,
            'qrCodeUrl' => $qrCodeUrl,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Building_Certificate_'.$application->application_no.'.pdf');
    }

    public function verify($id)
    {
        $application = ZoningApplication::with(['property', 'user'])->findOrFail($id);

        return view('pdf.verify.verify', compact('application'));
    }

    public function verifySanitary($id)
    {
        $application = SanitaryApplication::with(['property', 'user'])->findOrFail($id);

        return view('pdf.verify.verify_sanitary_cert', compact('application'));
    }

    public function verifyBuilding($id)
    {
        $application = BuildingApplication::with(['property', 'user'])->findOrFail($id);

        return view('pdf.verify.verify_building_cert', compact('application'));
    }
}
