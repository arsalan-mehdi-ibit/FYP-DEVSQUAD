<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSender;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = "Users List";
        $users = User::all();
        return view('users', compact('pageTitle', 'users'));
    }

    public function add()
    {
        $pageTitle = "Users"; // Set the page title
        return view('cruds.add_user', compact('pageTitle'));
    }


    public function store(Request $request)
    {
        // dd($request);
        try {
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'role' => 'required|string',
                'address' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'source' => 'nullable|string|max:255',
                'is_active' => 'nullable|boolean',
                'send_emails' => 'nullable|boolean',
            ]);

            // Set additional attributes
            $validated['email_verified_at'] = now();
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;
            $validated['send_emails'] = $request->has('send_emails') ? 1 : 0;

            $validated['remember_token'] = Str::random(32);

            // Create the user
            $user = User::create($validated);
            MediaController::uploadFile($request, $user->id);


            $admin = Auth::user();
            $adminName = $admin ? "{$admin->firstname} {$admin->lastname}" : 'Admin';


            $resetLink = URL::route('password.reset', ['token' => $validated['remember_token']]);

            // Prepare email data
            $emailData = [
                'user_name' => "{$user->firstname} {$user->lastname}",
                'message' => 'Welcome to TrackPoint!',
                'admin_name' => $adminName,
                'reset_link' => $resetLink,
            ];

            // Send welcome email
            Mail::to($user->email)->send(new EmailSender('Welcome to TrackPoint', $emailData, 'emails.welcome_email'));


            // Redirect with success message
            return redirect()->route('users.index')->with('user_invitation_sent', true);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('User creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong' . (env('APP_DEBUG', false) ? $e->getMessage() : '')]);

        }
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        $pageTitle = "Edit User"; // Define the page title for edit
        return view('cruds.add_user', compact('pageTitle', 'user')); // Pass both variables to the view
    }
    public function update(Request $request, $id)
{
    // Validate the request
    $validated = $request->validate([
        'firstname' => 'required|string|max:255',
        'middlename' => 'nullable|string|max:255',
        'lastname' => 'required|string|max:255',
        'role' => 'required|string',
        'address' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id, // Ensure unique email except for this user
        'phone' => 'required|string|max:20',
        'source' => 'nullable|string|max:255',
        'is_active' => 'nullable|boolean',
        'send_emails' => 'nullable|boolean',
    ]);

    // Find the user and update their details
    $user = User::findOrFail($id);
    $user->update($validated);

    // Optionally, handle file uploads or other logic here

    return redirect()->route('users.index')->with('user_updated', true); // Redirect back after update
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
