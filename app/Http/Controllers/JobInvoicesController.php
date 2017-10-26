<?php

namespace App\Http\Controllers;

use App\Job;
use App\Invoices;
use Illuminate\Http\Request;

class JobInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Job $job )
    {
        //
        $job->with('invoices')->get();

        return view('jobs.invoices.index', compact('job'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Int $job, Request $request )
    {
        //

        $invoice = Invoices::create( [
                'job_id' => $job,
            ]
        );

        $request->session()->flash('success', 'Successfully created new empty Invoice.');

        /*dd( 'redirecting to route ' .route('jobs.invoices.edit', [ $job, 1 ]), 'invoice->id=' . $invoice->id );*/

        return redirect( route('jobs.invoices.show', [ $job, $invoice->id ]) . "#jobInvoices" );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($job, Int $invoice)
    {
        //
        $invoice = Invoices::where('id', '=', $invoice)->
                        with( 
                            'job',
                            'materials',
                            'labour'
                        )->first();

        /*dump( $invoice );*/

        return view('jobs.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices $invoices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices $invoices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $job, Invoices $invoice, Request $request)
    {
        //
        $invoice->materials()->delete();
        $invoice->labour()->delete();
        $invoice->delete();

        $request->session()->flash('success', 'Successfully deleted invoice from Job ' . $invoice->job->number .'.');

        return redirect( route('jobs.show', $job) . "#jobInvoices" );
    }

    public function send( Int $job, Invoices $invoice, Request $request )
    {
        //dump( 'Send function' );

        $invoice->sent = 1;

        $invoice->save();

        $request->session()->flash('success', 'Successfully sent invoice for Job ' . $invoice->job->number . '.');

        return redirect( route('jobs.show', $job) . "#jobInvoices" );
    }

    public function togglePay( Int $job, Invoices $invoice, Request $request )
    {
        //dump( 'Toggle Pay' );
        $invoice->togglePaid()->save();

        $request->session()->flash('success', 'Successfully changed paid status for Job ' . $invoice->job->number . ' invoice.');
        return redirect( route('jobs.show', $job) . "#jobInvoices" );
    }

    public function toggleSend( Int $job, Invoices $invoice, Request $request )
    {
        $invoice->toggleSent()->save();

        $request->session()->flash('success', 'Successfully changed sent status for Job ' . $invoice->job->number . ' invoice.');
        return redirect( route('jobs.show', $invoice->job->id) . "#jobInvoices" );
    }

    public function print( Int $job, Invoices $invoice, Request $request )
    {
        return view('jobs.invoices.printout', compact('invoice', 'request'));
    }
}
