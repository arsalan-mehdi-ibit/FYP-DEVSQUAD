<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller 
{   public function index()
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to access your profile.');
        }
    
        $pageTitle = 'Hi, ' . $user->firstname . " " . $user->lastname;
        return view('profile', compact('pageTitle', 'user')); // ✅ Passing 'user' to Blade
    }
    public function edit()
   {
    $user = Auth::user();
    return view('profile.edit', compact('user'));
    }
    public function update(Request $request): RedirectResponse
    {
        
        // Get the authenticated user
        $user = Auth::user();
       dd($request);
       // Validate the incoming request
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|same:confirmpassword',
            'confirmpassword' => 'nullable|string|min:8',
            'profilepicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Update the user's information
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->phone = $request->input('phone');
    
        // Update email if it's different from the current one
        if ($user->email !== $request->input('email')) {
            $user->email = $request->input('email');
            $user->email_verified_at = null; // Reset email verification if the email is changed
        }
    
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($user->profile_picture && Storage::exists($user->profile_picture)) {
                Storage::delete($user->profile_picture);
            }
    
            // Store the new profile picture and get the path
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
       
        // Save the updated user details in the database
        $user->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
    