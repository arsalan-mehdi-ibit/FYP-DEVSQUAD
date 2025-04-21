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
    dd('Login method triggered');
       // Validate the login inputs (email and password)
       $request->validate([
           'email' => 'required|email',
           'password' => 'required|string',
       ]);

       // Debugging: Log incoming request
       Log::info("Login attempt for email: " . $request->email);

       // Get user based on the email
       $user = \App\Models\User::where('email', $request->email)->first();

       // Check if the user exists
       if (!$user) {
           Log::warning("User not found: " . $request->email);
           return back()->withErrors([
               'email' => 'These credentials do not match our records.',
           ])->onlyInput('email');
       }

       // Check if user is inactive
       if (!$user->is_active) {
           Log::warning("Inactive user: " . $request->email);
           return back()->withErrors([
               'email' => 'Your account is inactive. Please contact support.',
           ])->onlyInput('email');
       }

       // Debugging: Check is_active status
       Log::info("User is active: " . $user->email);

       // Check the password manually
       if (!Hash::check($request->password, $user->password)) {
           Log::warning("Invalid password for user: " . $request->email);
           return back()->withErrors([
               'email' => 'These credentials do not match our records.',
           ])->onlyInput('email');
       }

       // Log the user in manually
       Auth::login($user);
       $request->session()->regenerate();  // Regenerate session to prevent session fixation

       // Redirect to the intended page or default dashboard
       return redirect()->intended('/dashboard');
   }


    
    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Redirect to the login page after logout
        return redirect('/login');
    }
}
