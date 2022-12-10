<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\sectorsCosts;
use Illuminate\Http\Request;
use App\Http\Requests\StoresectorsCostsRequest;
use App\Http\Requests\UpdatesectorsCostsRequest;
use App\Models\Project;

class SectorsCostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('dashboard.financeiro.setctors.index',[
            'sectors' => sectorsCosts::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('dashboard.financeiro.setctors.create',[
            'cost_centers' => Cost::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSectorForCost(Cost $cost)
    {
        return \view('dashboard.financeiro.costs.createSector',[
            'cost' => $cost
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoresectorsCostsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        sectorsCosts::create($request->all());

        return \redirect()->route('dashboard.costs_sectors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return \Illuminate\Http\Response
     */
    public function show(sectorsCosts $sectorsCosts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return \Illuminate\Http\Response
     */
    public function edit(sectorsCosts $sector)
    {
        return \view('dashboard.financeiro.setctors.edit',[
            'sector' => $sector,
            'costs' => Cost::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesectorsCostsRequest  $request
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $sector = sectorsCosts::where("uuid",$request->uuid)->first();
        $sector->update($request->all());

        return \redirect()->route('dashboard.costs_sectors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sectorsCosts  $sectorsCosts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $sectorsCosts = sectorsCosts::where("id",$request->id)->first();

        $sectorsCosts->delete();

        return redirect()->route('dashboard.cost_sectors.index');
    }
}
