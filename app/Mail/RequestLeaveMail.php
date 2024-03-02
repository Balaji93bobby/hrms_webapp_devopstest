<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestLeaveMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $employeeName;
    protected $managerName;

    protected $leaveRequestDate;
    protected $empCode;

    protected $startDate;
    protected $endDate;
    protected $reason;
    protected $leaveType;
    protected $totalLeaveDatetime;
    protected $loginLink;
    protected $image_view;
    protected $emp_image;
    protected $manager_image;
    protected $emp_designation;

    public function __construct($uEmployeeName, $uEmpCode, $uManagerName,$uLeaveRequestDate, $uStartDate,$uEndDate,$uReason, $uLeaveType, $uTotal_leave_datetime,  $loginLink, $image_view , $emp_image , $manager_image , $emp_designation)
    {
        //
        $this->employeeName  = $uEmployeeName;
        $this->empCode  = $uEmpCode;
        $this->managerName   =$uManagerName;
        $this->leaveRequestDate = $uLeaveRequestDate;
        $this->startDate   =$uStartDate;
        $this->endDate   =$uEndDate;
        $this->reason   =$uReason;
        $this->leaveType   =$uLeaveType;
        $this->totalLeaveDatetime =$uTotal_leave_datetime;
        $this->loginLink  = $loginLink;
        $this->image_view   = $image_view;
        $this->emp_image   = $emp_image;
        $this->manager_image   = $manager_image;
        $this->emp_designation   = $emp_designation;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $MAIL_FROM_ADDRESS = env('MAIL_FROM_ADDRESS');
        $MAIL_FROM_NAME    = env('MAIL_FROM_NAME');

        $subject = $this->leaveType." Approval Request from ";

        if($this->leaveType == 'Permission')
            $subject = "Permission Approval Request from ";


        return $this->from($MAIL_FROM_ADDRESS,  $MAIL_FROM_NAME)
                    ->subject($subject.$this->employeeName)
                    ->view('mail_leave_request')
                    ->with('employeeName', $this->employeeName)
                    ->with('empCode', $this->empCode)
                    ->with('managerName', $this->managerName)
                    ->with('leaveRequestDate',$this->leaveRequestDate)
                    ->with('startDate', $this->startDate)
                    ->with('endDate', $this->endDate)
                    ->with('reason', $this->reason)
                    ->with('leaveType', $this->leaveType)
                    ->with('totalLeaveDatetime', $this->totalLeaveDatetime)
                    ->with('loginLink', $this->loginLink)
                    ->with('image_view', $this->image_view)
                    ->with('emp_image', $this->emp_image)
                    ->with('manager_image', $this->manager_image)
                    ->with('emp_designation', $this->emp_designation);

    }
}
