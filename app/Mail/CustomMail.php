<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    private $template;

    private $mailSubject;

    private $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $subject, $mailData)
    {
        $this->template = $template;
        $this->mailSubject = $subject;
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailSubject)->with($this->mailData)->view($this->template);
    }
}
