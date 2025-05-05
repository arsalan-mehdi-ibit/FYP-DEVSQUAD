<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Timesheet;
use App\Jobs\SendTimesheetReminderJob;

class SendPendingTimesheetReminders extends Command
{
    protected $signature = 'app:emailremindersforpendingtimesheets';

    protected $description = 'Send reminder emails for pending timesheets ';

    public function handle()
    {

        $today = now()->startOfDay();

        $pendingTimesheets = Timesheet::with('contractor')
            ->where('status', 'pending')
            ->whereDate('week_end_date', '<', $today)
            ->get();

        $this->info('📝 Found ' . $pendingTimesheets->count() . ' pending timesheets.');

        foreach ($pendingTimesheets as $timesheet) {
            dispatch(new SendTimesheetReminderJob($timesheet));
        }

        $this->info('✅ Dispatched reminder jobs for pending timesheets.');
    }

}
