<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\User;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FormlistBaseEmployee;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{

    public function login()
    {
        if(Auth::check()) return redirect()->route('public.index');
        return view('publico.login');
    }

    public function index()
    {
        return view('publico.index');
    }

    public function projects()
    {
        return view('publico.projects.principal', [
            'projects' => Project::all()
        ]);
    }

    public function bases(Project $project)
    {
        return view('publico.projects.bases.index', [
            'project' => $project,
            'bases'   => $project->bases()->get()
        ]);
    }

    public function stokFromProject(Project $project)
    {
        // dd($project->sectors()->with('stoks')->get());
        return view('publico.projects.stoks', [
            'project' => $project
        ]);
    }

    public function stokFromBase(Base $base)
    {
        // dd($base->sectors()->with('stoks')->get());
        return view('publico.projects.bases.stoks', [
            'base' => $base
        ]);
    }

    public function formlists(User $user)
    {
        if (Auth::id() !== $user->id) {
            abort(403);
        }
        $employee = $user->employee()->first();
        return view('publico.employees.formlists',[
            'employee' => $employee
        ]);
    }

    public function fieldsFormlistByEmployee(FormlistBaseEmployee $formlist)
    {
        $user = User::where("id",Auth::id())->first();
        if($user->employee->id != $formlist->employee->id){
            abort(403);
        }
      
        return view('publico.employees.formlistsFields',[
            'employee' => $formlist->employee,
            'base' => $formlist->base,
            'formlist' => $formlist->formlist,
            'formlist_employee' => $formlist->id,
            'fields' => $formlist->fields()->get()
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('publico');
        }

        return back()->withErrors([
            'message' => 'Os dados informados não conferem.',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    public function showFormlists(User $user) {
        $employee = $user->employee()->first();
        // dd($user->employee->formlists()->with('ownerBase')->get());
        // dd($base_formlists =  $user->employee->bases($employee->id)->with(['formlistsByEmlpoyee' => function($q) use($employee){
        //     $q->where('employee_id',$employee->id);
        // }])->get());
        $base_formlists =  $user->employee->bases($employee->id)->with(['formlistsByEmlpoyee' => function($q) use($employee){
            $q->where('employee_id',$employee->id);
        }])->get();

        return view('publico.showFormlists',[
            'user' => $user,
            'employee' => $user->employee()->first(),
            'base_formlists' => $base_formlists
        ]);
    }

    public function formlistPdf(FormlistBaseEmployee $formlist_employee)
    {
        $html = view('formlistPdf',[
            'formlist' => $formlist_employee
        ]);
        $pdf = Pdf::loadHTML($html);
        return $pdf->download("{$formlist_employee->formlist->name}-{$formlist_employee->employee->user->name}.pdf");
    }
}
