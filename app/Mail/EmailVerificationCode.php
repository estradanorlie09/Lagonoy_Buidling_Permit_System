<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $code;

    public function __construct($user)
    {
        $this->user = $user;
        $this->code = $user->email_verification_code;
    }

    public function build()
    {
        return $this->subject('Your Email Verification Code')
            ->view('email.verification_code')
            ->with([
                'name' => $this->user->first_name,
                'code' => $this->code,
            ]);
    }
}
