<?php

namespace App\Jobs;

use App\Models\Payments;
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
        // Ensure relationships are loaded
        $this->timesheet->loadMissing(['details', 'contractor', 'project.contractors', 'project.client']);

        $totalHours = $this->timesheet->details->sum('actual_hours');

        // Get rate from pivot table
        $pivotRate = $this->timesheet->project
            ->contractors()
            ->where('contractor_id', $this->timesheet->contractor_id)
            ->first()?->pivot->contractor_rate ?? 0;

        \Log::info('🧾 InvoiceJob Triggered', [
            'timesheet_id' => $this->timesheet->id,
            'details_count' => $this->timesheet->details->count(),
            'total_hours' => $totalHours,
            'contractor_rate' => $pivotRate,
        ]);

        // Avoid creating zero-value invoices
        if ($totalHours <= 0 || $pivotRate <= 0) {
            \Log::warning('🚫 Invoice not created due to 0 hours or 0 rate.', [
                'timesheet_id' => $this->timesheet->id,
            ]);
            return;
        }

        // Create payment
        Payments::create([
            'timesheet_id' => $this->timesheet->id,
            'contractor_id' => $this->timesheet->contractor_id,
            'client_id' => $this->timesheet->project->client_id ?? null,
            'contractor_paid' => $totalHours * $pivotRate,
            'admin_received' => $totalHours * $pivotRate, // Adjust if admin fee logic changes
        ]);

        \Log::info('✅ Invoice created for timesheet ID: ' . $this->timesheet->id);
    }
}





// namespace App\Jobs;

// use App\Models\Payment;
// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Foundation\Bus\Dispatchable;

// class InvoiceJob implements ShouldQueue
// {
//     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//     protected $timesheet;

//     public function __construct($timesheet)
//     {
//         $this->timesheet = $timesheet;
//     }
//     public function handle()
//     {
//         $this->timesheet->loadMissing(['details', 'contractor', 'project.client']);

//         $totalHours = $this->timesheet->details->sum('actual_hours');
//         $rate = $this->timesheet->contractor->rate ?? 0;

//         Payment::create([
//             'timesheet_id' => $this->timesheet->id,
//             'contractor_id' => $this->timesheet->contractor_id,
//             'client_id' => $this->timesheet->project->client_id ?? null,
//             'contractor_paid' => $totalHours * $rate,
//             'admin_received' => $totalHours * $rate, // You can modify this logic
//         ]);
//     }


// }


// public function handle()
// {
//     $contractor = $this->timesheet->contractor;
//     $project = $this->timesheet->project;

//     $totalHours = $this->timesheet->total_hours; // ✅ fixed
//     $contractorRate = $contractor->rate;
//     $billingAmount = $totalHours * $contractorRate;

//     Payment::create([
//         'timesheet_id' => $this->timesheet->id,
//         'client_id' => $project->client_id,
//         'contractor_id' => $contractor->id,
//         'admin_received' => $billingAmount,
//         'contractor_paid' => $billingAmount,
//         'payment_date' => null,
//     ]);
// }