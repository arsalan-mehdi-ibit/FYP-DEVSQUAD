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
        $pageTitle  = "Users LIst";
        $users = User::all(); 
        return view('users', compact('pageTitle','users'));
    }
    
    public function add()
{
    $pageTitle = "Users"; // Set the page title
    return view('cruds.add_user', compact('pageTitle'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    
        return redirect()->route('users.index')->with('success', 'User added successfully!');
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
