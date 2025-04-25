<?php

namespace App\Jobs;

use App\Models\Timesheet;
use App\Models\Project;
use App\Models\User;
use App\Jobs\TimesheetDetailJob;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class FillTimesheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Project $project;
    protected $contractors;

    public function __construct(Project $project, $contractors)
    {
        $this->project = $project;
        $this->contractors = $contractors;
    }

    public function handle(): void
    {
        \Log::info('🟢 Handling FillTimesheet job for project ID: ' . $this->project->id);

        if (strtolower($this->project->status) !== 'in_progress') {
            \Log::info('⛔ Project status is not in progress, skipping job.');
            return;
        }

        if ($this->contractors->isEmpty()) {
            \Log::info('⚠️ No contractors found for project ID: ' . $this->project->id);
            return;
        }

        $startDate = Carbon::parse($this->project->start_date);
        $endDate = Carbon::parse($this->project->end_date);
        $currentStart = $startDate->copy();

        while ($currentStart->lte($endDate)) {
            $currentEnd = $currentStart->copy()->addDays(6);
            if ($currentEnd->gt($endDate)) {
                $currentEnd = $endDate->copy();
            }

            foreach ($this->contractors as $contractor) {
                $exists = Timesheet::where('project_id', $this->project->id)
                    ->where('contractor_id', $contractor->id)
                    ->where('week_start_date', $currentStart->toDateString())
                    ->where('week_end_date', $currentEnd->toDateString())
                    ->exists();

                if (!$exists) {
                    $rate = $this->project->contractors()
                        ->where('contractor_id', $contractor->id)
                        ->first()?->pivot->contractor_rate ?? 0;

                        

                    $timesheet = Timesheet::create([
                        'project_id'     => $this->project->id,
                        'contractor_id'  => $contractor->id,
                        'week_start_date'=> $currentStart->toDateString(),
                        'week_end_date'  => $currentEnd->toDateString(),
                        'status'         => $this->project->status,
                        'total_hours'    => 0,
                        // 'total_ot_hours'    => 0,
                        'total_amount'   => $rate,
                    ]);

                    $period = CarbonPeriod::create($currentStart, $currentEnd)->filter(function ($date) use ($startDate) {
                        return $date->gte($startDate) && $date->isWeekday();
                    });

                    foreach ($period as $date) {
                        TimesheetDetailJob::dispatch($timesheet->id, $date->toDateString());
                    }

                    \Log::info("✅ Created timesheet: {$currentStart->toDateString()} - {$currentEnd->toDateString()} for contractor ID: {$contractor->id}");
                }
            }

            $currentStart->addDays(7); // move to next weekly window
        }
    }
}
