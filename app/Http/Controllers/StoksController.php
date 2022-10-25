<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoksRequest;
use App\Http\Requests\UpdateStoksRequest;
use App\Models\Sector;
use App\Models\Stoks;

class StoksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Sector $sector)
    {
        
        // dd($sector->with('stocks.invoiceProduct.invoice')->get());
        return view('dashboard.sectors.stocks.index',[
            'sector' => $sector,
            'stocks' => $sector->with('stocks.invoiceProduct.invoice')->get(),
        ]);
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
     * @param  \App\Http\Requests\StoreStoksRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStoksRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return \Illuminate\Http\Response
     */
    public function show(Stoks $stoks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return \Illuminate\Http\Response
     */
    public function edit(Stoks $stoks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStoksRequest  $request
     * @param  \App\Models\Stoks  $stoks
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoksRequest $request, Stoks $stoks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stoks $stoks)
    {
        //
    }
}
