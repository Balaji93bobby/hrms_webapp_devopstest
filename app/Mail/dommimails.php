<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class dommimails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $status;
     protected $error_msg;
     protected $error_string;


    public function __construct($status,$error_msg,$error_string)
    {
        $this->status = $status;
        $this->err_msg = $error_msg;
        $this->err_str = $error_string;
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
 public function build(){
    return $this->view('dommi')
        ->with('status',$this->status)
        ->with('err_msg',$this->err_msg)
        ->with('err_str',$this->err_str);
 }


}
