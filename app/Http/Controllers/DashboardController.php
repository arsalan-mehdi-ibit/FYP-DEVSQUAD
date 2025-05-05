<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RecentActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\TimesheetDetail;
use App\Models\Project;
use App\Models\ProjectContractor;
use Carbon\Carbon;


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
        $projects = collect(); 

        // Admin Overview
        if ($role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            $consultantCount = User::where('role', 'consultant')->count();
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
        $user = Auth::user();
        $role = strtolower($user->role);
        $projectId = $request->get('project_id');
        $year = now()->year;

        $timesheetQuery = TimesheetDetail::query()
            ->selectRaw('MONTH(date) as month, SUM(actual_hours) as total_hours')
            ->join('timesheets', 'timesheet_details.timesheet_id', '=', 'timesheets.id')
            ->where('status', 'approved')
            ->whereYear('date', $year)
            ->when($projectId && $projectId !== 'all', function ($q) use ($projectId) {
                $q->where('timesheets.project_id', $projectId);
            });

        // Apply project filtering ONLY if the user is NOT admin
        if ($role !== 'admin') {
            $timesheetQuery->whereHas('timesheet.project', function ($q) use ($user) {
                $q->where(function ($subQ) use ($user) {
                    $subQ->where('client_id', $user->id)
                        ->orWhere('consultant_id', $user->id)
                        ->orWhereHas('contractors', function ($contractorQ) use ($user) {
                            $contractorQ->where('contractor_id', $user->id);
                        });
                });
            });
        }

        $results = $timesheetQuery->groupBy('month')->pluck('total_hours', 'month');

        // Fill in missing months
        $data = collect(range(1, 12))->map(function ($month) use ($results) {
            return $results->get($month, 0);
        });

        return response()->json(['data' => $data]);
    }

    public function filterActivities(Request $request)
    {
        $filter = $request->get('filter');
        $userId = Auth::id();
        $query = RecentActivity::with('creator')->where('user_id', $userId);

        $now = now()->setTimezone(config('app.timezone', 'UTC'));

        if ($filter === 'daily') {
            $query->whereBetween('created_at', [
                $now->copy()->startOfDay()->timezone('UTC'),
                $now->copy()->endOfDay()->timezone('UTC'),
            ]);
        } elseif ($filter === 'weekly') {
            $query->whereBetween('created_at', [
                $now->copy()->startOfWeek()->startOfDay()->timezone('UTC'),
                $now->copy()->endOfWeek()->endOfDay()->timezone('UTC'),
            ]);
        } elseif ($filter === 'monthly') {
            $query->whereBetween('created_at', [
                $now->copy()->startOfMonth()->startOfDay()->timezone('UTC'),
                $now->copy()->endOfMonth()->endOfDay()->timezone('UTC'),
            ]);
        }

        $activities = $query->latest()->take(10)->get();

        $html = '';
        if ($activities->isEmpty()) {
            $html .= '<div class="p-2 text-gray-500 text-sm text-center">No recent activity found.</div>';
        } else {
            foreach ($activities as $activity) {
                $html .= '
                <div class="p-2 bg-gray-50 rounded-md">
                    <div class="flex justify-between items-center text-xs text-gray-500 px-2">
                        <span class="font-semibold uppercase bg-gray-300 text-white px-3 py-1 rounded-xl">'
                    . strtoupper($activity->created_for ?? 'ACTIVITY') .
                    '</span>
                        <span>' . \Carbon\Carbon::parse($activity->created_at)->format('F d, Y') . '</span>
                    </div>
                    <p class="text-sm font-semibold text-gray-800 px-2 mt-2 mb-2">'
                    . ($activity->title ?? 'Activity Performed') .
                    '</p>
                    <p class="text-sm text-gray-800 px-2">' . $activity->description . '</p>
                    <p class="text-xs text-black font-semibold mt-2 px-2">Creator:
                        <span class="font-normal text-gray-500">'
                    . trim("{$activity->creator->firstname} {$activity->creator->lastname}") .
                    '</span>
                    </p>
                </div>';
            }
        }

        return response()->json(['html' => $html]);
    }

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
