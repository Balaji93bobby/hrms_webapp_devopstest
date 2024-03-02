<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $employeeName;
    protected $empCode;
    protected $passwordResetLink;
    protected $image_view;

    public function __construct($uEmployeeName, $uEmpCode, $passwordResetLink, $image_view )
    {
        //
        $this->employeeName  = $uEmployeeName;
        $this->empCode  = $uEmpCode;
        $this->passwordResetLink  = $passwordResetLink;
        $this->image_view   = $image_view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $output = $this->view('vmt_passwordreset_email')
                    ->with('employeeName', $this->employeeName)
                    ->with('empCode', $this->empCode)
                    ->with('passwordResetLink', $this->passwordResetLink)
                    ->with('image_view', $this->image_view);

        return $output;
    }
}
