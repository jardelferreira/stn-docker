<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectRequest;
use App\Models\Invoice;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id',Auth::user()->id)->first();
        
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
        
        // $invoice = Invoice::where('id',4)->first();
        // dd($invoice->amountProducts(),$invoice->products()->get(), $invoice);
        // dd($project->employeesOnBases()->get());
        // dd($project->employeesOnBases()->toSql());
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
        
        return redirect()->route('dashboard.projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::where('id',Auth::user()->id)->first();

        if (!$user->can('projeto-deletar')) {
            return response()->json([
                'confirm' => false,
                'title' => "Ação rejeitada!",
                'message' => "Você não possui autorização para esta ação.",
                'type' => 'error'
            ]);
        }
        $project = Project::getProjectByUuid($request->uuid)->first();
        
        if (is_object($project)) {
            $project->delete();
            $data = [
                'confirm' => true,
                'title' => "Projeto deletado!",
                'message' => "O projeto {$project->name} deletado",
                'type' => 'success'
            ];
            return response()->json($data);

            // return \redirect()->route('dashboard.projects');
        }
        return response()->json([
            'confirm' => false,
            'title' => "Desculpe-nos!",
            'message' => "Não foi possível realizar operação, favor contactar o Admin",
            'type' => 'warning'
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

    public function employees(Project $project)
    {
        return view('dashboard.projects.employees',[
            'employees' => $project->employees()->get(),
            'project' => $project
        ]);
    }

    public function detachEmployee(Project $project, Employee $employee)
    {
        $project->employees()->detach($employee->id);

        return redirect()->route('dashboard.projects.employees',$project);
    }

    public function attachEmployee(Project $project, Employee $employee)
    {
        $project->employees()->attach($employee->id);

        return redirect()->route('dashboard.projects.employees',$project);
    }

    public function listEmployees(Project $project)
    {
        // dd($project->employees()->get()->pluck('id')->toArray());
        return view('dashboard.projects.listEmployees',[
            'employees' => $project->employeesForLink()->get(),
            'project' => $project,

        ]);
    }

    public function syncEmployees(Project $project, Request $request)
    {
        $project->employees()->sync($request->employees);

        return redirect()->route('dashboard.projects.employees', $project);
    }

    public function getProjectByUuid(Request $request)
    {
        return Project::getProjectByUuid($request->uuid)->first();
    }

}
