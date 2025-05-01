<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TimesheetDetail;
use App\Models\Project;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch the counts for each category
        $adminCount = User::where('role', 'admin')->count();
        $consultantCount = User::where('role', 'consultant')->count();
        $clientCount = User::where('role', 'client')->count();
        $contractorCount = User::where('role', 'contractor')->count();
        $projects = Project::all();
        $pageTitle = "Dashboard";

        // Pass the counts to the view
        return view('dashboard', compact('pageTitle', 'adminCount', 'consultantCount', 'clientCount', 'contractorCount','projects'));
    }

    public function getMonthlyHours(Request $request)
    {
        $projectId = $request->input('project_id');

        $query = TimesheetDetail::with('timesheet')
        ->whereYear('date', now()->year)
        ->whereHas('timesheet', function ($q) use ($projectId) {
            $q->where('status', 'approved'); // ✅ only approved timesheets

            if ($projectId && $projectId !== 'all') {
                $q->where('project_id', $projectId);
            }
        });

        $monthlyHours = $query->selectRaw('MONTH(date) as month, SUM(actual_hours) as total_hours')
            ->groupBy('month')
            ->pluck('total_hours', 'month');

        $data = [];
        foreach (range(1, 12) as $month) {
            $data[] = round($monthlyHours[$month] ?? 0, 2);
        }

        return response()->json(['data' => $data]);
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
