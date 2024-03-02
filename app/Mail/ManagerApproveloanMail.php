<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManagerApproveloanMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $emp_name;
    protected $requestid;
    protected $approver_name;
    protected $loan_type;
    protected $request_amt;
    protected $requested_date;
    protected $tenure_month;
    protected $remarks;
    protected $emp_image;
    protected  $next_appr_name;
    protected $link;
    public function __construct($emp_name, $requestid, $approver_name,$next_appr_name, $loan_type, $request_amt, $requested_date, $tenure_month, $remarks, $emp_image, $link)
    {
        $this->emp_name = $emp_name;
        $this->requestid = $requestid;
        $this->approver_name = $approver_name;
        $this->next_appr_name = $next_appr_name;
        $this->loan_type = $loan_type;
        $this->request_amt = $request_amt;
        $this->requested_date = $requested_date;
        $this->tenure_month = $tenure_month;
        $this->remarks = $remarks;
        $this->emp_image = $emp_image;
        $this->link = $link;
    }

    public function build()
    {

        $subject = $this->loan_type . ' Requested by ' . $this->emp_name . ' - Request ID: ' . $this->requestid;
        $output = $this->view('loan_mails.manager_approve_mail')
            ->subject($subject)
            ->with('approverName',   $this->approver_name)
            ->with('employeeName', $this->emp_name)
            ->with('requestID',  $this->requestid)
            ->with('loanType',  $this->loan_type)
            ->with('borrowed_Amount',  $this->request_amt)
            ->with('requested_date', $this->requested_date)
            ->with('tenure_month', $this->tenure_month)
            ->with('link',  $this->link)
            ->with('next_apr_name',$this->next_appr_name)
            ->with('remarks', $this->remarks)
            ->with('emp_image',  $this->emp_image);


        return $output;
    }
}
