<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RecentActivity;
use Illuminate\Support\Facades\Auth;
use App\Models\TimesheetDetail;
use App\Models\Project;
use App\Models\ProjectContractor;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
    $role = $user->role;
    $pageTitle = "Dashboard";

    // Initialize variables
    $adminCount = $consultantCount = $clientCount = $contractorCount = null;
    $totalProjects = $activeProjects = $pendingProjects = $completedProjects = null;
    $projects = collect(); // default empty

    // Admin Overview
    if ($role === 'admin' ) {
        $adminCount = User::where('role', 'admin')->count();
        $consultantCount = User::where('role', 'consultant')->count();
        $clientCount = User::where('role', 'client')->count();
        $contractorCount = User::where('role', 'contractor')->count();
        $projects = Project::all(); // Optional: show all projects
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

    // Shared status counts for client & contractor
    if ($role === 'client' || $role === 'contractor') {
        $totalProjects = $projects->count();
        $activeProjects = $projects->where('status', 'in_progress')->count();
        $pendingProjects = $projects->where('status', 'pending')->count();
        $completedProjects = $projects->where('status', 'completed')->count();
    }

    // Recent activities
    $activities = RecentActivity::with('creator')
        ->where('user_id', $user->id)
        ->latest()
        ->take(10)
        ->get();

    return view('dashboard', compact(
        'pageTitle',
        'adminCount',
        'consultantCount',
        'clientCount',
        'contractorCount',
        'activities',
        'projects',
        'totalProjects',
        'activeProjects',
        'pendingProjects',
        'completedProjects'
    ));
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
