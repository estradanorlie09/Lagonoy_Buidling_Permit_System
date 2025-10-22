<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleCancelEmail extends Mailable implements ShouldQueue
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
        return $this->subject('Visitation Cancelled')
            ->view('email.visitation_cancel')
            ->with([
                'application' => $this->application,
                'visitation' => $this->visitation,
            ]);
    }
}
