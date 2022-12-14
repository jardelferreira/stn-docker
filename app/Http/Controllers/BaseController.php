<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBaseRequest;
use App\Http\Requests\UpdateBaseRequest;
use App\Models\Base;
use App\Models\Employee;
use App\Models\Formlist;
use App\Models\FormlistBaseEmployee;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.projects.bases.index',[
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
        return view('dashboard.projects.bases.create',[
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
        return view('dashboard.projects.bases.show',[
            'base' => $base,
            'sectors' => $base->sectors()->get()
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
        return view('dashboard.projects.bases.edit',[
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

    public function stoks(Base $base)
    {
        return view('dashboard.projects.bases.stoks',[
            'base' => $base
        ]);
    }

    public function formlists(Base $base)
    {
        return view('dashboard.projects.bases.formlists.index',[
            'formlists' => Formlist::all(),
            'base' => $base,
            'base_formlists' => $base->formlists()->pluck('formlist_id')->toArray(),

        ]);
    }

    public function syncFormlistsById(Base $base, Request $request)
    {
        $base->formlists()->sync($request->formlists);

        return redirect()->route('dashboard.bases.show',$base);
    }

    public function showFormlists(Base $base)
    {
        // dd($base);
        return view('dashboard.projects.bases.formlists.showFormlists',[
            'base' => $base,
            'formlists' => $base->formlists()->get()
        ]);
    }

    public function employeesLinked(Base $base)
    {
        return view('dashboard.projects.bases.employees.employeesLinked',[
            'base' => $base,
            'employees' => $base->employees
        ]);
    }

    public function employees(Base $base)
    {
        return view('dashboard.projects.bases.employees.index',[
            'employees' => $base->project()->first()->employees()->with('user')->get(),
            'base' => $base,
            'base_employees' => $base->employees()->pluck('employee_id')->toArray(),

        ]);
    }

    public function syncEmployeesById(Base $base, Request $request)
    {
        $base->employees()->sync($request->employees);

        return redirect()->route('dashboard.bases.show',$base);
    }

    public function showEmployees(Base $base)
    {
        return view('dashboard.projects.bases.employees.showEmployees',[
            'base' => $base,
            'employees' => $base->employees()->get()
        ]);
    }

    public function formlistsByEmployee(Base $base,Employee $employee)
    {
        // dd($employee->formlistsByBase($base->id)->get());   
        // dd($employee->formlistBaseFromEmployee()->get()->toArray());
        return view('dashboard.projects.bases.employees.formlists',[
            'base' => $base,
            'employee' => $employee,
            'formlists' => $employee->formlistsByBase($base->id)->get()
        ]);
    }

    public function listFormlistsForEmployee(Base $base,Employee $employee)
    {
        // dd($employee->formlistsByBase($base->id)->get());
        return view('dashboard.projects.bases.employees.listFormlists',[
            'base' => $base,
            'employee' => $employee,
            'formlists' => $base->formlists()->get(),
            // 'employee_formlists' => $employee->formlists()->pluck('formlist_base_id')->toArray()
            'employee_formlists' => $employee->formlistsByBase($base->id)->pluck('formlist_id')->toArray()

        ]);
    }

    public function syncFormlistsByEmployee(Base $base,Employee $employee,  Request $request)
    {   
        //filtrar apenas os inputs selecionados
        $pivotData = array_fill(0, count($request->formlists), ['employee_id' => $employee->id,'base_id' => $base->id]);
        //combinar arrays
        $syncData  = array_combine($request->formlists, $pivotData);
        // dd($syncData);
        $employee->formlistsByBase($base->id)->sync($syncData);

        return redirect()->route('dashboard.bases.employees.list.formlists',[
            'base' => $base,
            'employee' => $employee,
            // 'employee_formlist' => $employee->formlistBaseFromEmployee()->pluck('formlist_id')
        ]);
    }

    public function fieldsFormlistByEmployee(Base $base,Employee $employee, FormlistBaseEmployee $formlist_employee)
    {
        // dd($formlist_employee->fields()->toSql());
        return view('dashboard.projects.bases.employees.formlistsFields',[
            'employee' => $formlist_employee->employee,
            'base' => $formlist_employee->base,
            'formlist' => $formlist_employee->formlist,
            'formlist_employee' => $formlist_employee->id,
            'fields' => $formlist_employee->fields()->get()
        ]);
    }

    public function detachEmployee(Base $base, Employee $employee)
    {
        $base->employees()->detach($employee->id);

        return redirect()->route('dashboard.bases.employees.linked',$base);
    }

    public function sectors(Base $base)
    {
        return view('dashboard.projects.bases.sectors',[
            'base' => $base,
            'sectors' => $base->sectors()->get()
        ]);
    }
    
    public function detachFormlist(Base $base,Request $request)
    {
        $base->formlists()->detach($request->id);

        return redirect()->route('dashboard.bases.formlists.show',$base);
    }
}
