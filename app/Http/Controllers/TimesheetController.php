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
use Carbon\Carbon;


class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = "Timesheet";

        $currentMonth = now()->month;
        $currentYear = now()->year;
    
        // Initialize the counts
        $thisMonthCount = 0;
        $approvedCount = 0;
        $rejectedCount = 0;
        $pendingApprovalCount = 0;
    
        // Calculate counts for each category
        $thisMonthCount = Timesheet::whereYear('submitted_at', $currentYear)
            ->whereMonth('submitted_at', $currentMonth)
            ->count();
    
        $approvedCount = Timesheet::where('status', 'approved')
            ->count(); // Count for all-time approved timesheets
    
        $rejectedCount = Timesheet::where('status', 'rejected')
            ->count(); // Count for all-time rejected timesheets
    
        $pendingApprovalCount = Timesheet::where('status', 'pending')
            ->count(); // Count for all-time pending approval timesheets
    

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

return view('timesheet', compact('pageTitle', 'timesheets', 'thisMonthCount', 'approvedCount', 'rejectedCount', 'pendingApprovalCount'));

    }

   public function submit($id)
{
    $timesheet = Timesheet::findOrFail($id);

    if (Auth::id() !== $timesheet->contractor_id) {
        abort(403, 'Unauthorized');
    }

    $timesheet->status = 'submitted';
    $timesheet->submitted_at = now();
    $timesheet->save();

    // Prepare common data
    $project = $timesheet->project;
    $contractor = $timesheet->contractor;
    $client = $project->client;
    $consultant = $project->consultant;
    $admins = User::where('role', 'admin')->get();

    $contractor_name = "{$contractor->firstname} {$contractor->lastname}";
    $project_name = $project->name;
    $week_start = Carbon::parse($timesheet->week_start_date)->format('M d, Y');
    $week_end = Carbon::parse($timesheet->week_end_date)->format('M d, Y');

    $timesheet_date = $week_start . ' - ' . $week_end;

    // Helper method to log activity and notification
    $logActivity = function ($user, $title, $description, $withNotification = false) use ($timesheet) {
        RecentActivity::create([
            'title' => $title,
            'description' => $description,
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $user->id,
            'created_by' => Auth::id(),
        ]);

        if ($withNotification) {
            notifications::create([
                'parent_id' => $timesheet->id,
                'created_for' => 'timesheet',
                'user_id' => $user->id,
                'message' => $description,
                'is_read' => 0,
            ]);
        }
    };

    // Helper method to send email
    $sendEmail = function ($user, $role) use ($contractor_name, $project_name, $timesheet_date, $timesheet) {
        $emailData = [
            'contractor_name' => $contractor_name,
            'project_name' => $project_name,
            'timesheet_date' => $timesheet_date,
            'timesheet_id' => $timesheet->id,
            'role' => $role,
        ];

        Mail::to($user->email)->send(new EmailSender(
            "Timesheet Submitted for Approval",
            $emailData,
            'emails.timesheet_submitted'
        ));
    };

    // Contractor activity (no email or notification needed)
    if ($contractor) {
        $logActivity($contractor, 'Timesheet Submitted', 'You have submitted a timesheet for the project "' . $project_name . '".');
    }

    // Client
    if ($client) {
        $sendEmail($client, 'client');
        $logActivity($client, 'Timesheet Submitted', 'A contractor has submitted a timesheet for the project "' . $project_name . '".', true);
    }

    // Consultant (activity only)
    if ($consultant) {
        $logActivity($consultant, 'Timesheet Submitted', 'A contractor has submitted a timesheet for the project "' . $project_name . '".');
    }

    // Admins
    foreach ($admins as $admin) {
        $sendEmail($admin, 'admin');
        $logActivity($admin, 'Timesheet Submitted', 'A contractor has submitted a timesheet for the project "' . $project_name . '".', true);
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
    $contractor = $timesheet->contractor;
    $project = $timesheet->project;
    $client = $project->client;
    $approver = Auth::user();

    $emailData = [
        'contractor_name' => "{$contractor->firstname} {$contractor->lastname}",
        'approver_name' => "{$approver->firstname} {$approver->lastname}",
        'project_name' => $project->name,
        'status' => 'approved',
    ];

    Mail::to($contractor->email)->send(new EmailSender(
        "Timesheet Approved",
        $emailData,
        'emails.timesheet_status_email'
    ));

    // 🎯 Define all users to notify (contractor, client, all admins)
    $usersToNotify = collect([$contractor, $client])
        ->merge(User::where('role', 'admin')->get())
        ->filter(); // removes null users like missing client

    foreach ($usersToNotify as $user) {
        // Dynamic description based on role
        $description = $user->id === $contractor->id
            ? 'Your timesheet for the project "' . $project->name . '" has been approved.'
            : 'A contractor\'s timesheet for the project "' . $project->name . '" has been approved.';

        RecentActivity::create([
            'title' => 'Timesheet Approved',
            'description' => $description,
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $user->id,
            'created_by' => $approver->id,
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

    // Related data
    $contractor = $timesheet->contractor;
    $project = $timesheet->project;
    $client = $project->client;
    $admin = Auth::user();

    // Send rejection email to contractor
    $emailData = [
        'contractor_name' => "{$contractor->firstname} {$contractor->lastname}",
        'approver_name' => $admin->name,
        'project_name' => $project->name,
        'status' => 'rejected',
        'rejection_reason' => $request->rejection_reason,
    ];
    Mail::to($contractor->email)->send(new EmailSender(
        "Timesheet Rejected",
        $emailData,
        'emails.timesheet_status_email'
    ));

    // All users to notify
    $usersToNotify = collect([$contractor, $client])
        ->merge(User::where('role', 'admin')->get())
        ->filter(); // Remove null if any

    foreach ($usersToNotify as $user) {
        $isContractor = $user->id === $contractor->id;
        $description = $isContractor
            ? 'Your timesheet for the project "' . $project->name . '" has been rejected. Reason: ' . $request->rejection_reason
            : 'A contractor\'s timesheet for the project "' . $project->name . '" has been rejected. Reason: ' . $request->rejection_reason;

        RecentActivity::create([
            'title' => 'Timesheet Rejected',
            'description' => $description,
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $user->id,
            'created_by' => $admin->id,
        ]);

        // Notification only for contractor
        if ($isContractor) {
            notifications::create([
                'parent_id' => $timesheet->id,
                'created_for' => 'timesheet',
                'user_id' => $contractor->id,
                'message' => $description,
                'is_read' => 0,
            ]);
        }
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
