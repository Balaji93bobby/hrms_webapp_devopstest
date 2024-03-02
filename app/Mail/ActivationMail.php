<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationMail extends Mailable
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

    public function __construct($uEmail, $uPassowrd, $loginLink, $filename , $image_view )
    {
        //
        $this->uEmail  = $uEmail;
        $this->uPassowrd  = $uPassowrd;
        $this->loginLink  = $loginLink;
        $this->filename   = $filename;
        $this->image_view   = $image_view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $output = $this->view('vmt_activateemployee_email')
                    ->subject('ABShrms - Your account has been  Activated Successfully')
                    ->with('uEmail', $this->uEmail)
                    ->with('uPassowrd', $this->uPassowrd)
                    ->with('loginLink', $this->loginLink)
                    ->with('image_view', $this->image_view);

        //Only for Employee Onboarding
        if($this->filename != "")
            $output->attach($this->filename);

        return $output;
    }
}
