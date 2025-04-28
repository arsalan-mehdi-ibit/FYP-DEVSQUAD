<?php

namespace App\Jobs;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class InvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $timesheet;

    public function __construct($timesheet)
    {
        $this->timesheet = $timesheet;
    }

    public function handle()
    {
        $contractor = $this->timesheet->contractor;
        $project = $this->timesheet->project;

        $totalHours = $this->timesheet->total_hours; // assuming field exists
        $contractorRate = $contractor->rate; // assuming field exists
        $billingAmount = $totalHours * $contractorRate;

        Payment::create([
            'timesheet_id'    => $this->timesheet->id,
            'client_id'       => $project->client_id,
            'contractor_id'   => $contractor->id,
            'admin_received'  => $billingAmount,
            'contractor_paid' => $billingAmount,
            'payment_date'    => null, // make sure it's NULL initially
        ]);
    }
}
