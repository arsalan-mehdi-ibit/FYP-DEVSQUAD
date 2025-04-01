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
        $request->authenticate();

        $request->session()->regenerate();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        } else {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('username');
        }
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Redirect to the login page after logout
        return redirect('/login');
    }
}
