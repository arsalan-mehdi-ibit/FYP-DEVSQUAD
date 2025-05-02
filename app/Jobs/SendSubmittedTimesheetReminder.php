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

class SendSubmittedTimesheetReminder implements ShouldQueue
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
        $emailData = [
            'client_name'     => $this->timesheet->project->client->name ?? 'Client',
            'project_name'    => $this->timesheet->project->name ?? 'N/A',
            'submitted_date'  => optional($this->timesheet->submitted_at)->format('F j, Y') ?? 'N/A',
            'status'          => ucfirst($this->timesheet->status),
        ];
    
        $recipient = $this->timesheet->project->client->email ?? 'default@example.com';
    
        Mail::to($recipient)->send(new EmailSender(
            "Timesheet Approval Reminder",
            $emailData,
            'emails.timesheet.reminder'
        ));
    }
    
}
