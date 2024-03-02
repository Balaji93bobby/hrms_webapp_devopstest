<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FinanceApproverejectloanMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $status;
    protected $request_id;
    protected $emp_name;
    protected $loan_type;
    protected $emp_image;
    protected $cmds;
    protected $link;

    public function __construct($status, $request_id, $emp_name, $loan_type, $emp_image, $cmds, $link)
    {
        $this->status = $status;
        $this->request_id = $request_id;
        $this->emp_name = $emp_name;
        $this->loan_type = $loan_type;
        $this->emp_image = $emp_image;
        $this->cmds = $cmds;
        $this->link = $link;
    }

    public function build()
    {


        $subject = "Approved of " . $this->loan_type . " – Request ID " .   $this->request_id;

        if ($this->status == "Approved") {
            $subject = $this->loan_type . " Request Approved – Request ID " .  $this->request_id;
            $output = $this->view('loan_mails.emp_approve_mail_finance')
                ->subject($subject)
                ->with('employeeName', $this->emp_name)
                ->with('requestID', $this->request_id)
                ->with('result', $this->status)
                ->with('link', $this->link)
                ->with('emp_image', $this->emp_image)
                ->with('loan_type', $this->loan_type)
                ->with('reviewer_comments', $this->cmds);
        } else if ($this->status == "Rejected") {
            $subject = "Rejected of " . $this->loan_type . " Request – Request ID " .  $this->request_id;
            $output = $this->view('loan_mails.emp_reject_mail_finance')
                ->subject($subject)
                ->with('employeeName', $this->emp_name)
                ->with('requestID', $this->request_id)
                ->with('result', $this->status)
                ->with('link', $this->link)
                ->with('emp_image', $this->emp_image)
                ->with('loan_type', $this->loan_type)
                ->with('reviewer_comments', $this->cmds);
        }

        return $output;
    }
}
