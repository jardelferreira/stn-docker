<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\User;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FormlistBaseEmployee;
use App\Models\Stoks;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;

class PublicController extends Controller
{

    public function login()
    {
        if (Auth::check()) return redirect()->route('public.index');
        return view('publico.login');
    }

    public function index()
    {
        return view('publico.index');
    }

    public function stoks(Stoks $stoks)
    {
        // return response()->json($stoks->analitic()->get());
        // dd(Stoks::with(['sector','base','project', 'invoiceProduct','product','fields'])->get()->toArray());
        return view('publico.stoks.stoks', [
            'stoks' => $stoks->with(['sector','base','project', 'invoiceProduct','product','fields'])->get()
        ]);
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
        return view('publico.employees.formlists', [
            'employee' => $employee
        ]);
    }

    public function fieldsFormlistByEmployee(FormlistBaseEmployee $formlist)
    {
        $user = User::where("id", Auth::id())->first();
        if ($user->employee->id != $formlist->employee->id) {
            abort(403);
        }

        return view('publico.employees.formlistsFields', [
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

    public function showFormlists(User $user)
    {
        $employee = $user->employee()->first();
        // dd($user->employee->formlists()->with('ownerBase')->get());
        // dd($base_formlists =  $user->employee->bases($employee->id)->with(['formlistsByEmlpoyee' => function($q) use($employee){
        //     $q->where('employee_id',$employee->id);
        // }])->get());
        $base_formlists =  $user->employee->bases($employee->id)->withoutGlobalScopes()->with(['formlistsByEmlpoyee' => function ($q) use ($employee) {
            $q->where('employee_id', $employee->id);
        }])->get();

        return view('publico.showFormlists', [
            'user' => $user,
            'employee' => $user->employee()->first(),
            'base_formlists' => $base_formlists
        ]);
    }

    public function formlistPdf(FormlistBaseEmployee $formlist_employee, Request $request)
    { 
        // dd(boolval($request->documentable));
        // return view('dashboard.projects.bases.employees.formlistsFields', [
        //     'employee' => $formlist_employee->employee,
        //     'base' => $formlist_employee->base,
        //     'formlist' => $formlist_employee->formlist,
        //     'formlist_employee' => $formlist_employee,
        //     'fields' => $formlist_employee->fields()->get()
        // ]);
        
        $pdf = Pdf::loadView('formlistPdf', [
            'formlist' => $formlist_employee,
            'fields' => $formlist_employee->fields()->get(),
            'documents' => $formlist_employee->documentsFromFormlist()->get(),
            'documentable' => boolval($request->documentable)
        ]);
        // $pdf = Pdf::loadHTML($html);
        return $pdf->stream("{$formlist_employee->formlist->name}-{$formlist_employee->employee->user->name}.pdf");
    }

    public function getUserByCPF()
    {
        return view('publico.stn.getUserByCpf');
    }

    public function redirectUserByCPF(Request $request)
    {

        if ($employee = Employee::where('cpf', $request->cpf)->first()) {
            // dd($employee);
            return redirect()->route('showFormlists', $employee->user->id);
        }
        return redirect()->back()->withErrors(['message' => 'CPF Não encontrado']);
    }

    public function apica()
    {
        return view('extern.apica');
    }

    function getCA($ca)
    {
        $url = "https://apica.jfwebsystem.com.br/CA/{$ca}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);  //if you need
        curl_close($ch);
        return response()->json(json_decode($response));
    }

    public function hkmHome() {
        return view('hkm.index');
    }
    
    public function qrcode(Generator $qrCode) {
        return view('publico.teste',[
            "qrcode" => $qrCode
        ]);
    }

    
}
