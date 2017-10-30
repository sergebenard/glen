<?php

namespace App\Http\Controllers;

use App\Job;
use App\Invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unfinished = Job::orderBy('created_at', 'DESC')->
                        where('finished', '=', null)->
                        get();
        $unpaid = Invoices::orderBy('created_at', 'DESC')->
                        where('paid', '<', 1)->
                        with('job', 'materials', 'labour')->
                        get();
        return view('home', compact('unfinished', 'unpaid'));
    }

    public function calculator()
    {
        
    }
}
