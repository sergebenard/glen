<?php

namespace App\Http\Controllers;

use App\Preferences;
use Illuminate\Http\Request;

class PreferencesController extends Controller
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
    public function create()
    {
        //
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
     * @param  \App\Preferences  $preferences
     * @return \Illuminate\Http\Response
     */
    public function show(Preferences $preference)
    {
        //
        return view('preferences.show', compact('preference'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Preferences  $preferences
     * @return \Illuminate\Http\Response
     */
    public function edit(Preferences $preference)
    {
        //
        return view('preferences.edit', compact('preference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Preferences  $preferences
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preferences $preference)
    {
        //
        $request->validate([
            'email' => 'nullable|email',
            'address' => 'nullable|min:5|max:100',
            'phone' => 'nullable|min:7',
            'markup' => 'nullable|numeric|between:0.01,100',
        ]);

        $preference->email = $request->email;
        $preference->address = $request->address;
        $preference->phone = $request->phone;
        $preference->markup = $request->markup;

        $preference->save();

        return redirect( route('preferences.show', 1) )->with('success', 'Successfully saved site preferences.');
    }
}
