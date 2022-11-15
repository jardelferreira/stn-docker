<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBaseRequest;
use App\Http\Requests\UpdateBaseRequest;
use App\Models\Base;
use App\Models\Employee;
use App\Models\Formlist;
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

    public function formlists(Base $base)
    {
        return view('dashboard.projects.bases.formlists',[
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
        return view('dashboard.projects.bases.showFormlists',[
            'base' => $base,
            'formlists' => $base->formlists()->get()
        ]);
    }

    public function employeesLinked(Base $base)
    {
        return view('dashboard.projects.bases.employeesLinked',[
            'base' => $base,
            'employees' => $base->employees
        ]);
    }

    public function employees(Base $base)
    {
        // dd($base, $base->employees()->get());
        return view('dashboard.projects.bases.employees',[
            'employees' => Employee::all(),
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
        return view('dashboard.projects.bases.showEmployees',[
            'base' => $base,
            'employees' => $base->employees()->get()
        ]);
    }
}
