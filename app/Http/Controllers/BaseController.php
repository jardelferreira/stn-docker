<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBaseRequest;
use App\Http\Requests\UpdateBaseRequest;
use App\Models\Base;
use App\Models\Project;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.bases.index',[
            'bases' => Base::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.bases.create',[
            'projects' => Project::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBaseRequest $request)
    {
        Base::create($request->all());

        return redirect()->route('dashboard.bases.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Base  $base
     * @return \Illuminate\Http\Response
     */
    public function show(Base $base)
    {
        return view('dashboard.bases.show',[
            'base' => $base
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Base  $base
     * @return \Illuminate\Http\Response
     */
    public function edit(Base $base)
    {
        $base->name = str_replace("-{$base->project()->first()->initials}","",$base->name);
        return view('dashboard.bases.edit',[
            'base' => $base,
            'projects' => Project::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBaseRequest  $request
     * @param  \App\Models\Base  $base
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBaseRequest $request, Base $base)
    {
        $base = Base::where("uuid",$request->uuid)->first();
        
        $base->update($request->all());

        return redirect()->route('dashboard.bases.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Base  $base
     * @return \Illuminate\Http\Response
     */
    public function destroy(Base $base)
    {
        $base->delete();

        return redirect()->route('dashboard.bases.index');
    }
}
