<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectorRequest;
use App\Http\Requests\UpdateSectorRequest;
use App\Models\Base;
use App\Models\Product;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.projects.bases.sectors.index',[
            'sectors' => Sector::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
        $base = Base::where('id',$request->base)->first();
        return  view('dashboard.projects.bases.sectors.create',[
            'bases' => Base::all(),
            'base' => $base
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSectorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectorRequest $request)
    {
        Sector::create($request->all());

        return redirect()->route('dashboard.sectors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function show(Sector $sector)
    {
        return  view('dashboard.projects.bases.sectors.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function edit(Sector $sector)
    {
        return  view('dashboard.projects.bases.sectors.edit',[
            'bases' => Base::all(),
            'sector' => $sector
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSectorRequest  $request
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSectorRequest $request, Sector $sector)
    {
        $sector = Sector::where('uuid',$request->uuid)->first();

        $sector->update($request->all());

        return redirect()->route('dashboard.sectors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sector $sector)
    {
        $sector->delete();

        return redirect()->route('dashboard.sectors.index');
        
    }

    public function productProfile(Sector $sector, Product $product)
    {
        // dd($product->purchased()->first()->qtd_total);
        return view('dashboard.projects.bases.sectors.productHistory',[
            'product' => $product,
            'sector' => $sector,
            'histories' => $product->historyBySector($sector->id)->get(),
            'providers' => $product->providers()->get()
        ]);
    }
}
