<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmpApplyLoanMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $name;
     protected $loan_type;
     protected $request_id;
     protected $loginLink;
     protected $emp_image;

    public function __construct( $name,$loan_type,$request_id,$loginLink,$emp_image)
    {
        $this->name=$name;
        $this->loan_type = $loan_type;
        $this->request_id = $request_id;
        $this->loginLink=$loginLink;
        $this->emp_image = $emp_image;
    }

    public function build(){
        $subject = "Acknowledgement of Your ".$this->loan_type." - Request ID- ";

        $output = $this->view('loan_mails.emp_apply_loan_mail')

                    ->subject($subject.$this->request_id)
                    ->with('loanType',$this->loan_type)
                    ->with('employeeName',  $this->name)
                    ->with('emp_image',$this->emp_image)
                    ->with('loginLink', $this->loginLink);

        return $output;
    }
}
