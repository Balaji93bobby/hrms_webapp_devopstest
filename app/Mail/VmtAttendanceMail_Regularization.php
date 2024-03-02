<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/*
    Mail sent from Attendance Regularization module


*/

class VmtAttendanceMail_Regularization extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $employeeName;
    protected $empCode;
    protected $empAvatar;
    protected $attendance_date;
    protected $managerName;
    protected $managerCode;
    protected $loginLink;
    protected $image_view;
    protected $custom_reason;
    protected $user_type;

    protected $status;

    public function __construct($uEmployeeName, $uEmpCode, $uEmpAvatar, $uAttendance_date, $managerName, $managerCode, $loginLink, $image_view, $custom_reason, $status,$user_type)
    {
        //
        $this->employeeName  = $uEmployeeName;
        $this->empCode  = $uEmpCode;
        $this->empAvatar  = $uEmpAvatar;
        $this->attendance_date = $uAttendance_date;
        $this->managerName  = $managerName;
        $this->managerCode  = $managerCode;
        $this->loginLink  = $loginLink;
        $this->image_view   = $image_view;
        $this->custom_reason   = $custom_reason;
        $this->status   = $status;
        $this->user_type   = $user_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $output = "Error : status is invalid";

        $MAIL_FROM_ADDRESS = env('MAIL_FROM_ADDRESS');
        $MAIL_FROM_NAME    = env('MAIL_FROM_NAME');


       if ($this->user_type == "Admin") {
    
            //Mail sent to Manager
            $output = $this->from($MAIL_FROM_ADDRESS,  $MAIL_FROM_NAME)
                ->subject("Attendance Regularization Mail")
                ->view('admin_mail_attendanceRegularization')
                ->with('employeeName', $this->employeeName)
                ->with('empCode', $this->empCode)
                ->with('empAvatar', $this->empAvatar)
                ->with('attendance_date', $this->attendance_date)
                ->with('managerName', $this->managerName)
                ->with('managerCode', $this->managerCode)
                ->with('loginLink', $this->loginLink)
                ->with('image_view', $this->image_view)
                ->with('status', $this->status)
                ->with('custom_reason', $this->custom_reason);
        } else{

         if ($this->status == "Pending") {
            //Mail sent to Manager
            $output = $this->from($MAIL_FROM_ADDRESS,  $MAIL_FROM_NAME)
                ->subject("Attendance Regularization Mail")
                ->view('mail_attendanceRegularization')
                ->with('employeeName', $this->employeeName)
                ->with('empCode', $this->empCode)
                ->with('empAvatar', $this->empAvatar)
                ->with('attendance_date', $this->attendance_date)
                ->with('managerName', $this->managerName)
                ->with('managerCode', $this->managerCode)
                ->with('loginLink', $this->loginLink)
                ->with('image_view', $this->image_view)
                ->with('status', $this->status)
                ->with('custom_reason', $this->custom_reason);
        } else
        if ($this->status == "Approved" || $this->status == "Rejected") {
            //Mail sent to employee who applied for Regularization
            $output = $this->from($MAIL_FROM_ADDRESS,  $MAIL_FROM_NAME)
                ->subject("Your Attendance Regularization has been " . $this->status)
                ->view('vmt_mail_attendance_regularization_approveReject')
                ->with('employeeName', $this->employeeName)
                ->with('empCode', $this->empCode)
                ->with('empAvatar', $this->empAvatar)
                ->with('attendance_date', $this->attendance_date)
                ->with('managerName', $this->managerName)
                ->with('managerCode', $this->managerCode)
                ->with('loginLink', $this->loginLink)
                ->with('image_view', $this->image_view)
                ->with('status', $this->status)
                ->with('custom_reason', $this->custom_reason);
        }
    }

        return $output;
    }
}
