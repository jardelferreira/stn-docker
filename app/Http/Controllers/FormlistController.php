<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormlistRequest;
use App\Http\Requests\UpdateFormlistRequest;
use App\Models\Base;
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
        return view('dashboard.formlists.index',[
            'formlists' => Formlist::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.formlists.create',[
            'bases' => Base::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFormlistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormlistRequest $request)
    {
        Formlist::create($request->all());

        return redirect()->route('dashboard.formlists');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function show(Formlist $formlist)
    {
        return view('dashboard.formlists.show',[
            'formlist' => $formlist
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Formlist $formlist)
    {
        return view('dashboard.formlists.edit',[
            'bases' => Base::all(),
            'formlist' => $formlist
        ]);
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
        $formlist->update($request->all());

        return redirect()->route('dashboard.formlists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formlist $formlist)
    {
        $formlist->delete();

        return redirect()->route('dashboard.formlists');
    }
}
