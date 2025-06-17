<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPVerify extends Mailable
{
    use Queueable, SerializesModels;

    public $otp; // optional: pass data

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Welcome to Dealrockets, This is your OTP')
            ->view('emails.otpverify'); // this is the Blade template
    }
}
