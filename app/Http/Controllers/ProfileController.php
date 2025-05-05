<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\MediaController;
use App\Models\FileAttachment;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to access your profile.');
        }
        // Get the profile picture for the authenticated user
        $profilePicture = FileAttachment::where('parent_id', $user->id)
            ->where('file_for', 'profile')
            ->latest() // in case there are multiple, get latest
            ->first();

        $pageTitle = 'Hi, ' . $user->firstname . " " . $user->lastname;
        return view('profile', compact('pageTitle', 'user', 'profilePicture')); 
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        
        $user = Auth::user();

        // Validate the incoming request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|same:password_confirmation',
            'password_confirmation' => 'nullable|string|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the user's information
        $user->firstname = $request->input('first_name');
        $user->middlename = $request->input('middle_name');
        $user->lastname = $request->input('last_name');
        $user->phone = $request->input('phone');

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Save the updated user details in the database
        $user->save();
        MediaController::uploadFile($request, $user->id);
        
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
