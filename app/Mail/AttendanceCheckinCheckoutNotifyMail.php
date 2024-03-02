<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AttendanceCheckinCheckoutNotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $employeeName;
    protected $empCode;
    protected $attendance_date;
    protected $user_time;
    protected $image_view;
    protected $regularization_type;
    protected $emp_avatar;
    protected $loginLink;

    public function __construct($uEmployeeName, $uEmpCode, $attendance_date, $user_time, $image_view, $uEmp_avatar,$uLoginLink,$regularization_type)
    {
        //
        $this->employeeName  = $uEmployeeName;
        $this->empCode  = $uEmpCode;
        $this->attendance_date = $attendance_date;
        $this->user_time = $user_time;
        $this->image_view   = $image_view;
        $this->emp_avatar =$uEmp_avatar;
        $this ->loginLink =$uLoginLink;
        $this->regularization_type = $regularization_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $mail_message = "---";

        switch ($this->regularization_type) {

            case "LC":
                $mail_message = "You have checked-in late on <b>".$this->attendance_date."</b> at <b>".$this->user_time."</b>";
                break;
            case "EG":
                $mail_message = "You have checked-out early on ".$this->attendance_date."</b> at <b>".$this->user_time."</b>";
                break;
            case "MIP":
                $mail_message = "You have missed your Check-in punch on <b>".$this->attendance_date."</b>";
                break;
            case "MOP":
                $mail_message = "You have missed your Check-out punch on <b>".$this->attendance_date."</b>";
                break;
            default:
                $mail_message="Invalid Regularization Type : ".$this->regularization_type;
        }

        //dd($message);

        $output = $this->view('vmt_mail_attendance_regularization_notify')
                    ->subject('Late Attendance Notify')
                    ->with('employeeName', $this->employeeName)
                    ->with('empCode', $this->empCode)
                    ->with('mail_message', $mail_message)
                    ->with('attendance_date', $this->attendance_date)
                    ->with('empAvatar',$this->emp_avatar)
                    ->with('loginLink',$this->loginLink)
                    ->with('image_view', $this->image_view);

        return $output;
    }
}
