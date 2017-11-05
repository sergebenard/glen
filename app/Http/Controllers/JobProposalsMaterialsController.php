<?php

namespace App\Http\Controllers;

use App\Job;
use App\Materials;
use App\Proposals;
use Illuminate\Http\Request;

class JobProposalsMaterialsController extends Controller
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
    public function create( Job $job, Proposals $proposal )
    {
        //
        return view('jobs.proposals.materials.create',
                    compact('job', 'proposal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Job $job, Proposals $proposal, Request $request )
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
        $material->materialable_id = $proposal->id;
        $material->materialable_type = 'App\Proposals';
        $material->subtotal = null;

        $material->save();

        $request->session()->flash('success', "Successfully created new material on proposal." );
        /*dd( "proposal ID: " . $proposal->id, "Route: " . route('jobs.proposals.show', [$job->id, $proposal->id]) );*/
        return redirect( route('jobs.proposals.show', [$job->id, $proposal->id]) . '#proposals' );
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
    public function edit(Job $job, Proposals $proposal, Materials $material)
    {
        //
        return view('jobs.proposals.materials.edit', compact('job', 'proposal', 'material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function update(Job $job, Proposals $proposal, Request $request, Materials $material)
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

        $request->session()->flash('success', "Successfully updated material on proposal." );

        //dd( 'Route: ' . route('jobs.proposals.show', [$job->id, $proposal->id]) );

        return redirect( route('jobs.proposals.show', [$job->id, $proposal->id]) . '#proposals' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job, Proposals $proposal, Materials $material, Request $request)
    {
        //
        //
        $material->delete();

        $request->session()->flash('success', "Successfully deleted material from proposal.");

        return redirect( route('jobs.proposals.show', [$job->id, $proposal->id]) . '#proposals' );
    }
}
