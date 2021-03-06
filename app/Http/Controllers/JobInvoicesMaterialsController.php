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
    public function create( Int $job, Invoices $invoice )
    {
        //
        return view('jobs.invoices.materials.create', compact('invoice'));
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
            'name' => 'required|min:2|max:100',
            'description' => 'nullable|min:2',
            'cost' => 'nullable|numeric|between:0.01,10000',
        ]);

        $material = new Materials;

        $material->count = $request->count;
        $material->name = $request->name;
        $material->description = $request->description;
        $material->cost = $request->cost;
        $material->materialable_id = $invoice;
        $material->materialable_type = 'App\Invoices';
        $material->subtotal = null;

        $material->save();

        $request->session()->flash('success', "Successfully created new material on invoice." );
        /*dd( "Invoice ID: " . $invoice->id, "Route: " . route('jobs.invoices.show', [$job->id, $invoice->id]) );*/
        return redirect( route('jobs.invoices.show', [$job, $invoice]) );
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
    public function edit(Int $job, Int $invoice, Materials $material)
    {
        //
        return view('jobs.invoices.materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function update(Int $job, Int $invoice, Request $request, Materials $material)
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
        $material->subtotal = null;
        /*if ( $request->cost > 0 )
        {
            $material->subtotal = round( $request->count * $request->cost, 2 );
        }*/

        $material->save();

        $request->session()->flash('success', "Successfully updated material on invoice." );

        //dd( 'Route: ' . route('jobs.invoices.show', [$job->id, $invoice->id]) );

        return redirect( route('jobs.invoices.show', [$job, $invoice]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $job, Int $invoice, Materials $material, Request $request)
    {
        //
        $material->delete();

        $request->session()->flash('success', "Successfully deleted material from invoice.");

        return redirect( route('jobs.invoices.show', [$job, $invoice]) );
    }
}
