<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveRejectEmpDetails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $employeeName;
    protected $empCode;
    protected $docType;
    protected $managerName;
    protected $managerCode;
    protected $loginLink;
    protected $image_view;
    protected $request_status;
    protected $empAvatar;
    protected $status;

    public function __construct($uEmployeeName, $uEmpCode,$DocType, $managerName , $managerCode, $loginLink, $image_view ,$uEmpAvatar, $status)
    {
        //
        $this->employeeName  = $uEmployeeName;
        $this->empCode  = $uEmpCode;
        $this->docType = $DocType;
        $this->managerName  = $managerName;
        $this->managerCode  = $managerCode;
        $this->loginLink  = $loginLink;
        $this->image_view   = $image_view;
        $this->empAvatar=$uEmpAvatar;
        $this->status   = $status;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //
        $subject = "Your ".$this->docType." has been ";

        $output = $this->view('vmt_approverejectempdetails_Email')

                    ->subject($subject.$this->status)
                    ->with('employeeName', $this->employeeName)
                    ->with('empCode', $this->empCode)
                    ->with('docType', $this->docType)
                    ->with('managerName', $this->managerName)
                    ->with('managerCode', $this->managerCode)
                    ->with('loginLink', $this->loginLink)
                    ->with('image_view', $this->image_view)
                    ->with('status', $this->status)
                    ->with('empAvatar', $this->empAvatar);


        return $output;
    }
}
