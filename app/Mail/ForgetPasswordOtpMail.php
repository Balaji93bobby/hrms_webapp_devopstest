<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $otp;
    protected $name;
    protected $emp_img;
    public function __construct($otp, $name, $emp_img)
    {
        $this->otp = $otp;
        $this->name = $name;
        $this->emp_img = $emp_img;
    }

    public function build()
    {
        $subject = "Password Reset";

        $output = $this->view('mail.password_reset_otp_mail')

            ->subject($subject)
            ->with('employeeName',  $this->name)
            ->with('emp_image', $this->emp_img)
            ->with('otp', $this->otp);

        return $output;
    }
}
