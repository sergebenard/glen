<?php

namespace App\Http\Controllers;

use App\Job;
use App\Labour;
use Illuminate\Http\Request;

class JobLabourController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Job $job )
	{
		//

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( Job $job )
	{
		//
		return view('jobs.labour.create', compact('job'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( Job $job, Request $request )
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
		$labour->labourable_id = $job->id;
		$labour->labourable_type = 'App\Job';
		$labour->subtotal = null;

		$labour->save();

		$request->session()->flash('success', "Successfully created new labour entry for Job " . $job->number . "." );

		return redirect( route('jobs.show', $job->id) . "#jobActual" );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Labour  $labour
	 * @return \Illuminate\Http\Response
	 */
	public function show( Job $job,  Labour $labour )
	{
		//
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Labour  $labour
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Job $job, Labour $labour )
	{
		//
		return view('jobs.labour.edit', compact( 'job', 'labour' ));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Labour  $labour
	 * @return \Illuminate\Http\Response
	 */
	public function update( Job $job, Request $request, Labour $labour )
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

		$request->session()->flash('success', "Successfully updated entry for Job " . $job->number . "." );

		return redirect( route('jobs.show', $job->id) . "#jobActual" );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Labour  $labour
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Job $job, Labour $labour, Request $request )
	{
		//
		$labour->delete();

		$request->session()->flash('success', "Successfully deleted labour entry for Job " . $job->number . "." );

		return redirect( route('jobs.show', $job->id) . "#jobActual" );
	}
}
