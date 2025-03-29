<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public $receiverEmail;
    public $subject;
    public $data;
    public $bladeTemplate;

    /**
     * Create a new message instance.
     */
    public function __construct($receiverEmail, $subject, $data, $bladeTemplate)
    {
        $this->receiverEmail = $receiverEmail;
        $this->subject = $subject;
        $this->data = $data;
        $this->bladeTemplate = $bladeTemplate;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->to($this->receiverEmail)
                    ->subject($this->subject)
                    ->view($this->bladeTemplate)
                    ->with($this->data);
    }
}
