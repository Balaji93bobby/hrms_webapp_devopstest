<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VmtPMSMail_NotifyManager extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $empName;
    protected $recipientName;
    protected $empDesignation; //fetched from vmt_employee_office_details table
    protected $appraisal_period;
    protected $loginLink ;
    protected $emp_gender;
    public function __construct($empName, $empDesignation, $recipientName, $appraisal_period, $loginLink , $emp_gender)
    {
        //
        $this->empName  = $empName;
        $this->recipientName = $recipientName;
        $this->empDesignation = $empDesignation; //fetched from vmt_employee_office_details table
        $this->appraisal_period = $appraisal_period;
        $this->loginLink = $loginLink;
        $this->emp_gender = $emp_gender;
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

        return $this->from($MAIL_FROM_ADDRESS,  $MAIL_FROM_NAME)
                //"Submitted Self Review OKR/PMS for the Period of {Month Name/ Quarter Name/ Half Year Name}"
                ->subject("Submitted Self Review OKR/PMS for the Period of ".$this->appraisal_period)
                ->view('pms_mails.vmt_pms_mail_notify_reviewer')
                ->with('employeeName' , $this->empName)
                ->with('empDesignation' , $this->empDesignation)
                ->with('appraisal_period' , $this->appraisal_period)
                ->with('recipientName' , $this->recipientName)
                ->with('loginLink', $this->loginLink)
                ->with('emp_gender', $this->emp_gender);
    }
}
