<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\RequestLeaveMail;
use Illuminate\Support\Facades\Log;

class SendEmployeeMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $user_type;
     protected $uEmployeeName;
     protected $uEmpCode;
     protected $uManagerName;
     protected $uLeaveRequestDate;
     protected $uStartDate;
     protected $uEndDate;
     protected $uReason;
     protected $uLeaveType;
     protected $uTotal_leave_datetime;
    protected $loginLink;
    protected $image_view;
    protected $emp_image;
    protected $manager_image;
    protected $emp_designation;
    protected $reviewer_mail;
    protected $notification_mails;
    public function __construct($user_type, $uEmployeeName,$uEmpCode,$uManagerName,$uLeaveRequestDate,$uStartDate,$uEndDate,$uReason,$uLeaveType,$uTotal_leave_datetime,
                                   $loginLink,$image_view,$emp_image,$manager_image,$emp_designation,$reviewer_mail,$notification_mails)
    {
       $this->$user_type = $user_type;
       $this->uEmployeeName = $uEmployeeName;
       $this->uEmpCode = $uEmpCode;
       $this->uManagerName = $uManagerName;
       $this->uLeaveRequestDate = $uLeaveRequestDate;
       $this->uStartDate = $uStartDate;
       $this->uEndDate = $uEndDate;
       $this->uReason = $uReason;
       $this->uLeaveType = $uLeaveType;
       $this->loginLink = $loginLink;
       $this->image_view = $image_view;
       $this->emp_image = $emp_image;
       $this->manager_image = $manager_image;
       $this->emp_designation = $emp_designation;
       $this->reviewer_mail = $reviewer_mail;
       $this->notification_mails = $notification_mails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::channel('jobs')->info('MyJob starts successfully');
        $mail_status ="";

         if ($this->user_type != "Admin") {

                $isSent    = \Mail::to($this->reviewer_mail)->cc($this->notification_mails)->send(new RequestLeaveMail(
                    $this->uEmployeeName,
                    $this->uEmpCode,
                    //uEmpAvatar: ,
                    $this->uManagerName,
                    $this->uLeaveRequestDate,
                    $this->uStartDate,
                    $this->uEndDate,
                    $this->uReason,
                    $this->uLeaveType,
                    $this->uTotal_leave_datetime,
                    //Carbon::parse($request->total_leave_datetime)->format,
                    $this->loginLink,
                    $this->image_view,
                    $this->emp_image,
                    $this->manager_image,
                    $this->emp_designation
                ));
                if ($isSent) {
                    $mail_status = "success";
                } else {
                    $mail_status = "failure";
                }
            }

            Log::channel('jobs')->info('MyJob ends successfully');

            //return $mail_status;
    }
}
