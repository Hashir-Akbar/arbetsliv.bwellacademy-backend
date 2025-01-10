<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffLoginsMail extends Mailable
{
    use Queueable, SerializesModels;

    private $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(t('emails.auth-staff_logins'))->with($this->mailData)->view('emails.auth.staff_logins');
    }
}
