<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/*


    Mail is sent to Employee when manager submits review

*/
class VmtPMSMail_Reviewer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // protected $linkUri;


    protected $employeeName;
    protected $approvalStatus;
    protected $user_emp_name;
    protected $appraisal_year;
    protected $appraisal_period;
    protected $user_manager_name;
    protected $comments_manager;
    protected $login_Link;
    protected $sender_gender;
    protected $emp_avatar;

    public function __construct($approvalStatus, $user_emp_name,$appraisal_year, $appraisal_period,$user_manager_name,$comments_manager,$login_link,$sender_gender,$emp_avatar)
    {
        //
        $this->approvalStatus = $approvalStatus;
        $this->user_emp_name = $user_emp_name;
        $this->appraisal_year = $appraisal_year;
        $this->appraisal_period = $appraisal_period;
        $this->user_manager_name = $user_manager_name;
        $this->comments_manager = $comments_manager;
        $this->login_Link = $login_link;
        $this->sender_gender = $sender_gender;
        $this->emp_avatar = $emp_avatar;

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

        $mail_subject="  ";

        if($this->approvalStatus == "approved")
        {
            $mail_subject = "Approved of OKR/PMS for the Period of " . $this->appraisal_period;
        }
        else
        if ($this->approvalStatus == "rejected")
        {
            $mail_subject = "Rejected of OKR/PMS for the Period of " . $this->appraisal_period;
        }
        else
        if($this->approvalStatus == "completed")
        {
            $mail_subject = "Submitted Manager Review OKR/PMS for the Period of " .$this->appraisal_year. " - ". $this->appraisal_period;
        }


        return $this->from($MAIL_FROM_ADDRESS,  $MAIL_FROM_NAME)
                //->subject("Regarding the Manager Review - PMS")
                ->subject($mail_subject)
                ->view('pms_mails.vmt_pms_mail_flow2_manager_to_assignee')
                ->with('approvalStatus', $this->approvalStatus)
                ->with('user_emp_name', $this->user_emp_name)
                ->with('appraisal_year', $this->appraisal_year)
                ->with('appraisal_period', $this->appraisal_period)
                ->with('user_manager_name', $this->user_manager_name)
                ->with('comments_manager', $this->comments_manager)
                ->with('login_Link', $this->login_Link)
                ->with('sender_gender', $this->sender_gender)
                ->with('emp_avatar', $this->emp_avatar);
    }
}
