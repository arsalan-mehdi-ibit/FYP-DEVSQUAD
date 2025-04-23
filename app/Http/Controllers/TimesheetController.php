<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $pageTitle  = "Timesheet";

        if(Auth::user()->role == 'admin')
        {
            $timesheets = timesheet::all();

        }
        elseif(Auth::user()->role == 'client')
        {
            $projectIds = Project::where('client_id', Auth::id())->pluck('id'); 
            $timesheets = Timesheet::whereIn('project_id', $projectIds)->get();
        }elseif(Auth::user()->role == 'consultant')
        {
            $projectIds = Project::where('consultant_id', Auth::id())->pluck('id'); 
            $timesheets = Timesheet::whereIn('project_id', $projectIds)->get();
        }elseif (Auth::user()->role == 'contractor') {
            // Contractor: See timesheets where he is assigned
            $timesheets = Timesheet::where('contractor_id', Auth::id())->get();
        }
        return view('timesheet', compact('pageTitle', 'timesheets'));
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
