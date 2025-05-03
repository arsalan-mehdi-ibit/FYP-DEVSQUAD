<?php

namespace App\Jobs;

use App\Mail\EmailSender;
use App\Models\Timesheet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTimesheetReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timesheet;

    /**
     * Create a new job instance.
     */
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $contractor = $this->timesheet->contractor;

        if ($contractor && $contractor->email) {
            $emailData = [
                'contractor' => $contractor,
                'week_start' => optional($this->timesheet->week_start_date)->format('F j, Y'),
                'week_end' => optional($this->timesheet->week_end_date)->format('F j, Y'),
                'timesheet' => $this->timesheet,
                'project_name'    => $this->timesheet->project->name ?? 'N/A',
            ];

            Mail::to($contractor->email)->send(new EmailSender(
                subject: 'Reminder: Submit Your Timesheet',
                data: $emailData,
                bladeTemplate: 'emails.timesheet_submission_reminder'
            ));
        }
    }

}
