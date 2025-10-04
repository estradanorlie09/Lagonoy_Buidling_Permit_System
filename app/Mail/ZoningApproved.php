<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class ZoningApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $qrCodeUrl;

    public function __construct($application)
    {
        $this->application = $application;

        // Generate verification URL and QR code URL here to use in the PDF
        $verificationUrl = route('certificate.verify', $application->id);
        $this->qrCodeUrl = "https://quickchart.io/qr?text=" . urlencode($verificationUrl);
    }

    public function build()
    {
        
        $pdf = PDF::loadView('pdf.zoning_pdf', [
            'application' => $this->application,
            'qrCodeUrl' => $this->qrCodeUrl,
        ])->setPaper('A4', 'portrait');

        return $this->subject('Your Zoning Application Has Been Approved')
                    ->view('email.zoning_approved')  // Your email blade view
                    ->attachData($pdf->output(), 'Zoning_Certificate_' . $this->application->application_no . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
