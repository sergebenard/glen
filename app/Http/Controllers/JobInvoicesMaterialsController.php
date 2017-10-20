<?php

namespace App\Http\Controllers;

use App\Job;
use App\Invoices;
use App\Materials;
use Illuminate\Http\Request;

class JobInvoicesMaterialsController extends Controller
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
    public function create( Job $job, Invoices $invoice )
    {
        //
        return view('jobs.invoices.materials.create', compact('job', 'invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Job $job, Invoices $invoice, Request $request)
    {
        //
        $request->validate([
            'count' => 'required|min:0.1',
            'name' => 'required|min:2|max:100',
            'description' => 'nullable|min:2',
            'cost' => 'nullable|numeric|between:0.01,10000',
        ]);

        $material = new Materials;

        $material->count = $request->count;
        $material->name = $request->name;
        $material->description = $request->description;
        $material->cost = $request->cost;
        $material->materialable_id = $invoice->id;
        $material->materialable_type = 'App\Invoices';

        $material->save();

        $request->session()->flash('success', "Successfully created new material on invoice." );
        /*dd( "Invoice ID: " . $invoice->id, "Route: " . route('jobs.invoices.show', [$job->id, $invoice->id]) );*/
        return redirect( route('jobs.invoices.show', [$job->id, $invoice->id]) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function show(Materials $materials)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job, Invoices $invoice, Materials $material)
    {
        //
        return view('jobs.invoices.materials.edit', compact('job', 'invoice', 'material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function update(Job $job, Invoices $invoice, Request $request, Materials $materials)
    {
        //
        //
        $request->validate([
            'count' => 'required|min:0.1',
            'name' => 'required|min:2|max:100',
            'description' => 'nullable|min:2',
            'cost' => 'nullable|numeric|between:0.01,10000',
        ]);

        $material->count = $request->count;
        $material->name = $request->name;
        $material->description = $request->description;
        $material->cost = $request->cost;

        $material->save();

        $request->session()->flash('success', "Successfully updated material on invoice." );

        dd( 'Route: ' . route('jobs.invoices.show', [$job->id, $invoice->id]) );

        return redirect( route('jobs.invoices.show', [$job->id, $invoice->id]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job, Invoices $invoice, Materials $material, Request $request)
    {
        //
        $material->delete();

        $request->session()->flash('success', "Successfully deleted material from invoice.");

        return redirect( route('jobs.invoices.show', [$job->id, $invoice->id]) );
    }
}
