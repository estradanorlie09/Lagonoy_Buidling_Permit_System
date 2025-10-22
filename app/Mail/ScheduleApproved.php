<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    public $visitation;

    public function __construct($application, $visitation)
    {
        $this->application = $application;
        $this->visitation = $visitation;
    }

    public function build()
    {
        return $this->subject('Visitation Completed')
            ->view('email.visitation_approved')
            ->with([
                'application' => $this->application,
                'visitation' => $this->visitation,
            ]);
    }
}
