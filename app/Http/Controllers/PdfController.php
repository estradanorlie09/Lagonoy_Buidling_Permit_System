<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ZoningApplication;

class PdfController extends Controller
{
    public function applicationReport($id)
    {
        // 1. Get application
        $application = ZoningApplication::with(['user', 'property', 'documents'])
            ->findOrFail($id);

        // 2. Create verification URL
        $verificationUrl = route('certificate.verify', $application->id);
       // dd($verificationUrl);

        // 3. Generate QR Code using Google Chart API (no package needed)
        $qrCodeUrl = "https://quickchart.io/qr?text=" . urlencode($verificationUrl);
       // dd($qrCodeUrl);
        // 4. Load PDF view and pass variables
        $pdf = Pdf::loadView('pdf.zoning_pdf', [
            'application' => $application,
            'qrCodeUrl'   => $qrCodeUrl,
        ])->setPaper('A4', 'portrait');

        // 5. Return PDF download
        return $pdf->download('Zoning_Certificate_' . $application->application_no . '.pdf');
    }

    public function verify($id)
    {
        $application = ZoningApplication::with(['property', 'user'])->findOrFail($id);

        return view('pdf.verify.verify', compact('application'));
    }
}
