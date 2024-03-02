<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveRejectLeaveMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $employeeName;
    protected $empCode;

    protected $leaveType;
    protected $managerName;
    protected $managerCode;
    protected $loginLink;
    protected $image_view;
    protected $request_status;
    protected $empAvatar;
    protected $leave_status;
    protected $user_type;

    public function __construct($uEmployeeName, $uEmpCode, $uLeaveType, $managerName , $managerCode, $loginLink, $image_view ,$uEmpAvatar, $leave_status,$user_type)
    {
        //
        $this->employeeName  = $uEmployeeName;
        $this->empCode  = $uEmpCode;
        $this->leaveType = $uLeaveType;
        $this->managerName  = $managerName;
        $this->managerCode  = $managerCode;
        $this->loginLink  = $loginLink;
        $this->image_view   = $image_view;
        $this->empAvatar=$uEmpAvatar;
        $this->leave_status   = $leave_status;
        $this->user_type   = $user_type;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //
        $subject = "Your ".$this->leaveType." has been ";

     if ($this->user_type == "Admin") {
        $output = $this->view('vmt_preview_templates.admin_mail_leaveapply')
                    ->subject($subject.$this->leave_status)
                    ->with('employeeName', $this->employeeName)
                    ->with('empCode', $this->empCode)
                    ->with('leaveType', $this->leaveType)
                    ->with('managerName', $this->managerName)
                    ->with('managerCode', $this->managerCode)
                    ->with('loginLink', $this->loginLink)
                    ->with('image_view', $this->image_view)
                    ->with('leave_status', $this->leave_status)
                    ->with('empAvatar', $this->empAvatar);
     }else{

        $output = $this->view('vmt_approveRejectLeave_Email')
        ->subject($subject.$this->leave_status)
        ->with('employeeName', $this->employeeName)
        ->with('empCode', $this->empCode)
        ->with('leaveType', $this->leaveType)
        ->with('managerName', $this->managerName)
        ->with('managerCode', $this->managerCode)
        ->with('loginLink', $this->loginLink)
        ->with('image_view', $this->image_view)
        ->with('leave_status', $this->leave_status)
        ->with('empAvatar', $this->empAvatar);

     }
        return $output;
    }
}
