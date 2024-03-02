<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeClientMail extends Mailable
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
    protected $abs_client;

    public function __construct($uClientName, $uEmail, $uPassowrd, $loginLink, $filename , $image_view , $abs_client)
    {
        //
        $this->clientName = $uClientName;
        $this->uEmail  = $uEmail;
        $this->uPassowrd  = $uPassowrd;
        $this->loginLink  = $loginLink;
        $this->filename   = $filename;
        $this->image_view   = $image_view;
        $this->abs_client   = $abs_client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $output = $this->view('vmt_welcomeclient_email')
                    ->subject('ABShrms - Welcome '.$this->clientName)
                    ->with('clientName', $this->clientName)
                    ->with('uEmail', $this->uEmail)
                    ->with('uPassowrd', $this->uPassowrd)
                    ->with('loginLink', $this->loginLink)
                    ->with('image_view', $this->image_view)
                    ->with('abs_client', $this->abs_client);

        //Only for Employee Onboarding
        if($this->filename != "")
            $output->attach($this->filename);

        return $output;
    }
}
