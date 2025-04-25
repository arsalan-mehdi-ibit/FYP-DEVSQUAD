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
use App\Jobs\FillTimesheet;



class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = "Projects";
    
        if(Auth::user()->role == 'admin')
        {
            //ADMIN CAN SEE ALL THE PROJECTS
            $projects = Project::orderBy('id', 'desc')->get();

        }
        elseif(Auth::user()->role == 'client')
        {
           
            //Client CAN SEE only his PROJECTS
            $projects = Project::where('client_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        }
        elseif(Auth::user()->role == 'consultant')
        {
          
            //Consultant CAN SEE only his PROJECTS
            $projects = Project::where('consultant_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        }
        elseif(Auth::user()->role == 'contractor')
        {
        //CONTRACTOR SHOULD ONLY SEE THE PROJECTS IN WHICH HE IS WORKING

            $contractorId = Auth::id();

            // Fetch projects where contractor_id matches
           $projects = Project::whereHas('contractors', function($query) use ($contractorId) {
    $query->where('users.id', $contractorId);
})->orderBy('id', 'desc')->get();

        }
        return view('project', compact('pageTitle', 'projects'));
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
            Rule::unique('projects')->whereNull('deleted_at')  // <-- main part
        ],
            'type' => 'required|string',
            'client_id' => 'required|exists:users,id',
            'consultant_id' => 'nullable|exists:users,id',
            'referral_source' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,in_progress,completed,cancelled',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => ['nullable', 'date', 'after:start_date', 'after_or_equal:today'],
            'notes' => 'nullable|string|max:255',
            'attachments.*' => 'nullable|file|max:2048', // For multiple file uploads
            'contractors' => 'array', // Validate the contractors field
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

            // Create the project
            $project = Project::create($validated);

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
    $project = Project::with(['client', 'contractors','consultant', 'fileAttachments'])->findOrFail($id);
    
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
            // Find the project to update
            $project = Project::findOrFail($id);
    
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

        
            // Return a success message
            return redirect()->route('project.index')->with('project_updated', 'Project updated successfully.');
    
       } catch (\Exception $e) {
           // Handle any errors during the update process
           return back()->with('error', 'Whoops! Something went wrong, please try again.');
       }

    }

    public function removeContractor($contractorId, Request $request)
    {
        $project = Project::findOrFail($request->project_id); // This should return an object, not an array
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

    // public function createTimesheet(Request $request, $contractorId, $projectId)
    // {
    //     // Validate the request data
    //     $validated = $request->validate([
    //         'week_start_date' => 'required|date',
    //         'week_end_date' => 'required|date|after_or_equal:week_start_date',
    //         'hours_worked' => 'required|numeric|min:0',
    //     ]);

    //     // Dispatch the job to handle the timesheet creation
    //     FillTimesheet::dispatch(
    //         $contractorId,
    //         $projectId,
    //         $validated['week_start_date'],
    //         $validated['week_end_date'],
    //         $validated['hours_worked']
    //     );

    //     return response()->json(['message' => 'Timesheet creation job dispatched.']);
    // }
}
