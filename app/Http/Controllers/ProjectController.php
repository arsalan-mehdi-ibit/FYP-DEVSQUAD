<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


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
        $clients = User::where('role', 'client')->get();
        $consultants = User::where('role', 'consultant')->get();
        $contractors = User::where('role', 'contractor')->get(); // Get contractors
        $statusOptions = ['pending', 'in_progress', 'completed', 'cancelled'];
        $projectTypes = ['fixed', 'time_and_material'];

        return view('cruds.add_project', compact('pageTitle', 'statusOptions', 'projectTypes', 'clients', 'consultants', 'contractors'));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'client_id' => 'required|exists:users,id',
            'consultant_id' => 'nullable|exists:users,id',
            'referral_source' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,in_progress,completed,cancelled',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'notes' => 'nullable|string|max:255',
            'attachments.*' => 'nullable|file|max:2048', // For multiple file uploads
            'contractors' => 'array', // Validate the contractors field
            'contractors.*.contractor_id' => 'required|exists:users,id',
            'contractors.*.rate' => 'required|numeric|min:0',
        ]);

        // Set client_rate, default to 0.00 if not provided
        $validated['client_rate'] = $request->client_rate ?? 0.00;

        // Generate a unique token for the project (like `remember_token` for users)
        // $validated['remember_token'] = Str::random(32);

        // Create the project
        $project = Project::create($validated);

        // Handle the contractors for the project
        if (isset($request->contractors)) {
            foreach ($request->contractors as $contractor) {
                $project->contractors()->attach($contractor['contractor_id'], ['contractor_rate' => $contractor['rate']]);
            }
        }

        // Handle file uploads (if any)
        if ($request->hasFile('attachments')) {
            MediaController::uploadFile($request, $project->id);
        }

        // Redirect with success message
        return redirect()->route('project.index')->with('project_created', true);
    }


    /**
     * Show the form for editing the specified project.
     */
    public function edit($id)
    {
        $pageTitle = "Edit Project"; // Set the page title
        $project = Project::findOrFail($id); // Find the project by its ID
        $clients = User::where('role', 'client')->get(); // Get users with 'client' role
        $consultants = User::where('role', 'consultant')->get(); // Get users with 'consultant' role
        $contractors = User::where('role', 'contractor')->get();
        $statusOptions = ['pending', 'in_progress', 'completed', 'cancelled']; // Correct status options from enum
        $projectTypes = ['fixed', 'time_and_material'];

        // Get the contractors for this project
        $projectContractors = $project->contractors->map(function ($contractor) {
            return [
                'contractor_id' => $contractor->id,
                'contractor_rate' => $contractor->pivot->contractor_rate
            ];
        });

        return view('cruds.add_project', compact('pageTitle', 'statusOptions', 'projectTypes', 'clients', 'consultants', 'contractors', 'project', 'projectContractors'));
    }


    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'client_id' => 'required|exists:users,id',
            'consultant_id' => 'nullable|exists:users,id',
            'referral_source' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,in_progress,completed,cancelled',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'notes' => 'nullable|string|max:255',
            'attachments.*' => 'nullable|file|max:2048', // For multiple file uploads
            'contractors' => 'array', // Validate contractors for the project
            'contractors.*.contractor_id' => 'required|exists:users,id',
            'contractors.*.rate' => 'required|numeric|min:0',
        ]);

        // Find the project by ID
        $project = Project::findOrFail($id);

        // Update the project
        $project->update($validated);

        // Sync the contractors for the project (replace existing contractors with the updated ones)
        if (isset($request->contractors)) {
            // Remove all previous contractors
            $project->contractors()->detach();

            // Add new contractors
            foreach ($request->contractors as $contractor) {
                $project->contractors()->attach($contractor['contractor_id'], ['contractor_rate' => $contractor['rate']]);
            }
        }

        // Handle file uploads (if any)
        if ($request->hasFile('attachments')) {
            MediaController::uploadFile($request, $project->id);
        }

        // Redirect with success message
        return redirect()->route('project.index')->with('project_updated', true);
    }

    /**
     * Display the specified project.
     */
    // public function show($id)
    // {
    //     $project = Project::findOrFail($id);
    //     return view('project.show', compact('project'));
    // }

    // /**
    //  * Remove the specified project from storage.
    //  */
    // public function destroy($id)
    // {
    //     $project = Project::findOrFail($id);
    //     $project->delete();

    //     return redirect()->route('projects.index')->with('project_deleted', true);
    // }
}
