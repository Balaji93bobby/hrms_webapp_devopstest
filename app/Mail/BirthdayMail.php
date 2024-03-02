<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\VmtClientMaster;

class BirthdayMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $name;
    protected $client_id;


    public function __construct($name, $client_id)
    {
        //
        $this->name  = $name;

        $this->client_id  = $client_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

            $output = $this->view('vmt_employeebirthday_email')
            ->subject('Happy Birthday')
            ->with('name', $this->name)
            ->with('client_id', $this->client_id);


        //Only for Employee Onboarding
        //if($this->filename != "")
        // $output->attach($this->filename);

        return $output;

        }



}
