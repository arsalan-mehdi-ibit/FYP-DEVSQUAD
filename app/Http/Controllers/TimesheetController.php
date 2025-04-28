<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailSender;
use App\Models\RecentActivity;
use App\Models\Notifications;
use Illuminate\Support\Facades\Mail;



class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = "Timesheet";

        if (Auth::user()->role == 'admin') {
            $timesheets = Timesheet::with(['project.client', 'contractor'])
                ->orderByRaw("
                    CASE 
                        WHEN status = 'submitted' THEN 1
                        WHEN status = 'pending' THEN 2
                        WHEN status = 'approved' THEN 3
                        WHEN status = 'rejected' THEN 4
                        ELSE 5
                    END
                ") // custom priority sorting
                ->orderBy('submitted_at', 'desc') // latest submitted first inside each status
                ->orderBy('week_start_date', 'asc') // fallback
                ->paginate(10);

        } elseif (Auth::user()->role == 'client') {
            $projectIds = Project::where('client_id', Auth::id())->pluck('id');
            $timesheets = Timesheet::with(['project.client', 'contractor'])
                ->whereIn('project_id', $projectIds)
                ->orderBy('week_start_date', 'asc')
                ->paginate(10);

        } elseif (Auth::user()->role == 'consultant') {
            $projectIds = Project::where('consultant_id', Auth::id())->pluck('id');
            $timesheets = Timesheet::with(['project.client', 'contractor'])
                ->whereIn('project_id', $projectIds)
                ->orderBy('week_start_date', 'asc')
                ->paginate(10);

        }elseif (Auth::user()->role == 'contractor') {
    $timesheets = Timesheet::with(['project.client', 'contractor'])
        ->where('contractor_id', Auth::id())
        ->orderByRaw("
            CASE 
                WHEN status = 'rejected' THEN 1
                WHEN status = 'pending' THEN 2
                WHEN status = 'submitted' THEN 3
                WHEN status = 'approved' THEN 4
                ELSE 5
            END
        ")
        ->orderBy('submitted_at', 'desc')
        ->orderBy('week_start_date', 'asc')
        ->paginate(10);
}


        return view('timesheet', compact('pageTitle', 'timesheets'));
    }

    public function submit($id)
    {
        $timesheet = Timesheet::findOrFail($id);

        if (Auth::id() !== $timesheet->contractor_id) {
            abort(403, 'Unauthorized');
        }

        $timesheet->status = 'submitted';
        $timesheet->submitted_at = now(); // Save current time!
        $timesheet->save();
        // Fetch the associated client and admin users to send the email
    $client = User::find($timesheet->project->client_id); // Assuming the timesheet is linked to a project with a client_id
    $admins = User::where('role', 'admin')->get(); // Get all admins

    // Prepare the email data
    $contractor_name = "{$timesheet->contractor->firstname} {$timesheet->contractor->lastname}"; // Assuming 'contractor' relationship
    $project_name = $timesheet->project->name; // Assuming timesheet is related to a project
    $timesheet_date = $timesheet->date; // Assuming the date field is on the timesheet

    // Send email to client
$client = $timesheet->client;

if ($client) {
    
    $emailData = [
        'contractor_name' => $contractor_name,
        'project_name' => $project_name,
        'timesheet_date' => $timesheet_date,
        'timesheet_id' => $timesheet->id,
        'role' => 'client', 
    ];

    // Timesheet submitted 
    Mail::to($client->email)->send(new EmailSender(
        "Timesheet Submitted for Approval", // Subject
        $emailData,                         // Email data
        'emails.timesheet_submitted'        // Email view 
    ));
}

    
foreach ($admins as $admin) {
    
    $emailData = [
        'contractor_name' => $contractor_name,
        'project_name' => $project_name,
        'timesheet_date' => $timesheet_date,
        'timesheet_id' => $timesheet->id,
        'role' => 'admin', 
    ];

    // Timesheet submitted 
    Mail::to($admin->email)->send(new EmailSender(
        "Timesheet Submitted for Approval", // Subject
        $emailData,                         // Email data
        'emails.timesheet_submitted'        // Email view 
    ));
}


         // Fetch the related project and users
    $project = $timesheet->project;
    $contractor = $timesheet->contractor; // Assuming the timesheet has a contractor relation
    $client = $project->client; // Assuming the project has a client relation
    $consultant = $project->consultant; // Assuming the project has a consultant relation

    // 1. Create Recent Activity and Notifications for the Contractor who Submitted the Timesheet
    if ($contractor) {
        // Create recent activity for the contractor
        RecentActivity::create([
            'title' => 'Timesheet Submitted',
            'description' => 'You have submitted a timesheet for the project "' . $project->name . '".',
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $contractor->id, // Notify the contractor who submitted
            'created_by' => Auth::id(), // The user who submitted the timesheet
        ]);

       
    }

    // 2. Create Recent Activity and Notifications for All Admins
    $adminUsers = User::where('role', 'admin')->get(); // Modify based on how your admins are stored
    foreach ($adminUsers as $admin) {
        // Create recent activity for the admin
        RecentActivity::create([
            'title' => 'Timesheet Submitted',
            'description' => 'A contractor has submitted a timesheet for the project "' . $project->name . '".',
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $admin->id, // Notify each admin
            'created_by' => Auth::id(), // The admin who created the timesheet
        ]);

        // Create notification for the admin
        notifications::create([
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $admin->id, // Notify the admin
            'message' => 'A contractor has submitted a timesheet for the project "' . $project->name . '".',
            'is_read' => 0, // By default, unread
        ]);
    }

    // 3. Create Recent Activity and Notifications for the Project's Client
    if ($client) {
        // Create recent activity for the client
        RecentActivity::create([
            'title' => 'Timesheet Submitted',
            'description' => 'A contractor has submitted a timesheet for the project "' . $project->name . '".',
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $client->id, // Notify the client of the project
            'created_by' => Auth::id(), // The user who submitted
        ]);

        // Create notification for the client
        notifications::create([
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $client->id, // Notify the client
            'message' => 'A contractor has submitted a timesheet for the project "' . $project->name . '".',
            'is_read' => 0, // By default, unread
        ]);
    }

    // 4. Create Recent Activity 
    if ($consultant) {
        // Create recent activity for the consultant
        RecentActivity::create([
            'title' => 'Timesheet Submitted',
            'description' => 'A contractor has submitted a timesheet for the project "' . $project->name . '".',
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $consultant->id, // Notify the consultant of the project
            'created_by' => Auth::id(), // The user who submitted
        ]);

    
      
    }


        return back()->with('success', 'Timesheet submitted successfully.');
    }

    public function approve(Request $request, $id)
    {
        $timesheet = Timesheet::findOrFail($id);

        if (!in_array(Auth::user()->role, ['admin', 'client'])) {
            abort(403, 'Unauthorized');
        }

        $timesheet->status = 'approved';
        $timesheet->save();

        
    // Send email to contractor
    $contractor = User::find($timesheet->contractor_id); // Get the contractor who submitted the timesheet
    $emailData = [
        'contractor_name' => "{$contractor->firstname} {$contractor->lastname}",
        'approver_name' => Auth::user()->name,
        'project_name' => $timesheet->project->name,
        'status' => 'approved',
    ];
    Mail::to($contractor->email)->send(new EmailSender("Timesheet Approved", $emailData, 'emails.timesheet_status_email'));
         // Get related project, contractor, and client
    $project = $timesheet->project;
    $contractor = $timesheet->contractor; // Assuming the timesheet has a contractor relation
    $client = $project->client; // Assuming the project has a client relation
    $admin = Auth::user(); // The user who approved the timesheet (admin or client)

    // 1. Create recent activity 
    if ($contractor) {
        RecentActivity::create([
            'title' => 'Timesheet Approved',
            'description' => 'Your timesheet for the project "' . $project->name . '" has been approved.',
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $contractor->id, // Notify the contractor
            'created_by' => $admin->id, // The user who approved the timesheet
        ]);

      
    }

    // 2. Create recent activity and notifications for the client of the project
    if ($client) {
        RecentActivity::create([
            'title' => 'Timesheet Approved',
            'description' => 'The contractor\'s timesheet for the project "' . $project->name . '" has been approved.',
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $client->id, // Notify the client
            'created_by' => $admin->id, // The user who approved the timesheet
        ]);

      
    }

    // 3. Create recent activity 
    $adminUsers = User::where('role', 'admin')->get(); // Modify based on how your admins are stored
    foreach ($adminUsers as $adminUser) {
        RecentActivity::create([
            'title' => 'Timesheet Approved',
            'description' => 'A contractor\'s timesheet for the project "' . $project->name . '" has been approved.',
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $adminUser->id, // Notify each admin
            'created_by' => $admin->id, // The user who approved the timesheet
        ]);

       
    }

        return back()->with('success', 'Timesheet approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $timesheet = Timesheet::findOrFail($id);

        if (!in_array(Auth::user()->role, ['admin', 'client'])) {
            abort(403, 'Unauthorized');
        }

        $timesheet->status = 'rejected';
        $timesheet->rejection_reason = $request->rejection_reason;
        $timesheet->save();


  // Send email to contractor
    $contractor = User::find($timesheet->contractor_id); // Get the contractor who submitted the timesheet
    $emailData = [
        'contractor_name' => "{$contractor->firstname} {$contractor->lastname}",
        'approver_name' => Auth::user()->name,
        'project_name' => $timesheet->project->name,
        'status' => 'rejected',
        'rejection_reason' => $request->rejection_reason,
    ];
    Mail::to($contractor->email)->send(new EmailSender("Timesheet Rejected", $emailData, 'emails.timesheet_status_email'));

         // Update the timesheet status to 'rejected'
    $timesheet->status = 'rejected';
    $timesheet->rejection_reason = $request->rejection_reason; // Save the rejection reason
    $timesheet->save();

    // Get related project, contractor, and client
    $project = $timesheet->project;
    $contractor = $timesheet->contractor; // Assuming the timesheet has a contractor relation
    $client = $project->client; // Assuming the project has a client relation
    $admin = Auth::user(); // The user who rejected the timesheet (admin or client)

    // 1. Create recent activity and notifications for the contractor whose timesheet was rejected
    if ($contractor) {
        RecentActivity::create([
            'title' => 'Timesheet Rejected',
            'description' => 'Your timesheet for the project "' . $project->name . '" has been rejected. Reason: ' . $request->rejection_reason,
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $contractor->id, // Notify the contractor
            'created_by' => $admin->id, // The user who rejected the timesheet
        ]);
        notifications::create([
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $contractor->id, // Notify the contractor
            'message' => 'Your timesheet for the project "' . $project->name . '" has been rejected. Reason: ' . $request->rejection_reason,
            'is_read' => 0, // By default, unread
        ]);
    }
    if ($client) {
        RecentActivity::create([
            'title' => 'Timesheet Rejected',
            'description' => 'The contractor\'s timesheet for the project "' . $project->name . '" has been rejected. Reason: ' . $request->rejection_reason,
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $client->id, // Notify the client
            'created_by' => $admin->id, // The user who rejected the timesheet
        ]);
    }
    $adminUsers = User::where('role', 'admin')->get(); // Modify based on how your admins are stored
    foreach ($adminUsers as $adminUser) {
        RecentActivity::create([
            'title' => 'Timesheet Rejected',
            'description' => 'A contractor\'s timesheet for the project "' . $project->name . '" has been rejected. Reason: ' . $request->rejection_reason,
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $adminUser->id, // Notify each admin
            'created_by' => $admin->id, // The user who rejected the timesheet
        ]);
    }

        return back()->with('success', 'Timesheet rejected successfully.');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
