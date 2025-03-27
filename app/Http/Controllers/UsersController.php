<?php

namespace App\Http\Controllers;

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
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'role' => 'required|string',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'source' => 'nullable|string|max:255',
            'active' => 'boolean',
        ]);
    
        // Create the user
        User::create($validated);
    
        // Redirect to users' index with a session message
        return redirect()->route('users.index')->with('user_invitation_sent', true);

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
