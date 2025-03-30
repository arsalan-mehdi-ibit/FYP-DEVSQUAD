<?php

namespace App\Http\Controllers\Auth;

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

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request, $token)
    {
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

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Find user by token
        $user = User::where('remember_token', $request->token)->first();

        // If user exists, update password and clear token
        if ($user) {
            $user->update([
                'password' => bcrypt($request->password),
                'remember_token' => null,
            ]);

            return redirect()->route('login')->with('success', 'Your password has been reset successfully.');
        }

        // If user not found, redirect to login with error
        return redirect()->route('login')->withErrors(['error' => 'Invalid or expired reset link.']);
    }

}
