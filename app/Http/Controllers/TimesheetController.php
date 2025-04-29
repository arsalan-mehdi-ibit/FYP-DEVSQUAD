<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Jobs\InvoiceJob;
use Carbon\Carbon;


class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageTitle = "Timesheet";
        $dates = Timesheet::select('week_start_date')
            ->distinct()
            ->orderBy('week_start_date', 'desc')
            ->get();
    
        $timesheets = Timesheet::with(['project.client', 'contractor']);
    
        // Apply role-based restrictions
        if (Auth::user()->role == 'admin') {
            // No restrictions
        } elseif (Auth::user()->role == 'client') {
            $projectIds = Project::where('client_id', Auth::id())->pluck('id');
            $timesheets->whereIn('project_id', $projectIds);
        } elseif (Auth::user()->role == 'consultant') {
            $projectIds = Project::where('consultant_id', Auth::id())->pluck('id');
            $timesheets->whereIn('project_id', $projectIds);
        } elseif (Auth::user()->role == 'contractor') {
            $timesheets->where('contractor_id', Auth::id());
        }
    
        // Now Apply Filters if any (dates, projects, clients, contractors, statuses)
        if ($request->dates) {
            $timesheets->where(function ($query) use ($request) {
                foreach ($request->dates as $date) {
                    $range = explode(' - ', $date);
                    $start = Carbon::parse($range[0])->format('Y-m-d');
                    $end = Carbon::parse($range[1])->format('Y-m-d');
    
                    $query->orWhere(function ($q) use ($start, $end) {
                        $q->whereDate('week_start_date', $start)
                            ->whereDate('week_end_date', $end);
                    });
                }
            });
        }
    
        if ($request->projects) {
            $timesheets->whereHas('project', function ($query) use ($request) {
                $query->whereIn('id', $request->projects);
            });
        }
    
        if ($request->clients) {
            $timesheets->whereHas('project.client', function ($query) use ($request) {
                $query->whereIn('id', $request->clients);
            });
        }
    
        if ($request->contractors) {
            $timesheets->whereHas('contractor', function ($query) use ($request) {
                $query->whereIn('id', $request->contractors);
            });
        }
    
        if ($request->statuses) {
            $timesheets->whereIn('status', $request->statuses);
        }
    
        // Sorting (custom based on role)
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'contractor') {
            $timesheets->orderByRaw("
                CASE 
                    WHEN status = 'submitted' THEN 1
                    WHEN status = 'pending' THEN 2
                    WHEN status = 'approved' THEN 3
                    WHEN status = 'rejected' THEN 4
                    ELSE 5
                END
            ")->orderBy('submitted_at', 'desc')
              ->orderBy('week_start_date', 'asc');
        } else {
            $timesheets->orderBy('week_start_date', 'asc');
        }
    
        // Pagination
        $timesheets = $timesheets->paginate(10);
    
        // Check if it's an AJAX request (comes from your filter script)
        if ($request->ajax()) {
            return response()->json([
                'html' => view('timesheet', compact('timesheets', 'pageTitle'))->render(),
            ]);
        }
    
        // Normal request (full page load)
        return view('timesheet', compact('pageTitle', 'timesheets', 'dates'));
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
        InvoiceJob::dispatch($timesheet);

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

        return back()->with('success', 'Timesheet rejected successfully.');
    }

    // public function getTotalActualHours($timesheetDetailId)
    // {
    //     $timesheetDetail = TimesheetDetail::find($timesheetDetailId);
        
    //     if ($timesheetDetail) {
    //         // Sum up the actual hours of tasks related to this timesheet detail
    //         $totalHours = $timesheetDetail->tasks()->sum('actual_hours');
    //         return response()->json([
    //             'status' => 'success',
    //             'total_hours' => $totalHours,
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Timesheet detail not found',
    //     ]);
    // }
    // public function filter(Request $request)
    // {
    //     $timesheets = Timesheet::query();

    //     if ($request->dates) {
    //         $timesheets->where(function ($query) use ($request) {
    //             foreach ($request->dates as $date) {
    //                 $range = explode(' - ', $date);
    //                 $start = Carbon::parse($range[0])->format('Y-m-d');
    //                 $end = Carbon::parse($range[1])->format('Y-m-d');

    //                 $query->orWhere(function ($q) use ($start, $end) {
    //                     $q->whereDate('week_start_date', $start)
    //                         ->whereDate('week_end_date', $end);
    //                 });
    //             }
    //         });
    //     }
    //     // dd($timesheets->get());

    //     if ($request->projects) {
    //         $timesheets->whereHas('project', function ($query) use ($request) {
    //             $query->whereIn('name', $request->projects);
    //         });
    //     }

    //     if ($request->clients) {
    //         $timesheets->whereHas('project.client', function ($query) use ($request) {
    //             $query->whereIn('firstname', $request->clients);
    //         });
    //     }

    //     if ($request->contractors) {
    //         $timesheets->whereHas('contractor', function ($query) use ($request) {
    //             $query->whereIn('firstname', $request->contractors);
    //         });
    //     }

    //     if ($request->statuses) {
    //         $timesheets->whereIn('status', $request->statuses);
    //     }

    //     // $timesheets = Timesheet::paginate(10);
    //     $pageTitle = 'hi';
    //     // Now return only the table HTML for AJAX
    //     return response()->json([
    //         'html' => view('timesheet', compact('timesheets', 'pageTitle'))->render(),
    //     ]);
    // }

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
