<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');  // The login view you created earlier
    }

    // Handle login attempt
    public function login(Request $request)
    {
        // Validate the login data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to log the user in
        // if (Auth::attempt($credentials)) {
            // If successful, redirect to the dashboard or intended page
            return redirect()->intended('/dashboard');
        // }

        // If login fails, return back with an error
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Redirect to the login page after logout
        return redirect('/login');
    }
}
