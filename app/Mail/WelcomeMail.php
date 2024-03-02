<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\VmtClientMaster;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $uEmail;
    protected $uPassowrd;
    protected $loginLink;
    protected $filename;
    protected $image_view;
    protected $client_code;

    public function __construct($uEmail, $uPassowrd, $loginLink, $filename , $image_view,$client_code )
    {
        //
        $this->uEmail  = $uEmail;
        $this->uPassowrd  = $uPassowrd;
        $this->loginLink  = $loginLink;
        $this->filename   = $filename;
        $this->image_view   = $image_view;
        $this->client_code   = $client_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

            $output = $this->view('vmt_welcomeemployee_email')
            ->subject('ABShrms - Welcome')
            ->with('uEmail', $this->uEmail)
            ->with('uPassowrd', $this->uPassowrd)
            ->with('loginLink', $this->loginLink)
            ->with('image_view', $this->image_view)
            ->with('client_code',$this->client_code);

            // $output = $this->view('appointment_mail_templates.appointment_Letter_dunamis_machines')
            // ->subject('ABShrms - Welcome');

        //Only for Employee Onboarding
        if($this->filename != "")
        $output->attach($this->filename);

        return $output;

        }



}
