<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RecentActivity;
use Illuminate\Support\Facades\Auth;
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

    $pageTitle = "Dashboard";
    // Fetch recent activities using RecentActivity model
    $activities = RecentActivity::with('creator') 
    ->where('user_id', Auth::id())  // Filtering by user_id
    ->latest()
    ->take(10)
    ->get();
    // Pass the counts to the view
    return view('dashboard', compact('pageTitle', 'adminCount', 'consultantCount', 'clientCount', 'contractorCount', 'activities'));
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
