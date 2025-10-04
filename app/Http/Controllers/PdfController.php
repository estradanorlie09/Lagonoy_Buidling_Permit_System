<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ZoningApplication;

class PdfController extends Controller
{
        public function applicationReport($id)
        {
        
            $application = ZoningApplication::with(['user', 'property', 'documents'])
                ->findOrFail($id);
            $verificationUrl = route('certificate.verify', $application->id);
            $qrCodeUrl = "https://quickchart.io/qr?text=" . urlencode($verificationUrl);
        
            $pdf = Pdf::loadView('pdf.zoning_pdf', [
                'application' => $application,
                'qrCodeUrl'   => $qrCodeUrl,
            ])->setPaper('A4', 'portrait');
            return $pdf->download('Zoning_Certificate_' . $application->application_no . '.pdf');
        }

    public function verify($id)
    {
        $application = ZoningApplication::with(['property', 'user'])->findOrFail($id);

        return view('pdf.verify.verify', compact('application'));
    }
}
