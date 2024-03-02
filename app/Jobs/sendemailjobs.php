<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\dommimails;
use Illuminate\Support\Facades\Mail;

class sendemailjobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $simmamail  = array('simmasrfc1330@gmail.com','sathishrain2001@gmail.com','sathishraina159@gmail.com');

            for($i=0; $i<count($simmamail); $i++){
                Mail::to($simmamail[$i])->send(new dommimails());
            }


      // dd($simmamail);

      //  Mail::to('simmasrfc1330@gmail.com')->send(new dommimails());
    }
}
