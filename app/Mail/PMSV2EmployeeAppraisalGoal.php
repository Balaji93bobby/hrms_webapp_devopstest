<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PMSV2EmployeeAppraisalGoal extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($status,$senderName,$appraisal_period,$receiverName,$rejectedReason)
    {
        $this->status = $status;
        $this->senderName = $senderName;
        $this->appraisal_period = $appraisal_period;
        $this->receiverName = $receiverName;
        $this->rejectedReason = $rejectedReason;
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
                ->subject($MAIL_FROM_NAME)
                ->view('mail.vm_pms_employee_appraisal_mail')
                ->with('senderName', $this->senderName)
                ->with('status', $this->status)
                ->with('appraisal_period', $this->appraisal_period)
                ->with('receiverName', $this->receiverName)
                ->with('rejectedReason', $this->rejectedReason);
    }
}
