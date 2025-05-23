<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Contractor;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RecentActivity;
use App\Models\Notifications;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSender;
use App\Jobs\FillTimesheet;
use App\Events\NewNotification;
use Carbon\Carbon;
use App\Models\ProjectContractor;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $pageTitle = "Projects";

        // Initialize variables
        $adminCount = $consultantCount = $clientCount = $contractorCount = null;
        $totalProjects = $activeProjects = $pendingProjects = $completedProjects = null;
        $projects = collect(); 

        // Admin Overview
        if ($role === 'admin') {
            $activeProjects = Project::where('status', 'in_progress')->count();
            $adminCount = User::where('role', 'admin')->count();
            $clientCount = User::where('role', 'client')->count();
            $contractorCount = User::where('role', 'contractor')->count();
            $projects = Project::all();
        }

        // Client Projects
        elseif ($role === 'client') {
            $projects = Project::where('client_id', $user->id)->get();
        }

        // Contractor Projects via pivot table
        elseif ($role === 'contractor') {
            $projectIds = ProjectContractor::where('contractor_id', $user->id)->pluck('project_id');
            $projects = Project::whereIn('id', $projectIds)->get();
        }

        // Consultant Projects
        elseif ($role === 'consultant') {
            $projects = Project::where('consultant_id', $user->id)->get();
        }

        // Status counts
        if (in_array($role, ['client', 'contractor', 'consultant'])) {
            $totalProjects = $projects->count();
            $activeProjects = $projects->where('status', 'in_progress')->count();
            $pendingProjects = $projects->where('status', 'pending')->count();
            $completedProjects = $projects->where('status', 'completed')->count();
        }

        // Filtered paginated projects for table
        $projectsQuery = Project::with('client');

        if ($role === 'client') {
            $projectsQuery->where('client_id', $user->id);
        } elseif ($role === 'consultant') {
            $projectsQuery->where('consultant_id', $user->id);
        } elseif ($role === 'contractor') {
            $contractorId = $user->id;
            $projectsQuery->whereHas('contractors', function ($query) use ($contractorId) {
                $query->where('users.id', $contractorId);
            });
        }

        if ($request->clients) {
            $projectsQuery->whereIn('client_id', $request->clients);
        }

        if ($request->statuses) {
            $projectsQuery->whereIn('status', $request->statuses);
        }

        $projects = $projectsQuery->orderBy('id', 'desc')->paginate(10);

        // View or AJAX
        $viewData = compact(
            'pageTitle',
            'projects',
            'adminCount',
            'clientCount',
            'contractorCount',
            'pendingProjects',
            'completedProjects',
            'totalProjects',
            'activeProjects'
        );

        if ($request->ajax()) {
            return response()->json([
                'html' => view('project', $viewData)->render(),
            ]);
        }

        return view('project', $viewData);
    }

    /**
     * Show the form for creating a new project.
     */
    public function add()
    {
        $pageTitle = "Add Project";
        $users = User::all();
        $contractors = $users->where('role', 'contractor');
        return view('cruds.add_project', compact('pageTitle', 'users', 'contractors'));
    }

    public function triggerTimesheetJob($project)
    {
        // Ensure we have a single Project instance
        if (!$project instanceof Project) {
            $project = Project::findOrFail($project);
        }
        $contractors = $project->contractors;
        FillTimesheet::dispatch($project, $contractors);
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects')->whereNull('deleted_at')  
            ],
            'type' => 'required|string',
            'client_id' => 'required|exists:users,id',
            'consultant_id' => 'nullable|exists:users,id',
            'referral_source' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,in_progress,completed,cancelled',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => ['nullable', 'date', 'after:start_date', 'after_or_equal:today'],
            'notes' => 'nullable|string|max:255',
            'attachments.*' => 'nullable|file|max:2048', 
            'contractors' => 'array', 
            'contractors.*.contractor_id' => 'required|exists:users,id',
            'contractors.*.rate' => 'required|numeric|min:0',
        ]);
        if (
            $validated['status'] === 'in_progress' &&
            (!isset($validated['contractors']) || count($validated['contractors']) < 1)
        ) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['contractors' => 'At least one contractor is required when the project status is "in progress".']);
        }
        try {

            // Check for a soft-deleted project with the same name
            $trashed = Project::onlyTrashed()->where('name', $validated['name'])->first();
            if ($trashed && in_array($trashed->status, ['pending', 'cancelled'])) {
                $trashed->forceDelete(); // Hard delete the old project
            }


            // Set client_rate, default to 0.00 if not provided
            $validated['client_rate'] = $request->client_rate ?? 0.00;

            
            $project = Project::create($validated);
            // Prepare shared email info
            $adminName = Auth::user()->firstname . ' ' . Auth::user()->lastname; // Or any appropriate admin name
            $projectName = $project->name;

            // Send email to client
            $client = User::find($validated['client_id']);
            if ($client) {
                $emailData = [
                    'project_name' => $projectName,
                    'user_name' => "{$client->firstname} {$client->lastname}",
                    'message' => "A new project \"{$projectName}\" has been created and you are added as a client.",
                    'admin_name' => $adminName,
                    'role' => 'client',
                    'reset_link' => null,
                ];
                Mail::to($client->email)->send(new EmailSender("New Project Created", $emailData, 'emails.project_created_email'));
        
            }

            // Send email to consultant if exists
            if (!empty($validated['consultant_id'])) {
                $consultant = User::find($validated['consultant_id']);
                if ($consultant) {
                    $emailData = [
                        'project_name' => $projectName,
                        'user_name' => "{$consultant->firstname} {$consultant->lastname}",
                        'message' => "You have been assigned as a consultant for the new project \"{$projectName}\".",
                        'admin_name' => $adminName,
                        'role' => 'consultant',
                        'reset_link' => null,
                    ];
                    Mail::to($consultant->email)->send(new EmailSender("New Project Assignment", $emailData, 'emails.project_created_email'));
                }
            }

            // Send email to each contractor
            if ($request->has('contractors')) {
                foreach ($request->contractors as $contractor) {
                    $contractorUser = User::find($contractor['contractor_id']);
                    if ($contractorUser) {
                        $emailData = [
                            'project_name' => $projectName,
                            'user_name' => "{$contractorUser->firstname} {$contractorUser->lastname}",
                            'message' => "You have been assigned as a contractor for the new project \"{$projectName}\".",
                            'admin_name' => $adminName,
                            'role' => 'contractor',
                            'reset_link' => null,
                        ];
                        Mail::to($contractorUser->email)->send(new EmailSender("New Project Assignment", $emailData, 'emails.project_created_email'));
                    }
                }
            }


            // Attach contractors to the project if any
            if ($request->has('contractors')) {
                foreach ($request->contractors as $contractor) {
                    $project->contractors()->attach($contractor['contractor_id'], ['contractor_rate' => $contractor['rate']]);
                }
            }
            // Handle file uploads (attachments) if any
            if ($request->hasFile('attachments')) {
                MediaController::uploadFile($request, $project->id);
            }
            $adminUsers = User::where('role', 'admin')->get(); // Modify this if you're using a roles table or package



            // Step 2: Create recent activity for each admin
            foreach ($adminUsers as $admin) {
                RecentActivity::create([
                    'title' => 'Project Created',
                    'description' => 'New project "' . $project->name . '" has been created.',
                    'parent_id' => $project->id,
                    'created_for' => 'project',
                    'user_id' => $admin->id, // Notify each admin
                    'created_by' => Auth::id(), // Logged-in user
                ]);
                notifications::create([
                    'title' => 'Project Created',
                    'parent_id' => $project->id,
                    'created_for' => 'project',
                    'user_id' => $admin->id,
                    'message' => 'New project "' . $project->name . '" has been created.',
                    'is_read' => 0, // By default, unread
                ]);
                event(new NewNotification('New project "' . $project->name . '" has been created by ' . Auth::user()->firstname, $admin->id));
            }

            // Recent Activity for the Client
            if ($client) {
                RecentActivity::create([
                    'title' => 'Project Assigned',
                    'description' => 'You have been assigned as a client for project "' . $project->name . '".',
                    'parent_id' => $project->id,
                    'created_for' => 'project',
                    'user_id' => $client->id,
                    'created_by' => Auth::id(),
                ]);
                notifications::create([
                    'title' => 'Project Assigned',
                    'parent_id' => $project->id,
                    'created_for' => 'project',
                    'user_id' => $client->id,
                    'message' => '"' . $project->name . '" has been updated.',
                    'is_read' => 0, // Unread by default
                ]);
                event(new NewNotification('You have been assigned as a client for project "' . $project->name . '" by ' . Auth::user()->firstname, $project->client_id));
            }


            // Recent Activity for the Consultant
            if ($project->consultant_id) {
                $consultant = User::find($project->consultant_id);
                if ($consultant) {
                    RecentActivity::create([
                        'title' => 'Project Assigned',
                        'description' => 'You have been assigned as a consultant for project "' . $project->name . '".',
                        'parent_id' => $project->id,
                        'created_for' => 'project',
                        'user_id' => $consultant->id,
                        'created_by' => Auth::id(),
                    ]);
                    notifications::create([
                        'title' => 'Project Assigned',
                        'parent_id' => $project->id,
                        'created_for' => 'project',
                        'user_id' => $consultant->id,
                        'message' => 'You have been assigned as a consultant for project "' . $project->name . '".',
                        'is_read' => 0, // Unread by default
                    ]);
                    event(new NewNotification('You have been assigned as a consultant for project "' . $project->name . '" by ' . Auth::user()->firstname, $consultant->id));

                }
            }

            // Recent Activity for the Contractors

            if (isset($validated['contractors']) && count($validated['contractors']) > 0) {
                // Loop through the contractors (even though only one contractor is expected)
                foreach ($validated['contractors'] as $contractor) {
                    // Fetch the contractor by ID
                    $contractorUser = User::find($contractor['contractor_id']);

                    // Check if the contractor exists
                    if ($contractorUser) {
                        // Create recent activity for the assigned contractor
                        RecentActivity::create([
                            'title' => 'Project Assigned',
                            'description' => 'You have been assigned as a contractor for the project "' . $project->name . '".',
                            'parent_id' => $project->id,
                            'created_for' => 'project',
                            'user_id' => $contractorUser->id,  // Notify only the assigned contractor
                            'created_by' => Auth::id(),  // Logged-in user who created the project
                        ]);

                        // Create notification for the assigned contractor
                        notifications::create([
                            'title' => 'Project Assigned',
                            'parent_id' => $project->id,
                            'created_for' => 'project',
                            'user_id' => $contractorUser->id,  // Notify only the assigned contractor
                            'message' => 'You have been assigned as a contractor for the project "' . $project->name . '".',
                            'is_read' => 0,  // By default, unread
                        ]);
                        event(new NewNotification('You have been assigned as a contractor for project "' . $project->name . '" by ' . Auth::user()->firstname, $contractorUser->id));

                    } else {
                        // Log or handle case where contractor does not exist
                        Log::warning('Contractor with ID ' . $contractor['contractor_id'] . ' not found.');
                    }
                }
            }


            // Dispatch the FillTimesheet job after project creation
            $this->triggerTimesheetJob($project);

            return redirect()->route('project.index')->with('project_created', 'Project created successfully.');
        } catch (\Exception $e) {
            Log::error('Create Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create project.');
        }
    }


    /**
     * Show the form for editing the specified project.
     */
    public function edit($id)
    {
        $pageTitle = "Edit Project";
        $project = Project::findOrFail($id);
        $assignedContractorIds = $project->contractors->pluck('id')->toArray();
        $users = User::all();
        $contractors = $users->where('role', 'contractor');

        $projectContractors = $project->contractors->map(function ($contractor) {
            return [
                'contractor_id' => $contractor->id,
                'contractor_rate' => $contractor->pivot->contractor_rate,
            ];
        });

        return view('cruds.add_project', compact('pageTitle', 'project', 'users', 'contractors', 'projectContractors'));
    }


    public function view($id)
    {
        $pageTitle = "View Project";

        // Eager load 'client', 'contractors', and 'fileAttachments' relationships
        $project = Project::with(['client', 'contractors', 'consultant', 'fileAttachments'])->findOrFail($id);

        // Prepare contractor data for display (read-only)
        $projectContractors = $project->contractors->map(function ($contractor) {
            return [
                'contractor_id' => $contractor->id,
                'firstname' => $contractor->firstname,
                'lastname' => $contractor->lastname,
                'contractor_rate' => $contractor->pivot->contractor_rate,
            ];
        });

        // Pass data to the view
        return view('cruds.view_project', compact('project', 'pageTitle', 'projectContractors'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, $id)
    {

        $project = Project::findOrFail($id);

        $startDateRule = 'required|date'; 

        // Only apply "after_or_equal:today" if this is a new project OR if updating to a future date
        if (!$project->exists || ($project->start_date == $request->start_date && $request->start_date >= now()->toDateString())) {
            $startDateRule .= '|after_or_equal:today';
        }

        // Validate the form data
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects')->ignore($id)->whereNull('deleted_at'),
            ],
            'type' => 'required|string',
            'client_id' => 'required|exists:users,id',
            'consultant_id' => 'nullable|exists:users,id',
            'referral_source' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,in_progress,completed,cancelled',
            'start_date' => $startDateRule,
            'end_date' => [
                'nullable',
                function ($attribute, $value, $fail) use ($project) {
                    // Only enforce future end date if the project is new (i.e., being created)
                    // But skip this check if we're updating and end_date is before today
                    if (!$project->exists && Carbon::parse($value)->lt(today())) {
                        $fail('The end date cannot be before today.');
                    }
                }
            ],
            'notes' => 'nullable|string|max:255',
            'attachments.*' => 'nullable|file|max:2048',
            'contractors' => 'array',
            'contractors.*.contractor_id' => 'required|exists:users,id',
            'contractors.*.rate' => 'required|numeric|min:0',
        ]);
        if (
            $validated['status'] === 'in_progress' &&
            (!isset($validated['contractors']) || count($validated['contractors']) < 1)
        ) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['contractors' => 'At least one contractor is required when the project status is "in progress".']);
        }
        try {
            // Find the project to update
            // $project = Project::findOrFail($id);

            if ($project->status === 'completed') {
                return back()->withErrors(['status' => 'Completed project cannot be edited.']);
            }


            if ($project->status === 'in_progress' && $validated['status'] === 'pending') {
                return back()->withErrors(['status' => 'Project already in progress cannot be reverted to pending.']);
            }

            if ($project->status === 'pending' && $validated['status'] === 'completed') {
                return back()->withErrors(['status' => 'Project cannot go directly from pending to completed.']);
            }

            if ($project->status === 'completed' && $validated['status'] !== 'completed') {
                return back()->withErrors(['status' => 'Completed project cannot change status.']);
            }


            // Check if the name has changed
            if ($project->name !== $validated['name']) {
                // Look for any soft-deleted project with the same name
                $trashed = Project::onlyTrashed()->where('name', $validated['name'])->first();

                if ($trashed && in_array($trashed->status, ['pending', 'cancelled'])) {
                    // If found, force delete the soft-deleted project
                    $trashed->forceDelete();
                }
            }


            // Sync the contractors (remove previous and add new ones)
            if (isset($request->contractors)) {
                $project->contractors()->detach(); // Remove existing contractors

                foreach ($request->contractors as $contractor) {
                    $project->contractors()->attach($contractor['contractor_id'], ['contractor_rate' => $contractor['rate']]);
                }
            }

            // Handle file uploads (attachments)
            if ($request->hasFile('attachments')) {
                MediaController::uploadFile($request, $project->id);
            }

            // Update the project with the new validated data
            $project->update($validated);
            // ✅ Dispatch the FillTimesheet job
            $this->triggerTimesheetJob($project);



        } catch (\Exception $e) {
            // Handle any errors during the update process
            return back()->with('error', 'Whoops! Something went wrong, please try again.');
        }

        // Handle file uploads (attachments)
        if ($request->hasFile('attachments')) {
            MediaController::uploadFile($request, $project->id);
        }
        // Step 1: Get all admin users
        $adminUsers = User::where('role', 'admin')->get(); // Modify this if you're using a roles table or package

        // Step 2: Create recent activity for each admin
        foreach ($adminUsers as $admin) {

            RecentActivity::create([
                'title' => 'Project Updated',
                'description' => 'Project "' . $project->name . '" has been updated.',
                'parent_id' => $project->id,
                'created_for' => 'project',
                'user_id' => $admin->id,
                'created_by' => Auth::id(), 
            ]);

            Notifications::create([
                'title' => 'Project Updated',
                'parent_id' => $project->id,
                'created_for' => 'project',
                'user_id' => $admin->id,
                'message' => 'Project "' . $project->name . '" has been updated.',
                'is_read' => 0, 
            ]);
            event(new NewNotification('Project "' . $project->name . '" has been updated by ' . Auth::user()->firstname, $admin->id));


        }
        // Recent Activity for the Client
        if ($project->client_id) {
            RecentActivity::create([
                'title' => 'Project Updated',
                'description' => 'The project "' . $project->name . '" has been updated.',
                'parent_id' => $project->id,
                'created_for' => 'project',
                'user_id' => $project->client_id,
                'created_by' => Auth::id(),
            ]);
            notifications::create([
                'title' => 'Project Assigned',
                'parent_id' => $project->id,
                'created_for' => 'project',
                'user_id' => $project->client_id,
                'message' => 'The project "' . $project->name . '" has been updated.',
                'is_read' => 0, // Unread by default
            ]);
            event(new NewNotification('The project "' . $project->name . '" has been updated by' . Auth::user()->firstname, $project->client_id));


        }

        // Recent Activity for the Consultant
        if ($project->consultant_id) {
            $consultant = User::find($project->consultant_id);
            if ($consultant) {
                RecentActivity::create([
                    'title' => 'Project updated',
                    'description' => 'The project "' . $project->name . '" has been updated.',
                    'parent_id' => $project->id,
                    'created_for' => 'project',
                    'user_id' => $consultant->id,
                    'created_by' => Auth::id(),
                ]);
                notifications::create([
                    'title' => 'Project updated',
                    'parent_id' => $project->id,
                    'created_for' => 'project',
                    'user_id' => $consultant->id,
                    'message' => 'The project "' . $project->name . '" has been updated.',
                    'is_read' => 0, // Unread by default
                ]);
                event(new NewNotification('The project "' . $project->name . '" has been updated by' . Auth::user()->firstname, $consultant->id));

            }
        }

        // Recent Activity for the Contractors
        if (isset($validated['contractors']) && count($validated['contractors']) > 0) {
            // Loop through the contractors (even though only one contractor is expected)
            foreach ($validated['contractors'] as $contractor) {
                // Fetch the contractor by ID
                $contractorUser = User::find($contractor['contractor_id']);

                // Check if the contractor exists
                if ($contractorUser) {
                    // Create recent activity for the assigned contractor
                    RecentActivity::create([
                        'title' => 'Project Updated',
                        'description' => 'The project "' . $project->name . '" has been updated.',
                        'parent_id' => $project->id,
                        'created_for' => 'project',
                        'user_id' => $contractorUser->id,  // Notify only the assigned contractor
                        'created_by' => Auth::id(),  // Logged-in user who created the project
                    ]);

                    // Create notification for the assigned contractor
                    notifications::create([
                        'title' => 'Project Assigned',
                        'parent_id' => $project->id,
                        'created_for' => 'project',
                        'user_id' => $contractorUser->id,  // Notify only the assigned contractor
                        'message' => 'The project "' . $project->name . '" has been updated.',
                        'is_read' => 0,  // By default, unread
                    ]);
                    event(new NewNotification('The project "' . $project->name . '" has been updated by' . Auth::user()->firstname, $contractorUser->id));

                } else {
                    // Log or handle case where contractor does not exist
                    Log::warning('Contractor with ID ' . $contractor['contractor_id'] . ' not found.');
                }
            }
        }


        // Redirect with success message
        return redirect()->route('project.index')->with('project_updated', true);
    }

    public function removeContractor($contractorId, Request $request)
    {
        $project = Project::findOrFail($request->project_id); // This should return an object, not an array

        if ($project->status === 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Contractor cannot be removed while project is in progress.',
            ], 403);
        }

        $contractor = User::findOrFail($contractorId); // Ensure this is an object

        // Detach the contractor from the project
        $project->contractors()->detach($contractor->id);

        return response()->json([
            'success' => true,
            'message' => 'Contractor removed successfully.',
        ]);
    }

    /**
     * Remove the specified project from storage (soft delete).
     */
    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);

            if (in_array($project->status, ['pending', 'cancelled'])) {
                $project->delete(); // Soft delete
                return back()->with('success', 'Project deleted successfully.');
            }

            return back()->with('error', 'Only pending or cancelled projects can be deleted.');

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete project.');
        }
    }

}
