<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Jobs\InvoiceJob;
use App\Mail\EmailSender;
use App\Models\RecentActivity;
use App\Models\Notifications;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Events\NewNotification;


class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageTitle = "Timesheet";

        $currentMonth = now()->month;
        $currentYear = now()->year;

        $user = auth()->user();

        if ($user->role === 'admin') {
            // Admin sees all counts
            $thisMonthCount = Timesheet::whereYear('submitted_at', $currentYear)
                ->whereMonth('submitted_at', $currentMonth)
                ->count();

            $approvedCount = Timesheet::where('status', 'approved')->count();
            $rejectedCount = Timesheet::where('status', 'rejected')->count();
            $pendingApprovalCount = Timesheet::where('status', 'submitted')
                ->whereNotNull('submitted_at')
                ->count();

            $allTimesheets = Timesheet::with(['project.client', 'contractor'])->get();
        } else {
            // Other roles see only their relevant timesheets
            $query = Timesheet::query();

            if ($user->role === 'contractor') {
                $query->where('contractor_id', $user->id);
            }

            if ($user->role === 'client') {
                $query->whereHas('project', function ($q) use ($user) {
                    $q->where('client_id', $user->id);
                });
            }

            if ($user->role === 'consultant') {
                // Adjust this based on how consultants are related to timesheets/projects
                $query->where('consultant_id', $user->id);
            }

            $thisMonthCount = (clone $query)->whereYear('submitted_at', $currentYear)
                ->whereMonth('submitted_at', $currentMonth)
                ->count();

            $approvedCount = (clone $query)->where('status', 'approved')->count();
            $rejectedCount = (clone $query)->where('status', 'rejected')->count();
            $pendingApprovalCount = (clone $query)->where('status', 'submitted')
                ->whereNotNull('submitted_at')
                ->count();

            $allTimesheets = $query->with(['project.client', 'contractor'])->get();
        }

        $dates = $allTimesheets->unique(function ($item) {
            return $item->week_start_date . $item->week_end_date;
        })->sortByDesc('week_start_date')->values();

        $projects = $allTimesheets->unique('project_id')->filter(fn($t) => $t->project);
        $clients = $allTimesheets->filter(fn($t) => $t->project && $t->project->client)->unique(fn($t) => $t->project->client->id);
        $contractors = $allTimesheets->unique('contractor_id')->filter(fn($t) => $t->contractor);


        // Start base query
        $query = Timesheet::with(['details', 'project.client', 'contractor']);


        // Role-based restrictions
        if (Auth::user()->role == 'admin') {
            // admin sees all
            $query->orderByRaw("
            CASE 
                WHEN status = 'submitted' THEN 1
                WHEN status = 'pending' THEN 2
                WHEN status = 'rejected' THEN 3
                WHEN status = 'approved' THEN 4
                ELSE 5
            END
        ")->orderByDesc('submitted_at')
                ->orderByDesc('updated_at');
        } elseif (Auth::user()->role == 'client') {
            $projectIds = Project::where('client_id', Auth::id())->pluck('id');
            $query->whereIn('project_id', $projectIds)
                ->orderByRaw("
              CASE 
                  WHEN status = 'submitted' THEN 1
                  WHEN status = 'pending' THEN 2
                  WHEN status = 'rejected' THEN 3
                  WHEN status = 'approved' THEN 4
                  ELSE 5
              END
            ")->orderByDesc('submitted_at')
                ->orderByDesc('updated_at');
        } elseif (Auth::user()->role == 'consultant') {
            $projectIds = Project::where('consultant_id', Auth::id())->pluck('id');
            $query->whereIn('project_id', $projectIds);
        } elseif (Auth::user()->role == 'contractor') {
            $query->where('contractor_id', Auth::id())
                ->orderByRaw("
            CASE 
                WHEN status = 'rejected' THEN 1
                WHEN status = 'pending' THEN 2
                WHEN status = 'submitted' THEN 3
                WHEN status = 'approved' THEN 4
                ELSE 5
            END
          ")->orderByDesc('submitted_at')
                ->orderByDesc('updated_at');

        } {
            $query->orderBy('week_start_date', 'asc');
        }

        // Filters
        if ($request->dates) {
            $query->where(function ($query) use ($request) {
                foreach ($request->dates as $date) {
                    $range = explode(' - ', $date);
                    $start = \Carbon\Carbon::parse($range[0])->format('Y-m-d');
                    $end = \Carbon\Carbon::parse($range[1])->format('Y-m-d');

                    $query->orWhere(function ($q) use ($start, $end) {
                        $q->whereDate('week_start_date', $start)
                            ->whereDate('week_end_date', $end);
                    });
                }
            });
        }

        if ($request->projects) {
            $query->whereIn('project_id', $request->projects);
        }

        if ($request->clients) {
            $query->whereHas('project.client', function ($q) use ($request) {
                $q->whereIn('id', $request->clients);
            });
        }

        if ($request->contractors) {
            $query->whereHas('contractor', function ($q) use ($request) {
                $q->whereIn('id', $request->contractors);
            });
        }

        if ($request->statuses) {
            $query->whereIn('status', $request->statuses);
        }

        // Final pagination
        $timesheets = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('timesheet', compact(
                    'timesheets',
                    'pageTitle',
                    'thisMonthCount',
                    'approvedCount',
                    'rejectedCount',
                    'pendingApprovalCount',
                    'dates',
                    'projects',
                    'clients',
                    'contractors'
                ))->render(),
            ]);

        }

        return view('timesheet', compact(
            'pageTitle',
            'timesheets',
            'thisMonthCount',
            'approvedCount',
            'rejectedCount',
            'pendingApprovalCount',
            'dates',
            'projects',
            'clients',
            'contractors'
        ));

    }

    public function getTotalHours($id)
    {
        $timesheet = Timesheet::with('details')->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'total_hours' => $timesheet->total_hours,
        ]);
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
                    'title' => $title,
                    'parent_id' => $timesheet->id,
                    'created_for' => 'timesheet',
                    'user_id' => $user->id,
                    'message' => $description,
                    'is_read' => 0,
                ]);
                event(new NewNotification($description, $user->id));

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
        $timesheet = Timesheet::with(['details', 'contractor', 'project.client'])->findOrFail($id);

        if (!in_array(Auth::user()->role, ['admin', 'client'])) {
            abort(403, 'Unauthorized');
        }

        $timesheet->status = 'approved';
        $timesheet->save();
        InvoiceJob::dispatch($timesheet);
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
            $isContractor = $user->id === $contractor->id;
            $description = $isContractor
                ? 'Your timesheet for the project "' . $project->name . '" has been approved.'
                : 'A contractor\'s timesheet for the project "' . $project->name . '" has been approved.';

            // Recent activity entry
            RecentActivity::create([
                'title' => 'Timesheet Approved',
                'description' => $description,
                'parent_id' => $timesheet->id,
                'created_for' => 'timesheet',
                'user_id' => $user->id,
                'created_by' => $approver->id,
            ]);

            // Notification only for contractor
            if ($isContractor) {
                notifications::create([
                    'title' => 'Timesheet Approved',
                    'parent_id' => $timesheet->id,
                    'created_for' => 'timesheet',
                    'user_id' => $contractor->id,
                    'message' => $description,
                    'is_read' => 0,
                ]);
                event(new NewNotification($description, $contractor->id));

            }
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
                ? 'Your timesheet for the project "' . $project->name . '" has been rejected because ' . $request->rejection_reason
                : 'A contractor\'s timesheet for the project "' . $project->name . '" has been rejected because ' . $request->rejection_reason;

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
                    'title' => 'Timesheet Rejected',
                    'parent_id' => $timesheet->id,
                    'created_for' => 'timesheet',
                    'user_id' => $contractor->id,
                    'message' => $description,
                    'is_read' => 0,
                ]);
                event(new NewNotification($description, $contractor->id));


            }
        }
        return back()->with('success', 'Timesheet rejected successfully.');
    }

    public function exportAllToPdf(Request $request)
    {
        $query = Timesheet::with(['project.client', 'contractor']);

        if (Auth::user()->role == 'admin') {
            $query->orderByRaw("
                CASE 
                    WHEN status = 'submitted' THEN 1
                    WHEN status = 'pending' THEN 2
                    WHEN status = 'rejected' THEN 3
                    WHEN status = 'approved' THEN 4
                    ELSE 5
                END
            ")->orderByDesc('submitted_at')->orderByDesc('updated_at');

        } elseif (Auth::user()->role == 'client') {
            $projectIds = Project::where('client_id', Auth::id())->pluck('id');
            $query->whereIn('project_id', $projectIds)->orderByRaw("
                CASE 
                    WHEN status = 'submitted' THEN 1
                    WHEN status = 'pending' THEN 2
                    WHEN status = 'rejected' THEN 3
                    WHEN status = 'approved' THEN 4
                    ELSE 5
                END
            ")->orderByDesc('submitted_at')->orderByDesc('updated_at');

        } elseif (Auth::user()->role == 'contractor') {
            $query->where('contractor_id', Auth::id())->orderByRaw("
                CASE 
                    WHEN status = 'rejected' THEN 1
                    WHEN status = 'pending' THEN 2
                    WHEN status = 'submitted' THEN 3
                    WHEN status = 'approved' THEN 4
                    ELSE 5
                END
            ")->orderByDesc('submitted_at')->orderByDesc('updated_at');

        } else {
            $query->orderBy('week_start_date', 'asc');
        }

        // ✅ Apply Filters (Only if present in request)
        if ($request->filled('projects')) {
            $query->whereIn('project_id', $request->input('projects'));
        }

        if ($request->filled('statuses')) {
            $query->whereIn('status', $request->input('statuses'));
        }

        if ($request->filled('clients')) {
            $query->whereHas('project.client', function ($q) use ($request) {
                $q->whereIn('id', $request->input('clients'));
            });
        }

        if ($request->filled('contractors')) {
            $query->whereIn('contractor_id', $request->input('contractors'));
        }

        if ($request->filled('dates')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->input('dates') as $dateRange) {
                    [$start, $end] = explode(' - ', $dateRange);
                    $q->orWhere(function ($subQuery) use ($start, $end) {
                        $subQuery->where('week_start_date', $start)->where('week_end_date', $end);
                    });
                }
            });
        }

        $timesheets = $query->get();
        $role = Auth::user()->role;

        $pdf = Pdf::loadView('pdf.timesheet', compact('timesheets', 'role'));
        return $pdf->download('Timesheets.pdf');
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

