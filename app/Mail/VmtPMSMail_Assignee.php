<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VmtPMSMail_Assignee extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // protected $linkUri;
    protected $approvalStatus;
    protected $flowType;// PMS flow 1 / 2 / 3
    protected $user_emp_name;
    protected $appraisal_period;
    protected $user_manager_name;
    protected $comments_employee;
    protected $login_Link;
    protected $emp_avatar;
    protected $emp_neutralgender;

    public function __construct( $approvalStatus,$flowType, $user_emp_name,$appraisal_period,$user_manager_name,$comments_employee,$login_Link,$emp_avatar,$emp_neutralgender)

    {
        //

        $this->approvalStatus = $approvalStatus;
        $this->flowType = $flowType;// PMS flow 1 / 2 / 3
        $this->user_emp_name = $user_emp_name;
        $this->appraisal_period = $appraisal_period;
        $this->user_manager_name = $user_manager_name;
        $this->comments_employee = $comments_employee;
        $this->login_Link = $login_Link;
        $this->emp_avatar = $emp_avatar;
        $this->emp_neutralgender = $emp_neutralgender;

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

        $mail_subject = "---";

        if ($this->flowType == "2") {
            if ($this->approvalStatus == "accepted") {
                $mail_subject = "Accepted of OKR/PMS for the Period of " . $this->appraisal_period;
            } else
                if ($this->approvalStatus == "rejected") {
                    $mail_subject = "Rejected of OKR/PMS for the Period of " . $this->appraisal_period;
                } else
                    if ($this->approvalStatus == "completed") {
                        $mail_subject = "Submitted Self Review OKR/PMS for the Period of " . $this->appraisal_period;
                    }
        }
        else
        if ($this->flowType == "3"){
            if($this->approvalStatus == "publish"){
                $mail_subject = "Submitted Update of OKR/PMS for the Period of " . $this->appraisal_period;
            }
            elseif($this->approvalStatus == "withdraw"){
                $mail_subject = $this->user_emp_name . " has withdrawn OKR/PMS for the Period of " . $this->appraisal_period;
            }
        }

        return $this->from($MAIL_FROM_ADDRESS,  $MAIL_FROM_NAME)
                //Rejected of OKR/PMS for the Period of {Month Name/ Quarter Name/ Half Year Name}
                ->subject($mail_subject)
                ->view('pms_mails.vmt_pms_mail_flow_assignee_to_manager')
                ->with('user_emp_name', $this->user_emp_name)
                ->with('approvalStatus', $this->approvalStatus)
                ->with('appraisal_period', $this->appraisal_period)
                ->with('user_manager_name', $this->user_manager_name)
                ->with('comments_employee', $this->comments_employee)
                ->with('login_Link', $this->login_Link)
                ->with('emp_avatar', $this->emp_avatar)
                ->with('emp_neutralgender', $this->emp_neutralgender);

    }
}
