<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSender extends Mailable
{
    use Queueable, SerializesModels;

    public $receiverEmail;
    public $subject;
    public $data;
    public $bladeTemplate;
    public $pdfContent;
    public $pdfFilename;


    /**
     * Create a new message instance.
     */
    public function __construct($subject, $data, $bladeTemplate, $pdfContent = null, $pdfFilename = null)
    {

        $this->subject = $subject;
        $this->data = $data;
        $this->bladeTemplate = $bladeTemplate;
        $this->pdfContent = $pdfContent;
        $this->pdfFilename = $pdfFilename;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $email = $this->to($this->receiverEmail)
            ->subject($this->subject)
            ->view($this->bladeTemplate)
            ->with($this->data);
        if ($this->pdfContent && $this->pdfFilename) {
            $email->attachData($this->pdfContent, $this->pdfFilename, [
                'mime' => 'application/pdf',
            ]);
        }
        return $email;
    }
}
