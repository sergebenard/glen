<?php

namespace App\Http\Controllers;

use App\Job;
use App\Invoices;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

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

		return redirect( route('jobs.invoices.show', [ $job, $invoice->id ]) . "#invoices" );
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

		return redirect( route('jobs.show', $job) . "#invoices" );
	}

	public function send( Int $job, Int $invoice, Request $request, String $details )
	{
		//dump( 'Send function' );
		$request->session()->forget('details');

		$invoice = Invoices::where('id', $invoice)->
					with(	'job',
							'materials',
							'labour')->
					first();

		if( $details === 'detailed' ) {
			$request->session()->flash('details', '1');
		}

		$pdf = PDF::loadView('jobs.invoices.pdf', compact( 'invoice' ) );
		
		// return $pdf->stream();

		Mail::send('mail.invoice', compact('invoice'), function ($message) use ($invoice, $pdf) {
			//dd( $invoice );

			$message->from('serge.benard@gmail.com', 'Serge Benard');
			$message->sender('serge.benard@gmail.com', 'Serge Benard');
		
			$message->to( $invoice->job->email , ( !empty( $invoice->job->name ) ) ? $invoice->job->name : 'Householder');
		
			// $message->replyTo('serge.benard@gmail.com', 'Serge Benard');
		
			$message->subject('Project Invoice');

			$message->attachData( $pdf->stream(), 'invoice.pdf', [
					'mime' => 'application/pdf',
				] );

		});

		$invoice->sent = 1;

		$invoice->save();

		return Redirect::to(URL::previous() . "#invoices")->with('success', 'Successfully sent invoice for Job ' . $invoice->job->number . '.');

	}

	public function togglePay( Int $job, Invoices $invoice )
	{
		//dump( 'Toggle Pay' );
		$invoice->togglePaid()->save();

		return Redirect::to(URL::previous() . "#invoices")->with('success', 'Successfully changed paid status for Job ' . $invoice->job->number . ' invoice.');
	}

	public function toggleSend( Int $job, Invoices $invoice )
	{
		$invoice->toggleSent()->save();

		return Redirect::to(URL::previous() . "#invoices")->with('success', 'Successfully changed sent status for Job ' . $invoice->job->number . ' invoice.');
	}

	public function print( Int $job, Invoices $invoice, Request $request )
	{
		return view('jobs.invoices.printout', compact('invoice', 'request'));
	}
}
