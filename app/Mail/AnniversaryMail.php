<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnniversaryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // protected $linkUri;

    protected $user_emp_name;
    protected $client_id;
    public function __construct($user_emp_name,$client_id)

    {
        //
        $this->user_emp_name = $user_emp_name;
        $this->client_id = $client_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        return $this->view('employeeWorkAnniversary')
                ->subject('Happy Work Anniversary')
                ->with('user_emp_name', $this->user_emp_name)
                ->with('client_id', $this->client_id);


    }
}
