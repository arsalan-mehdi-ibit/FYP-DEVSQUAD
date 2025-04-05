<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\EmailSender;


class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request, $token)
    {
        if (!Auth::check()) {

            // Find user by token
            $user = User::where('remember_token', $token)->first();

            // If token is invalid, redirect to login with an error message
            if (!$user) {
                return redirect()->route('login')->withErrors(['error' => 'The reset link has expired or is invalid.']);
            }

            // Redirect to the reset password page with token & email
            return view('auth.reset-password', [
                'token' => $token,
                'email' => $user->email
            ]);
        }
        return redirect()->route('dashboard.index');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate and save token
        $token = Str::random(32);
        $user->remember_token = $token;
        $user->save();

        // Generate reset link
        $resetLink = URL::route('password.reset', ['token' => $token]);

        // Prepare email data
        $emailData = [
            'user_name' => "{$user->firstname} {$user->lastname}",
            'message' => 'Click the button below to reset your password.',
            'reset_link' => $resetLink,
        ];

        // Send email
        Mail::to($user->email)->send(new EmailSender(
            'Reset your TrackPoint Password',
            $emailData,
            'emails.forgot_password_email' // updated template name
        ));

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password'); 
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate request
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Find user by token
        $user = User::where('remember_token', $request->token)->first();

        // If user exists, update password and clear token
        if ($user) {
            $user->update([
                'password' => bcrypt($request->password),
                'remember_token' => null,
            ]);

            // Redirect to login with success message
            return redirect()->route('login')->with('success', 'Your password has been reset successfully.');
        }

        // If user not found, redirect back with error
        return redirect()->back()->withErrors(['error' => 'Invalid or expired reset link.']);
    }

}
