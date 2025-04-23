<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Contractor;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = "Projects";
        $projects = Project::all();
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
        'start_date' => ['required', 'date'],
        'end_date' => ['nullable', 'date', 'after:start_date'],
        'notes' => 'nullable|string|max:255',
        'attachments.*' => 'nullable|file|max:2048',
        'contractors' => 'array',
        'contractors.*.contractor_id' => 'required|exists:users,id',
        'contractors.*.rate' => 'required|numeric|min:0',
    ]);

    try {
        // Check for an active project with the same name
        // $active = Project::where('name', $validated['name'])->first();
        // if ($active) {
        //     return back()->with('error', 'A project with this name already exists.');
        // }

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
    $project = Project::with(['client', 'contractors', 'fileAttachments'])->findOrFail($id);
    
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
                Rule::unique('projects')->whereNull('deleted_at')  
            ],
            'type' => 'required|string',
            'client_id' => 'required|exists:users,id',
            'consultant_id' => 'nullable|exists:users,id',
            'referral_source' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,in_progress,completed,cancelled',
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'notes' => 'nullable|string|max:255',
            'attachments.*' => 'nullable|file|max:2048',
            'contractors' => 'array',
            'contractors.*.contractor_id' => 'required|exists:users,id',
            'contractors.*.rate' => 'required|numeric|min:0',
        ]);
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
    
            // Update the project with the new validated data
            $project->update($validated);
    
            // Return a success message
            return redirect()->route('project.index')->with('project_updated', 'Project updated successfully.');
    
        } catch (\Exception $e) {
            // Handle any errors during the update process
            return back()->with('error', 'Whoops! Something went wrong, please try again.');
        }
    
        // Find the project by ID
        $project = Project::findOrFail($id);

        // Update the project
        $project->update($validated);

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

        // Redirect with success message
        return redirect()->route('project.index')->with('project_updated', true);
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
