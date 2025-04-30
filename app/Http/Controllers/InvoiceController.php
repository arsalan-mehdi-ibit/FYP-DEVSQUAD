<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\User;
use App\Models\RecentActivity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSender;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageTitle = "Invoice List";
        // dd($request);

        $invoices = Payments::with(['client.profilePicture', 'contractor', 'timesheet.project' , 'timesheet']);

        // // Apply Filters
        // if ($request->timesheets) {
        //     $invoices->whereIn('timesheet_name', $request->timesheets);
        // }


    // Now Apply Filters if any (dates, projects, clients, contractors, statuses)
    if ($request->timesheets) {
        $invoices->whereHas('timesheet', function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                foreach ($request->timesheets as $timesheet) {
                    $range = explode(' - ', $timesheet);
                    if (count($range) == 2) {
                        $start = Carbon::parse(trim($range[0]))->format('Y-m-d');
                        $end = Carbon::parse(trim($range[1]))->format('Y-m-d');
    
                        $q->orWhere(function ($subQ) use ($start, $end) {
                            $subQ->whereDate('week_start_date', $start)
                                 ->whereDate('week_end_date', $end);
                        });
                    }
                }
            });
        });
    }




        if ($request->clients) {
            $invoices->whereIn('client_id', $request->clients);
        }

        if ($request->projects) {
            $invoices->whereHas('timesheet.project', function ($query) use ($request) {
                $query->whereIn('id', $request->projects);
            });
        }

        if ($request->statuses) {
            $invoices->where(function ($query) use ($request) {
                foreach ($request->statuses as $status) {
                    if ($status == 'paid') {
                        $query->orWhereNotNull('payment_date');
                    } elseif ($status == 'unpaid') {
                        $query->orWhereNull('payment_date');
                    }
                }
            });
        }

        $invoices = $invoices->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('invoice', compact('pageTitle', 'invoices'))->render(),
            ]);
        }

        return view('invoice', compact('pageTitle', 'invoices'));
    }



    public function markAsPaid($id)
    {
        $payment = Payments::findOrFail($id);
        
        $usersToNotify = collect([$payment->contractor, $payment->client])
        ->merge(User::where('role', 'admin')->get())
        ->filter(); // Removes null users like missing client
    
        foreach ($usersToNotify as $user) {
            $projectName = $payment->timesheet->project->name;
            $timesheetName = 'Timesheet of week ' . $payment->timesheet->week_start_date; 
            $amount = $payment->admin_received; // or contractor_paid based on context
            $adminName = Auth::user()->firstname .  ' ' . Auth::user()->lastname;
        
        $description = match ($user->role) {
            'contractor' => "Your invoice for {$timesheetName} for the project \"{$projectName}\" has been marked as paid by {$adminName}.",
            'client'     => "You have paid \${$amount} for {$timesheetName} for the project \"{$projectName}\".",
            'admin'      => "The invoice for {$timesheetName} has been marked as paid.",
            default      => "Invoice update for {$timesheetName}.",
            };

            RecentActivity::create([
                'title' => 'Invoice Paid',
                'description' => $description,
                'parent_id' => $payment->timesheet_id,
                'created_for' => 'invoice',
                'user_id' => $user->id,
                'created_by' => Auth::user()->id,
            ]);
            $emailData = [
                'user_name' => $user->name,
                'role' => $user->role,
                'project_name' => $projectName,
                'timesheet_name' => "Timesheet : {$timesheetName}",
                'contractor_paid' => $payment->contractor_paid,
                'admin_received' => $payment->admin_received,
                'admin_name' => $adminName,
                'contractor_name' =>$payment->contractor->firstname ,
                'client_name' =>$payment->client->firstname,
                'invoice_file_url' => route('invoice.download', ['id' => $payment->id]), 
            ];

            Mail::to("haishamfaizan@gmail.com")->send(new EmailSender(
                "INVOICE STATUS UPDATE",
                $emailData,
                'emails.invoice_payment'
            ));
        }

        if (is_null($payment->payment_date)) {
            $payment->update([
                'payment_date' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Invoice marked as paid successfully.');
    }

    public function download($id)
    {
        $payment = Payments::with(['timesheet.project', 'contractor', 'client'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', ['payment' => $payment]);
        
        $filename = 'Invoice_' . $payment->id . '.pdf';

        return $pdf->download($filename); // Forces download
        // return $pdf->stream($filename); // Shows in browser
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
