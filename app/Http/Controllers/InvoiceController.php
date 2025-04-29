<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payments;
use Illuminate\Support\Carbon;
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

        if (is_null($payment->payment_date)) {
            $payment->update([
                'payment_date' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Invoice marked as paid successfully.');
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
