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
    public function create( Int $job, Request $request )
    {
        //
        $proposal = Proposals::create( [
                'job_id' => $job,
            ]
        );

        $request->session()->flash('success', 'Successfully created new empty Proposal.');

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
    public function show(Int $job, Int $proposal)
    {
        //
        $proposal = Proposals::where('id', '=', $proposal)->
                    with( 
                        'job',
                        'materials',
                        'labour' )->first();

        /*dump( $proposal );*/

        return view('jobs.proposals.show', compact('proposal'));
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
    public function destroy(Int $job, Proposals $proposal, Request $request)
    {
        //
        $proposal->materials()->delete();
        $proposal->labour()->delete();
        $proposal->delete();

        $request->session()->flash('success', 'Successfully deleted proposal from Job ' . $proposal->job->number .'.');

        return redirect( route('jobs.show', $job) . "#jobProposals" );
    }

    public function send( Int $job, Proposals $proposal, Request $request )
    {
        //dump( 'Send function' );

        $proposal->sent = 1;

        $proposal->save();

        $request->session()->flash('success', 'Successfully sent proposal for Job ' . $proposal->job->number . '.');

        return redirect( route('jobs.show', $job) . "#jobProposals" );
    }

    public function toggleSend( Int $job, Proposals $proposal, Request $request )
    {
        $proposal->toggleSent()->save();

        $request->session()->flash('success', 'Successfully changed sent status for Job ' . $proposal->job->number . ' proposal.');
        return redirect( route('jobs.show', $proposal->job->id) . "#jobProposals" );
    }

    public function changeStatus( Int $job, Proposals $proposal, String $status, Request $request )
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

            return redirect( route( 'jobs.show', $proposal->job->id ) );
        }
    }

    public function print( Int $job, Proposals $proposal, Request $request )
    {
        return view('jobs.proposals.printout', compact('job', 'proposal'));
    }
}
