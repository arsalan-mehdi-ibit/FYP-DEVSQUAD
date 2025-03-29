<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericMail;

class MailController extends Controller
{
    public function sendTestEmail()
    {
        $receiverEmail = 'f21bb125@ibitpu.edu.pk'; // Change this to a real email
        $subject = 'Test Email';
        $data = [
            'name' => 'Minu', // Ensure 'name' key exists
            'message' => 'This is a test email content'
        ];
        $bladeTemplate = 'emails.test_email'; // Ensure this template exists
    
        Mail::to($receiverEmail)->send(new GenericMail($receiverEmail, $subject, $data, $bladeTemplate));
    
        return "Test email sent successfully!";
    }
    
}
