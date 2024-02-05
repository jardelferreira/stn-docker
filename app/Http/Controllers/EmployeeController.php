<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Profession;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Employee::all());
        return view('dashboard.employees.index',[
            'employees' => Employee::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(User::usersForEmployee()->get('users.*'),User::all());
        return view('dashboard.employees.create',[
            'users' => User::usersForEmployee()->get(),
            'professions' => Profession::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        // dd($request->all());
        Employee::create($request->all());

        return redirect()->route('dashboard.employees');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        dd($employee->bases()->get());
        return view('dashboard.employees.show',[
            'employee' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {  
        return view('dashboard.employees.edit',[
            'users' => User::all(),
            'professions' => Profession::all(),
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Employee $employee,UpdateEmployeeRequest $request)
    {
        $employee = Employee::where("uuid",$request->uuid)->first();
        $employee->update($request->all());

        return redirect()->route('dashboard.employees');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee = Employee::where('id', $request->id)->first();
        $employee->delete();

        return redirect()->route('dashboard.employees');
    }

    public function projects(Employee $employee)
    {   
        // dd($employee->projects()->get());
        return view('dashboard.employees.projects',[
            'employee' => $employee,
            'projects' => Project::all(),
            'employee_projects' => $employee->projects->pluck('id')->toArray()
        ]);
    }

    public function syncProjectsById(Employee $employee, Request $request)
    {
        $employee->projects()->sync($request->projects);

        return redirect()->route('dashboard.employees');
    }

    

    public function getProfessions(Project $project)
    {
        $professions = $project->professions()->get();

        return response()->json($professions);
    }

    public function listProject(Employee $employee)
    {
        return view('dashboard.employees.listProjects',[
            'projects' => $employee->projects()->get(),
            'employee' => $employee
        ]);
    }

    public function formlists(Employee $employee)
    {
        // dd($employee->formlistsFromEmployee()->with('base')->get());
        // dd($employee->bases()->get()->toArray());
        // dd($employee->formlistsFromEmployee()->get());
        return view('dashboard.employees.formlists',[
            'employee' => $employee,
            'formlists' => $employee->formlists()->get()
        ]);
    }
}
