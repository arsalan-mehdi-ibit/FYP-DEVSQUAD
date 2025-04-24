<?php

namespace App\Jobs;

use App\Models\Timesheet;
use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FillTimesheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Project $project;
    protected $contractors; // This will be a collection of User models

    /**
     * Create a new job instance.
     */
    public function __construct(Project $project, $contractors)
    {
        $this->project = $project;
        $this->contractors = $contractors;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Handling FillTimesheet job for project ID: ' . $this->project->id);

        // Check if the project status is 'in_progress'
        if (strtolower($this->project->status) !== 'in_progress') {
            \Log::info('Project status is not in progress, skipping job.');
            return;
        }

        $weekStart = $this->project->start_date;
        $weekEnd = $this->project->end_date;

        // Ensure contractors are present
        if ($this->contractors->isEmpty()) {
            \Log::info('No contractors found for project ID: ' . $this->project->id);
            return;
        }

        // Iterate through each contractor and create timesheets if necessary
        foreach ($this->contractors as $contractor) {
            \Log::info('Processing contractor: ' . $contractor->name);

            // Check if the timesheet already exists for this contractor and project for the current week
            $exists = Timesheet::where('project_id', $this->project->id)
                ->where('contractor_id', $contractor->id)
                ->where('week_start_date', $weekStart)
                ->where('week_end_date', $weekEnd)
                ->exists();

            \Log::info('Timesheet exists: ' . ($exists ? 'Yes' : 'No'));

            if (!$exists) {
                // Get the contractor's rate from the project
                $rate = $this->project->contractors()
                    ->where('contractor_id', $contractor->id)
                    ->first()?->pivot->contractor_rate ?? 0;

                // Log the contractor rate
                \Log::info('Contractor rate: ' . $rate);

                // Create the new timesheet
                $timesheet = Timesheet::create([
                    'project_id'      => $this->project->id,
                    'contractor_id'   => $contractor->id,
                    'week_start_date' => $weekStart,
                    'week_end_date'   => $weekEnd,
                    'status'          => 'not_started',
                    'total_hours'     => 0,
                    'total_amount'    => $rate,
                ]);

                // Log timesheet creation
                \Log::info('Created timesheet for contractor: ' . $contractor->name . ' with ID: ' . $timesheet->id);
            }
        }
    }
}
