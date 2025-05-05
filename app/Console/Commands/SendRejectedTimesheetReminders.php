<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Timesheet;
use App\Jobs\ResendTimesheetReminderJob;

class SendRejectedTimesheetReminders extends Command
{
    protected $signature = 'app:emailremindersforrejectedtimesheets';

    protected $description = 'Send reminder emails for rejected timesheets';

    public function handle()
    {

        $today = now()->startOfDay();

        $rejectedTimesheets = Timesheet::with('contractor')
            ->where('status', 'rejected')
            ->whereDate('week_end_date', '<', $today)
            ->get();

        $this->info('📝 Found ' . $rejectedTimesheets->count() . ' rejected timesheets.');

        foreach ($rejectedTimesheets as $timesheet) {
            dispatch(new ResendTimesheetReminderJob($timesheet));
        }

        $this->info('✅ Dispatched reminder jobs for rejected timesheets.');
    }

}
