<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SanitaryApplicationResubmit extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    public $currentRemarks;

    public function __construct($application, $currentRemarks)
    {
        $this->application = $application;
        $this->currentRemarks = $currentRemarks;
    }

    public function build()
    {
        return $this->subject('Sanitary Application Resubmit')
            ->view('email.sanitary_resubmit');
    }
}
