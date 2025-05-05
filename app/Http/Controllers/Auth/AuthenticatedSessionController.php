<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{

    //   Display the login view.
    public function create()
    {
        if (!Auth::check()) {
            return view('auth.login');
        } else {
            return redirect()->route('dashboard.index');
        }
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Check if the user exists and is active
        $user = User::where('email', $request->email)->first();

        // If no user is found or user is not active, return error
        if (!$user || !$user->is_active) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records or your account is inactive.',
            ])->onlyInput('email');
        }

        // Proceed with the authentication if the user is active
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Regenerate session to prevent session fixation attacks
            return redirect()->route('dashboard.index'); // Redirect to intended route
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout(); // Log out the user

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/')->with('success', 'You have been logged out.');
    }
}
