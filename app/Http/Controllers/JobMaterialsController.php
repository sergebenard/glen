<?php

namespace App\Http\Controllers;

use App\Job;
use App\Materials;
use Illuminate\Http\Request;

class JobMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Job $job )
    {
        //
        $job->with('materials')->get();

        return view( 'jobs.materials.index', compact('job'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Job $job )
    {
        //
        return view('jobs.materials.create', compact('job'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Job $job, Request $request)
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
        $material->materialable_id = $job->id;
        $material->materialable_type = 'App\Job';

        $material->save();

        $request->session()->flash('success', "Successfully created new material consumed on Job" . $job->number . "." );

        return redirect( route('jobs.show', $job->id) );
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
    public function edit(Job $job, Materials $material)
    {
        //
        return view('jobs.materials.edit', compact('job', 'material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function update(Job $job, Request $request, Materials $material)
    {
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

        $request->session()->flash('success', "Successfully updated material consumed on Job" . $job->number . "." );

        return redirect( route('jobs.show', $job->id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materials  $materials
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materials $materials)
    {
        //
    }
}
