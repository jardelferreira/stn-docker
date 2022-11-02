<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('dashboard/projects.index', [
            'projects' => Project::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('dashboard/projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {

        Project::create($request->all());

        return \redirect()->route('dashboard.projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if ($project->id) {
            return \view('dashboard/projects.show', [
                'project' => $project
            ]);
        }
        return redirect()->route('dashboard.projects', [
            'message' => 'Projeto não encontrado'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // $project = Project::where('id',$request->id)->first();

        if (is_object($project)) {
            return \view('dashboard/projects.edit', [
                'project' => $project
            ]);
        }
        return redirect()->route('dashboard.projects', [
            'message' => 'Projeto não encontrado'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project = Project::where('uuid', $request->uuid)->first();

        $project->update($request->all());
        
        return \view('dashboard/projects.show', [
            'project' => Project::where('uuid', $request->uuid)->first()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $project = Project::where('id', $request->id)->first();

        if (is_object($project)) {
            $project->delete();

            return \redirect()->route('dashboard.projects');
        }
        return redirect()->route('dashboard.projects', [
            'message' => 'Projeto não encontrado'
        ]);
    }

    public function providers(Project $project)
    {
        return view('dashboard.projects.providers',[
            'providers' => Provider::all(),
            'project' => $project,
            'project_providers' => $project->providers()->pluck('provider_id')->toArray(),

        ]);
    }

    public function syncProviders(Request $request, Project $project)
    {
        $project->providers()->sync($request->providers);
       
        return redirect()->route('dashboard.projects.providers',$project);
    }
}
