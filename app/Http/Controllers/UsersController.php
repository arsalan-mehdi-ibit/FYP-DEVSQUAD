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
use Illuminate\Support\Facades\Storage;
use App\Models\RecentActivity;
use App\Models\Notifications;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            return redirect('/dashboard');
        }

        $pageTitle = "Users List";
        // Get counts for each user role
        $adminCount = User::where('role', 'admin')->count();
        $clientCount = User::where('role', 'client')->count();
        $contractorCount = User::where('role', 'contractor')->count();
        $consultantCount = User::where('role', 'consultant')->count();
        $users = User::query(); // Start building the query

        // Apply Role Filter if roles[] are selected
        if ($request->roles) {
            $users->whereIn('role', $request->roles);
        }

        $users = $users->orderBy('id', 'desc')->paginate(10); // 10 users per page


        // Check if it's an AJAX request (comes from filter)
        if ($request->ajax()) {
            return response()->json([
                'html' => view('users', compact('pageTitle', 'users', 'adminCount', 'clientCount', 'contractorCount', 'consultantCount'))->render(),
            ]);
        }

        // Normal full page load
        return view('users', compact('pageTitle', 'users', 'adminCount', 'clientCount', 'contractorCount', 'consultantCount'));
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
                'firstname' => 'required|regex:/^[A-Za-z]+$/|max:255',
                'middlename' => 'nullable|regex:/^[A-Za-z]+$/|max:255',
                'lastname' => 'required|regex:/^[A-Za-z]+$/|max:255',
                'role' => 'required|string',
                'address' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'phone' => 'required|string|max:20',
                'source' => 'nullable|string|max:255',
                'is_active' => 'nullable|boolean',
                'send_emails' => 'nullable|boolean',
            ]);

            // ✅ Check for existing soft-deleted user with same email
            $softDeletedUser = User::onlyTrashed()->where('email', $validated['email'])->first();
            if ($softDeletedUser) {
                $softDeletedUser->forceDelete(); // Hard delete the previous soft-deleted user
            }

            // Now validate uniqueness after deleting
            $request->validate([
                'email' => 'unique:users,email',
            ]);

            // Set additional attributes
            $validated['email_verified_at'] = now();
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;
            $validated['send_emails'] = $request->has('send_emails') ? 1 : 0;

            $validated['remember_token'] = Str::random(32);

            // Create the user
            $user = User::create($validated);

            $adminUsers = User::where('role', 'admin')->get(); // adjust this if your roles are stored differently

            // Step 2: Loop through each admin user
            foreach ($adminUsers as $admin) {
                RecentActivity::create([
                    'title' => 'User Created',
                    'description' => 'New user ' . $user->firstname . ' ' . $user->lastname . ' has been created.',
                    'parent_id' => $user->id,
                    'created_for' => 'user',
                    'user_id' => $admin->id,
                    'created_by' => Auth::id(),
                ]);
                // Create Notification
                Notifications::create([
                    'title' => 'User Created',
                    'parent_id' => $user->id,
                    'created_for' => 'user',
                    'user_id' => $admin->id,
                    'message' => 'New user ' . $user->firstname . ' ' . $user->lastname . ' has been created.',
                    'is_read' => 0,
                ]);
            }
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
        $validated = $request->validate([
            'firstname' => 'required|regex:/^[A-Za-z]+$/|max:255',
            'middlename' => 'nullable|regex:/^[A-Za-z]+$/|max:255',
            'lastname' => 'required|regex:/^[A-Za-z]+$/|max:255',
            'role' => 'required|string',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'source' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'send_emails' => 'nullable|boolean',
            'attachments.*' => 'nullable|file|max:2048', // For multiple files
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;


        $user = User::findOrFail($id);
        // Check if user is linked to a project and trying to change role
        if ($request->role !== $user->role && $user->projects()->exists()) {
            return redirect()->back()->withErrors(['role' => 'Role cannot be changed because this user is linked to a project.']);
        }
        $user->update($validated);
        $adminUsers = User::where('role', 'admin')->get(); // Modify this if you're using a roles table or package

        // Step 3: Create recent activity for each admin
        foreach ($adminUsers as $admin) {
            RecentActivity::create([
                'title' => 'User Updated',
                'description' => 'User ' . $user->firstname . ' ' . $user->lastname . ' was updated.',
                'parent_id' => $user->id,
                'created_for' => 'user',
                'user_id' => $admin->id, // Notify each admin
                'created_by' => Auth::id(), // Logged-in user
            ]);
            // Create Notification
            Notifications::create([
                'title' => 'User Updated',
                'parent_id' => $user->id,
                'created_for' => 'user',
                'user_id' => $admin->id,
                'message' => 'User ' . $user->firstname . ' ' . $user->lastname . ' was updated.',
                'is_read' => 0,
            ]);
        }

        if ($request->hasFile('attachments')) {
            MediaController::uploadFile($request, $user->id);
        }

        return redirect()->route('users.index')->with('user_updated', true);
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
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Optional: Soft delete logic (if using SoftDeletes trait)
            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('User deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while deleting the user.');
        }
    }


}
