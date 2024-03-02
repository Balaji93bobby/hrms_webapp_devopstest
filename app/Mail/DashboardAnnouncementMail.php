<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DashboardAnnouncementMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_emp_name,$title_data,$details_data)
    {
        $this->user_emp_name = $user_emp_name;
        $this->title_data = $title_data;
        $this->details_data = $details_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.vmt_dashboard_announcement_mail')
                    ->subject('New Announcement')
                    ->with('user_emp_name', $this->user_emp_name)
                    ->with('title_data', $this->title_data)
                    ->with('details_data', $this->details_data);
    }
}
