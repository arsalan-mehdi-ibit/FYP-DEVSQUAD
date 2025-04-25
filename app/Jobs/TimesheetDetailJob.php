<?php

namespace App\Jobs;

use App\Models\TimesheetDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TimesheetDetailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $timesheet_id;
    protected $date;

    public function __construct($timesheet_id, $date)
    {
        $this->timesheet_id = $timesheet_id;
        $this->date = $date;
    }

    public function handle(): void
    {
        TimesheetDetail::create([
            'timesheet_id' => $this->timesheet_id,
            'actual_hours' => null,
            'ot_hours'     => null,
            'date'         => Carbon::parse($this->date)->toDateString(),
            'memo'         => null,
        ]);

        \Log::info("✅ Created timesheet detail for {$this->date} (Timesheet ID: {$this->timesheet_id})");
    }
}
