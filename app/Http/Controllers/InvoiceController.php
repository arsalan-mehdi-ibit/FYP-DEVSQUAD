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
    public function index()
    {
        $pageTitle = "Invoice List";
    
        $invoices = Payments::with(['client.profilePicture', 'contractor', 'timesheet'])
            ->orderBy('created_at', 'desc') // Most recent invoices on top
            ->paginate(10); // Pagination: 10 invoices per page
    
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
