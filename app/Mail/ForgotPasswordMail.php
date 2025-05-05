<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token; // ✅ Add this

    // ✅ Constructor: Add $token to parameters
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
    public function build()
    {
        // ✅ Use the token in your reset link
        $resetLink = route('password.reset', $this->token);

        return $this->subject('Reset Your Password')
            ->view('emails.forgot-password')
            ->with(['resetLink' => $resetLink]);
    }
}
