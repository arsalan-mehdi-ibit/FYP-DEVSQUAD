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
       
\Log::info("helooo");
Mail::to("haishamfaizan@gmail.com")->send(new EmailSender(
    "Timesheet Approval Reminder",
    $this->timesheet->toArray(),
    'emails.timesheet.reminder'
));
    }
}
