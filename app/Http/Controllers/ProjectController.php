<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
Use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle  = "Projects";
        $projects = Project::all();

        return view('project', compact('pageTitle', 'projects'));
    }

    public function add()
    {
        $pageTitle = "Projects"; // Set the page title
        $clients = User::where('role', 'client')->get();

        return view('cruds.add_project', compact('pageTitle', 'clients'));
        // return view('cruds.add_project', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
      
        // $request->validate([
        //     'project_name' => 'required|string|max:255',
        //     'type' => 'required|string',
        //     'client_id' => 'required|',
        //     'consultant' => 'required|string',
        //     'client_rate' => 'nullable|string',
        //     'status' => 'required|string',
        //     'start_date' => 'nullable|date',
        //     'end_date' => 'nullable|date',
        //     'referral_source' => 'nullable|string',
        //     'notes' => 'nullable|string',
            
            // Add other validation rules as needed
        // ]);
        // dd($request);

        // Create a new project record
        Project::create([
            'name' => $request->project_name,
            // 'type' => $request->input('type'),
            'client_id' => $request->client,
            // 'consultant' => $request->input('consultant'),
            'client_rate' => $request->client_rate,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            // 'referral_source' => $request->input('referral_source'),
            'description' => $request->notes,
            // Add other fields as necessary
        
        ]);
        

        // Redirect back to the project list with a success message
        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Retrieve the project by its ID
        $project = Project::findOrFail($id);
        $pageTitle = "Edit Project"; // Set the page title
        return view('cruds.edit_project', compact('pageTitle', 'project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming data
        $request->validate([
            'project_name' => 'required|string|max:255',
            'type' => 'required|string',
            'client' => 'required|string',
            'consultant' => 'required|string',
            'client_rate' => 'nullable|string',
            'status' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'referral_source' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Find the project by its ID and update it
        $project = Project::findOrFail($id);

        $project->update([
            'project_name' => $request->input('project_name'),
            'type' => $request->input('type'),
            'client' => $request->input('client'),
            'consultant' => $request->input('consultant'),
            'client_rate' => $request->input('client_rate'),
            'status' => $request->input('status'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'referral_source' => $request->input('referral_source'),
            'notes' => $request->input('notes'),
        ]);

        // Redirect back to the project list with a success message
        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find and delete the project
        $project = Project::findOrFail($id);
        $project->delete();

        // Redirect back to the project list with a success message
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }
}
