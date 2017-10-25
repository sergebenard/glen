<?php

namespace App\Http\Controllers;

use App\Job;
use App\Proposals;
use Illuminate\Http\Request;

class JobProposalsController extends Controller
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
    public function create( Job $job, Request $request )
    {
        //
        //

        $proposal = Proposals::create( [
                'job_id' => $job->id,
            ]
        );

        $request->session()->flash('success', 'Successfully created new empty Invoice.');

        /*dd( 'redirecting to route ' .route('jobs.invoices.edit', [ $job, 1 ]), 'invoice->id=' . $invoice->id );*/

        return redirect( route('jobs.proposals.show', [ $job, $proposal->id ]) . "#jobProposals" );
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
     * @param  \App\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job, Proposals $proposal)
    {
        //
        $proposal->with( 'materials', 'labour' );

        /*dump( $proposal );*/

        return view('jobs.proposals.show', compact('job', 'proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposals $proposals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposals $proposals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job, Proposals $proposals, Request $request)
    {
        //
        $proposal->materials()->delete();
        $proposal->labour()->delete();
        $proposal->delete();

        $request->session()->flash('success', 'Successfully deleted proposal from Job ' . $job->number .'.');

        return redirect( route('jobs.show', $job->id) . "#jobProposals" );
    }

    public function send( Job $job, Proposals $proposal, Request $request )
    {
        //dump( 'Send function' );

        $proposal->sent = 1;

        $proposal->save();

        $request->session()->flash('success', 'Successfully sent invoice for Job ' . $job->number . '.');

        return redirect( route('jobs.show', $job->id) . "#jobProposals" );
    }

    public function toggleSend( Job $job, Proposals $proposal, Request $request )
    {
        $proposal->toggleSent()->save();

        $request->session()->flash('success', 'Successfully changed sent status for Job ' . $job->number . ' proposal.');
        return redirect( route('jobs.show', $job->id) . "#jobProposals" );
    }

    public function changeStatus( Job $job, Proposals $proposal, String $status, Request $request )
    {
        $allowed = [
            'approved',
            'refused',
            'undecided',
        ];

        if( in_array( $status , $allowed) )
        {
            $proposal->status = $status;

            $proposal->save();

            $request->session()->flash('success', 'Successfully changed proposal status to ' . $status .'.');

            return redirect( route( 'jobs.show', $job->id ) );
        }
    }

    public function print( Job $job, Proposals $proposal, Request $request )
    {
        return view('jobs.proposals.printout', compact('job', 'proposal'));
    }
}
