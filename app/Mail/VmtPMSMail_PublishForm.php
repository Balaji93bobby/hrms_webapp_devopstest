<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VmtPMSMail_PublishForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // protected $linkUri;
    protected $approvalStatus;
    protected $user_emp_name ;
    protected $appraisal_year ;
    protected $appraisal_period;
    protected $user_manager_name;
    protected $command_emp ;
    protected $flow_check ;
    protected $login_Link ;
    protected $emp_avatar ;
    protected $user_gender;

    public function __construct( $approvalStatus,$user_emp_name,$appraisal_year,$appraisal_period,$user_manager_name,$command_emp,$flow_check,$login_Link,$emp_avatar,$user_gender
    // ,$reviewer_gender
    )
    {
        //

        $this->approvalStatus = $approvalStatus;
        $this->user_emp_name = $user_emp_name;
        $this->appraisal_year = $appraisal_year;
        $this->appraisal_period = $appraisal_period;
        $this->user_manager_name = $user_manager_name;
        $this->command_emp = $command_emp;
        $this->flow_check = $flow_check;
        $this->login_Link    = $login_Link;
        $this->emp_avatar    = $emp_avatar;
        $this->user_gender    = $user_gender;
        // $this->reviewer_gender    = $reviewer_gender;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail_template = '';
        if($this->flow_check == 1)
            $mail_template = 'pms_mails.vmt_pms_mail_flow1_hr_to_assignee';
        else
        if($this->flow_check == 2)
            $mail_template = 'pms_mails.vmt_pms_mail_flow2_manager_to_assignee';

        $MAIL_FROM_ADDRESS = env('MAIL_FROM_ADDRESS');
        $MAIL_FROM_NAME    = env('MAIL_FROM_NAME');

        return $this->from($MAIL_FROM_ADDRESS,  $MAIL_FROM_NAME)
                //SUB : Successful Update of PMS/OKR for the Period of {Month Name/ Quarter Name/ Half Year Name}
                ->subject("Successful Update of PMS/OKR for the Period of ".$this->appraisal_year . " - " .$this->appraisal_period)
                ->view($mail_template)
                ->with('user_emp_name', $this->user_emp_name)
                ->with('approvalStatus', $this->approvalStatus)
                ->with('appraisal_year', $this->appraisal_year)
                ->with('appraisal_period', $this->appraisal_period)
                ->with('user_manager_name', $this->user_manager_name)
                ->with('command_emp', $this->command_emp)
                ->with('login_Link', $this->login_Link)
                ->with('emp_avatar', $this->emp_avatar)
                ->with('user_gender', $this->user_gender);
                // ->with('reviewer_gender', $this->reviewer_gender);

    }
}
