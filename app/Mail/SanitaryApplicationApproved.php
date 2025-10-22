<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class SanitaryApplicationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    public $qrCodeUrl;

    public function __construct($application)
    {
        $this->application = $application;
        $verificationUrl = route('sanitary_certificate.verify', $application->id);
        $this->qrCodeUrl = 'https://quickchart.io/qr?text='.urlencode($verificationUrl);

    }

    public function build()
    {
        $pdf = PDF::loadView('pdf.sanitary_pdf', [
            'application' => $this->application,
            'qrCodeUrl' => $this->qrCodeUrl,
        ])->setPaper('A4', 'portrait');

        return $this->subject('Sanitary Application Approved')
            ->view('email.sanitary_approved')->attachData($pdf->output(), 'Sanitary_Certificate_'.$this->application->application_no.'.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
