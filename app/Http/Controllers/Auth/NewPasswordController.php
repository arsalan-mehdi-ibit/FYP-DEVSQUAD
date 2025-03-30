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
    public function create(Request $request): RedirectResponse|View
    {
        dd($request);
        // Fetch token from route and email from query parameters
        $token = $request->route('token');
        $email = $request->query('email'); // Use query() to get email from URL

        // Check if the token exists in the database
        $user = User::where('remember_token', $token)->where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'The reset link has expired or is invalid.']);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }


    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {

    // }
}
