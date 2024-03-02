<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuickOnboardLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $employeeName;
    protected $employeeEmpCode;
    protected $employeePassword;
    protected $loginLink;
    protected $image_view;


    public function __construct($employeeName, $employeeEmpCode, $employeePassword , $loginLink,$image_view)
    {
        //
        $this->employeeName     = $employeeName;
        $this->employeeEmpCode    = $employeeEmpCode;
        $this->employeePassword    = $employeePassword;
        $this->loginLink    = $loginLink;
        $this->image_view    = $image_view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vmt_quickonboard_email')
                    ->subject('Onboard Link')
                    ->with('employeeName', $this->employeeName)
                    ->with('employeeEmpCode', $this->employeeEmpCode)
                    ->with('employeePassword', $this->employeePassword)
                    ->with('loginLink', $this->loginLink)
                    ->with('image_view', $this->image_view);
    }
}
