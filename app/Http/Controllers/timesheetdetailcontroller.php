<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;

class TimesheetDetailController extends Controller
{
    // Show all timesheets
    public function index()
    {
        // $timesheets = Timesheet::all(); // Fetch all timesheets
        // return view('timesheets.index', compact('timesheets'));
        return view('timesheetdetail');
    }

    // Show details of a specific timesheet
    public function show($id)
    {
        $timesheet = Timesheet::findOrFail($id); // Fetch timesheet by ID
        return view('timesheets.timesheetdetail', compact('timesheet')); // Matches Blade file name
    }
}
