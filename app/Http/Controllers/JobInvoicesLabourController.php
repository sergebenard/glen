<?php

namespace App\Http\Controllers;

use App\Job;
use App\Labour;
use App\Invoices;
use Illuminate\Http\Request;

class JobInvoicesLabourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Int $job, Invoices $invoice )
    {
        //
        return view('jobs.invoices.labour.create', compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Int $job, Int $invoice, Request $request)
    {
        //
        $request->validate([
            'count' => 'required|min:0.1',
            'description' => 'required|min:2|max:100',
            'wage' => 'nullable|numeric|between:0.01,10000',
        ]);

        $labour = new Labour;

        $labour->count = $request->count;
        $labour->description = $request->description;
        $labour->wage = $request->wage;
        $labour->labourable_id = $invoice;
        $labour->labourable_type = 'App\Invoices';
        $labour->subtotal = null;

        $labour->save();

        $request->session()->flash('success', "Successfully created new labour entry on invoice." );

        return redirect( route('jobs.invoices.show', [$job, $invoice]) . '#invoices' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Labour  $labour
     * @return \Illuminate\Http\Response
     */
    public function show(Labour $labour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Labour  $labour
     * @return \Illuminate\Http\Response
     */
    public function edit(Int $job, Int $invoice, Labour $labour)
    {
        //
        return view('jobs.invoices.labour.edit', compact( 'labour' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Labour  $labour
     * @return \Illuminate\Http\Response
     */
    public function update(Int $job, Int $invoice, Request $request, Labour $labour)
    {
        //
        $request->validate([
            'count' => 'required|min:0.1',
            'description' => 'required|min:2|max:100',
            'wage' => 'nullable|numeric|between:0.01,10000',
        ]);

        $labour->count = $request->count;
        $labour->description = $request->description;
        $labour->wage = $request->wage;
        $labour->subtotal = null;

        $labour->save();

        $request->session()->flash('success', "Successfully updated labour entry on invoice." );

        return redirect( route('jobs.invoices.show', [$job, $invoice]) . '#invoices' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Labour  $labour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $job, Int $invoice, Labour $labour, Request $request)
    {
        //
        $labour->delete();

        $request->session()->flash('success', "Successfully deleted labour entry on invoice." );

        return redirect( route('jobs.invoices.show', [$job, $invoice]) . '#invoices' );
    }
}
