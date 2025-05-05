<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Timesheet;
use App\Jobs\SendSubmittedTimesheetReminder;

class emailremindersforsubmittedtimesheets extends Command
{
    protected $signature = 'app:emailremindersforsubmittedtimesheets'; // Command name

    protected $description = 'Send email reminders for submitted timesheets';

    public function handle()
    {
       
        // Fetch all submitted timesheets
        $timesheets = Timesheet::with('project')->where('status', 'submitted')->get();

        if ($timesheets->isEmpty()) {
            $this->info('No submitted timesheets found.');
           
            return;
        }
       
        // Dispatch the job for each timesheet
        foreach ($timesheets as $timesheet) {
           
            if ($timesheet->project->client->id  && $timesheet->project->client->email) {
                \Log::info("whatever");
                SendSubmittedTimesheetReminder::dispatch($timesheet);
                $this->info('Job dispatched for timesheet ID: ' . $timesheet->id);
            } else {
                $this->warn('Client/email missing for timesheet ID: ' . $timesheet->id);
            }
        }

        $this->info('All jobs dispatched.');
    }
}
