<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApproveRejectLoanAndSaladvMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $approverName;
     protected $employeeName;
     protected $requestID;
     protected $loanType;
     protected $borrowed_Amount;
     protected $requested_date;
     protected $tenure_month;
     protected $link;
     protected $emp_image;

    public function __construct($approverName,$employeeName,$requestID,$loanType,$borrowed_Amount,$requested_date, $tenure_month ,$link,$emp_image)
    {
        $this->approverName = $approverName;

        $this->employeeName = $employeeName;

        $this->requestID = $requestID;

        $this->loanType = $loanType;

        $this->borrowed_Amount = $borrowed_Amount;

        $this->requested_date = $requested_date;

        $this->tenure_month = $tenure_month;

        $this->link = $link;

        $this->emp_image = $emp_image;

    }

    public function build()
    {

         $subject = " Loan Requested by " . $this->employeeName . " - Request ID: " . $this->requestID ;

        $output = $this->view('vmt_approveRejectSalaryAdv_Email')
                    ->subject($subject)
                    ->with('approverName', $this->approverName)
                    ->with('employeeName',$this->employeeName)
                    ->with('requestID',$this->requestID)
                    ->with('loanType', $this->loanType)
                    ->with('borrowed_Amount', $this->borrowed_Amount)
                    ->with('requested_date', $this->requested_date)
                    ->with('tenure_month', $this->tenure_month)
                    ->with('link',  $this->link)
                    ->with('emp_image',  $this->emp_image);


        return $output;
    }

}
