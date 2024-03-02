<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApproverejectloanMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $approver_name;
     protected $employeename;

     protected $requestid;

     protected $result;
     protected $link;
     protected $approvalStatus;
     protected $emp_image;
     protected $reviewer_comments;
     protected $next_approver;
     protected $current_approver;


    public function __construct($approver_name,$employeename,$requestid,$result,$link,$approvalStatus,$emp_image,$reviewer_comments,$next_approver,$current_approver)
    {
        $this->approver_name = $approver_name;

        $this->employeename = $employeename;

        $this->requestid = $requestid;

        $this->result = $result;

        $this->link = $link;

        $this->approvalStatus = $approvalStatus;

        $this->emp_image = $emp_image;

        $this->reviewer_comments = $reviewer_comments;

        $this->next_approver = $next_approver;

        $this->current_approver = $current_approver;



    }

    public function build()
    {


         $subject = $this->result . " of Loan Request – Request ID " . $this->requestid ;

        if($this->result == "Approved"){

            $output = $this->view('mail_salary_adv_approve')
            ->subject($subject)
            ->with('approverName', $this->approver_name)
            ->with('employeeName',$this->employeename)
            ->with('requestID',$this->requestid)
            ->with('result',$this->result)
            ->with('link',$this->link )
            ->with('approvalStatus',$this->approvalStatus )
            ->with('emp_image',$this->emp_image )
            ->with('next_approver',$this->next_approver)
            ->with('current_approver',$this->current_approver);

        }else if($this->result == "Rejected"){

            $output = $this->view('mail_salary_adv_reject')
            ->subject($subject)
            ->with('approverName', $this->approver_name)
            ->with('employeeName',$this->employeename)
            ->with('requestID',$this->requestid)
            ->with('result',$this->result)
            ->with('link',$this->link )
            ->with('approvalStatus',$this->approvalStatus )
            ->with('emp_image',$this->emp_image )
            ->with('reviewer_comments',$this->reviewer_comments );

        }

        return $output;
    }
}

