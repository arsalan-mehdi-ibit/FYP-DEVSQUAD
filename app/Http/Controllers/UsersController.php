<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = "Users LIst";
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
            // $validated['password'] = bcrypt('default_password'); // Set a default password
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;
            $validated['send_emails'] = $request->has('send_emails') ? 1 : 0;

            // Create the user
           $user =  User::create($validated);
           MediaController::uploadFile($request , $user->id);

            // Redirect with success message
            return redirect()->route('users.index')->with('user_invitation_sent', true);
        } 
        catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('User creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong'  . (env('APP_DEBUG', false) ? $e->getMessage() : '')]);

            // Redirect back with an error message
            // return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
