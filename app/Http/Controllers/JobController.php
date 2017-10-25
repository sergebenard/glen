<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
		$jobs = Job::orderBy('created_at', 'DESC')->with('materials', 'labour')->get();

		return view('jobs.index', compact('jobs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
		return view('jobs.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			'name' => 'nullable|min:2|max:50',
			'email' => 'nullable|email',
			'address' => 'required|min:2',
			'phone' => 'nullable|min:10|max:15',
			'note' =>	'nullable|min:2',
		]);
		//
		$job =Job::create(
			[
				'number' => $this->createJobNumber(),
				'name' => $request->name,
				'address' => $request->address,
				'phone' => $request->phone,
				'extension' => $request->extension,
				'email' => $request->email,
				'note' => $request->note,
			]
		);

		$request->session()->flash('success', 'Successfully created new Job.');

		return redirect( route( 'jobs.show', $job->id ) );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Job  $job
	 * @return \Illuminate\Http\Response
	 */
	public function show(Job $job)
	{
		//
		$job->with(	'materials',
					'labour',
					'invoices.materials',
					'invoices.labour');

		return view('jobs.show', compact('job'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Job  $job
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Job $job)
	{
		//
		return view('jobs.edit', compact('job'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Job  $job
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Job $job)
	{
		//
		$request->validate([
			'name' => 'nullable|min:2|max:50',
			'email' => 'nullable|email',
			'address' => 'required|min:2',
			'phone' => 'nullable|min:10|max:15',
			'note' =>	'nullable|min:2',
		]);

		$job->name = $request->name;
		$job->email = $request->email;
		$job->address = $request->address;
		$job->phone = $request->phone;
		$job->extension = $request->extension;
		$job->note = $request->note;

		$job->save();

		$request->session()->flash('success', "Successfully updated Job.");

		return redirect( route( 'jobs.show', $job->id ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Job  $job
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Job $job)
	{
		//
		foreach( $job->invoices as $invoice )
        {
            $invoice->materials()->delete();
            $invoice->labour()->delete();

            $invoice->delete();
        }

        foreach( $job->proposals as $proposal )
        {
        	$proposal->materials()->delete();
        	$proposal->labour()->delete();

        	$proposal->delete();
        }

        $job->materials()->delete();
        $job->labour()->delete();

        $job->delete();

		Session::flash("success", "Successfully deleted Job.");

		return redirect( route('jobs.index') );
	}

	/**
	 * Create a non-matching job number
	 * Job numbers work like so:
	 * YY-SEQUE
	 *  2 digit year
	 *  Sequential numbers, five digits
	 * 
	 * @param $number, for recursion purposes
	*/
	private function createJobNumber( $number = false )
	{
		if ( !$number )
		{
			// dump( 'createJobNumber: no number provided.');
			// get latest job
			$job = Job::orderBy('created_at', 'DESC')
					->first();
			// if a Job has been returned
			if ( count( $job ) )
			{
				// verify the number, and add a one to sequential
				$number = $this->checkNumber( $job->number );
				// dump('createJobNumber: Passed number to checkNumber. Generated: '
					// . $number );
			}
			else // if no Job has been returned
			{
				// create a new number
				$number = $this->generateJobNumber( );
				// dump('createJobNumber: no Job has been returned. Call to generateJobNumber. Generated: ' . $number);
			}
		}
		else // if there is a number fed into createJobNumber
		{
			// check the number, and add a one to sequential
			$number = $this->checkNumber( $number );
			// dump('createJobNumber: A number has been fed, passing to checkNumber. Generated: ' . $number );
		}

		// check if the new numbers are used already
		if ( count( Job::where( 'number', $number )->first() ) )
		{
			// if the new number is used, add a one to sequential
			$number = $this->checkNumber( $number );
			// dump('createJobNumber: found a Job with new number being used. Call to checkNumber. Generated: ' . $number, 'Recusion to check new number.' );

			// run the number through this function again
			return $this->createJobNumber( $number );
		}

		// dump('createJobNumber: Final return. number variable has: ' . $number );
		return $number;

	}

	private function generateJobNumber( )
	{

		return date('y')
				.'-'
				.'00000';
	}

	private function checkNumber( $number )
	{
		/**
		 * Roll numbers work like so:
		 * YY-SEQUE
		 *  Sequential numbers, 5 digits
		 */

		$numberArray = explode('-', $number);

		// Ensure we have a valid number
		if ( isset( $numberArray[1] ) )
		{
			// If the number is for this year and month and roll size, do this
			if ( $numberArray[0] == date('y') )
			{
				// dump('Numbers for year match.');
				// Add a number to the sequential digit
				$numberArray[1]++;
				// dump('Added a one to sequential digit.');
				// Create the necessary padding
				$numberArray[1] = str_pad($numberArray[1], 5, '0', STR_PAD_LEFT);
				// dump('Padded the number after addition.');
				// put the number back together again
				$number = implode('-', $numberArray);
				// dump('Imploded number:' . $number );
			}
			else // If the number is not for this year and month, make one
			{
				// dump('Numbers for year, month and width do not match; call to generateJobNumber');
				// ooh aah creating a new number
				$number = $this->generateJobNumber( );
				// dump('Number generated by generateJobNumber: ' . $number );
			}

			// return the new number
			return $number;
			// dump('Generated number, returned by function: ' . $number);
		}
		// If the number is not correct, return back false
		// dump('The number does not appear to be valid because numberArray[4] is not set.');
		return false;
	}
}
