<?php

namespace App\Http\Controllers;

use App\Scopes;
use App\Proposals;
use Illuminate\Http\Request;

class JobProposalsScopesController extends Controller
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
	public function create( Int $job, Proposals $proposal )
	{
		//
		return view('jobs.proposals.scopes.create', compact('proposal'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Int $job, Int $proposal, Request $request)
	{
		//
		$request->validate([
			'description' => 'required|min:10',
		]);

		$requestDescription = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $request->description);

		$scopes = explode("\n", $requestDescription);

		if ( count( $scopes) )
		{
			for( $i=0; $i <= count( $scopes ) -1; $i++ )
			{
				$scope = new Scopes;
				$scope->description = $scopes[$i];
				$scope->proposals_id = $proposal;
				$scope->save();
			}

			$request->session()->flash('success', 'Successfully added ' . count( $scopes ) . ' new scope of work items.' );
		}
		else
		{
			$scope = new Scopes;
			$scope->description = $request->description;
			$scope->proposals_id = $proposal;
			$scope->save();

			$request->session()->flash('success', 'Successfully added new scope of work item.');
		}

		return redirect( route('jobs.proposals.show', [$job, $proposal]) );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Scopes  $scopes
	 * @return \Illuminate\Http\Response
	 */
	public function show(Scopes $scopes)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Scopes  $scopes
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Int $job, Proposals $proposal, Scopes $scope)
	{
		//
		return view('jobs.proposals.scopes.edit', compact('proposal','scope'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Scopes  $scopes
	 * @return \Illuminate\Http\Response
	 */
	public function update(Int $job, Int $proposal, Request $request, Scopes $scope)
	{
		//
		$request->validate([
			'description' => 'required|min:10',
		]);

		$scope->description = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $request->description);

		$scope->save();

		$request->session()->flash('success', 'Successfully updated scope of work item.');

		return redirect( route('jobs.proposals.show', [$job, $proposal]) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Scopes  $scopes
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Int $job, Int $proposal, Scopes $scope, Request $request)
	{
		//
		$scope->delete();

		$request->session()->flash('success', 'Successfully deleted proposal scope of work item.');

		return redirect( route('jobs.proposals.show', [$job, $proposal]) );
	}
}
