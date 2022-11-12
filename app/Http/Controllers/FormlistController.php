<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormlistRequest;
use App\Http\Requests\UpdateFormlistRequest;
use App\Models\Formlist;

class FormlistController extends Controller
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
     * @param  \App\Http\Requests\StoreFormlistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormlistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function show(Formlist $formlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Formlist $formlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFormlistRequest  $request
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormlistRequest $request, Formlist $formlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formlist $formlist)
    {
        //
    }
}
