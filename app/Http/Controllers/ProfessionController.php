<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Profession;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProfessionRequest;
use App\Http\Requests\UpdateProfessionRequest;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.professions.index', [
            'professions' => Profession::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.professions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfessionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfessionRequest $request)
    {
        Profession::create($request->all());

        return redirect()->route('dashboard.professions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function show(Profession $profession)
    {
        return view('dashboard.professions.show', ['profession' => $profession]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function edit(Profession $profession)
    {
        return view('dashboard.professions.edit', ['profession' => $profession]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfessionRequest  $request
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfessionRequest $request, Profession $profession)
    {
        $profession->update($request->all());

        return redirect()->route('dashboard.professions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $profession = Profession::where("id",$request->id)->first();
        $profession->delete();

        return redirect()->route('dashboard.professions');
    }

    public function projects(Profession $profession)
    {   // dd($profession->getPermissions());
        return view('dashboard.professions.projects',[
            'profession' => $profession,
            'projects' => Project::all(),
            'profession_projects' => $profession->projects->pluck('id')->toArray()
        ]);
    }

    public function syncProjectsById(Profession $profession, Request $request)
    {
        $profession->projects()->sync($request->projects);

        return redirect()->route('dashboard.professions');
    }
}
