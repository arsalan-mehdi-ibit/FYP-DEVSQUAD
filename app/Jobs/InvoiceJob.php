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
        $this->timesheet->loadMissing(['details', 'contractor', 'project.contractors', 'project.client' ]);

        $totalHours = $this->timesheet->details->sum('actual_hours');
        $client_rate = $this->timesheet->project->client_rate;
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
            'client_rate' => $client_rate,
        ]);

        // Avoid creating zero-value invoices
        if ($totalHours <= 0 || $pivotRate <= 0) {
            \Log::warning('🚫 Invoice not created due to 0 hours or 0 rate.', [
                'timesheet_id' => $this->timesheet->id,
            ]);
            return;
        }

         // 🔒 Check if payment already exists for this timesheet
        $alreadyExists = Payments::where('timesheet_id', $this->timesheet->id)->exists();

        if ($alreadyExists) {
            \Log::info('⚠️ Invoice already exists for timesheet ID: ' . $this->timesheet->id);
            return;
        }

        // Create payment
        Payments::create([
            'timesheet_id' => $this->timesheet->id,
            'contractor_id' => $this->timesheet->contractor_id,
            'client_id' => $this->timesheet->project->client_id ?? null,
            'contractor_paid' => $totalHours * $pivotRate,
            'admin_received' => $totalHours * $client_rate, // Adjust if admin fee logic changes
        ]);

        \Log::info('✅ Invoice created for timesheet ID: ' . $this->timesheet->id);
    }
}





