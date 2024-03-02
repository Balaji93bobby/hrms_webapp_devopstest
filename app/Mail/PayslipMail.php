<?php

namespace App\Mail;

use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayslipMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $loginLink;
    protected $fileObject;
    protected $month;
    protected $year;


    public function __construct( $loginLink, $fileObject , $month, $year)
    {
        //

        $this->loginLink  = $loginLink;
        $this->fileObject   = $fileObject;
        $this->month   = $month;
        $this->year   = $year;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $payslip_filename = "Payslip_".$this->month."_".$this->year.".pdf";
        $month_text = DateTime::createFromFormat('!m', $this->month)->format('F'); //get Month name
        $output = $this->view('vmt_payslip_email')
                    ->subject('ABShrms - Payslip released for the month of '.$month_text." - ".$this->year)
                    ->with('loginLink', $this->loginLink)
                    ->with('month', $month_text)
                    ->with('year', $this->year);


        //Only for Employee Onboarding
        if(!empty($this->fileObject))
            $output->attachData($this->fileObject, $payslip_filename);

        return $output;
    }
}
