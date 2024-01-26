<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\User;
use App\Models\Field;
use App\Models\Stoks;
// use Barryvdh\DomPDF\PDF;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Formlist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FormlistBaseEmployee;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBaseRequest;
use App\Http\Requests\UpdateBaseRequest;
use App\Models\Product;
use App\Models\Signature;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.projects.bases.index', [
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
        return view('dashboard.projects.bases.create', [
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
        return view('dashboard.projects.bases.show', [
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
        $base->name = str_replace("-{$base->project()->first()->initials}", "", $base->name);
        return view('dashboard.projects.bases.edit', [
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
        $base = Base::where("uuid", $request->uuid)->first();

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
        return view('dashboard.projects.bases.stoks', [
            'base' => $base
        ]);
    }

    public function formlists(Base $base)
    {
        return view('dashboard.projects.bases.formlists.index', [
            'formlists' => Formlist::all(),
            'base' => $base,
            'base_formlists' => $base->formlists()->pluck('formlist_id')->toArray(),

        ]);
    }

    public function syncFormlistsById(Base $base, Request $request)
    {
        $base->formlists()->sync($request->formlists);

        return redirect()->route('dashboard.bases.show', $base);
    }

    public function showFormlists(Base $base)
    {
        // dd($base);
        return view('dashboard.projects.bases.formlists.showFormlists', [
            'base' => $base,
            'formlists' => $base->formlists()->get()
        ]);
    }

    public function employeesLinked(Base $base)
    {
        return view('dashboard.projects.bases.employees.employeesLinked', [
            'base' => $base,
            'employees' => $base->employees
        ]);
    }
 
    public function employees(Base $base)
    {
        return view('dashboard.projects.bases.employees.index', [
            'employees' => $base->employeesForLink()->get(),
            'base' => $base,
            'base_employees' => $base->employees()->pluck('employee_id')->toArray(),

        ]);
    }

    public function syncEmployeesById(Base $base, Request $request)
    {
        foreach ($request->employees as $employee) {
            $base->employees()->attach($employee);
        }

        return redirect()->route('dashboard.bases.show', $base);
    }

    public function attachEmployee(Base $base, Employee $employee)
    {
        $base->employees()->attach($employee->id);

        return redirect()->route('dashboard.bases.show',$base);
    }

    public function showEmployees(Base $base)
    {
        return view('dashboard.projects.bases.employees.showEmployees', [
            'base' => $base,
            'employees' => $base->employees()->get()
        ]);
    }

    public function formlistsByEmployee(Base $base, Employee $employee)
    {
        // dd($employee->formlistsByBase($base->id)->get());   
        // dd($employee->formlistBaseFromEmployee()->get()->toArray());
        return view('dashboard.projects.bases.employees.formlists', [
            'base' => $base,
            'employee' => $employee,
            'formlists' => $employee->formlistsByBase($base->id)->get()
        ]);
    }

    public function listFormlistsForEmployee(Base $base, Employee $employee)
    {
        // dd($employee->formlistsByBase($base->id)->get());
        return view('dashboard.projects.bases.employees.listFormlists', [
            'base' => $base,
            'employee' => $employee,
            'formlists' => $base->formlists()->get(),
            // 'employee_formlists' => $employee->formlists()->pluck('formlist_base_id')->toArray()
            'employee_formlists' => $employee->formlistsByBase($base->id)->pluck('formlist_id')->toArray()

        ]);
    }

    public function syncFormlistsByEmployee(Base $base, Employee $employee,  Request $request)
    {
        //filtrar apenas os inputs selecionados
        $pivotData = array_fill(0, count($request->formlists), ['employee_id' => $employee->id, 'base_id' => $base->id]);
        //combinar arrays
        $syncData  = array_combine($request->formlists, $pivotData);
        // dd($syncData);
        $employee->formlistsByBase($base->id)->sync($syncData);

        return redirect()->route('dashboard.bases.employees.list.formlists', [
            'base' => $base,
            'employee' => $employee,
            // 'employee_formlist' => $employee->formlistBaseFromEmployee()->pluck('formlist_id')
        ]);
    }

    public function fieldsFormlistByEmployee(Base $base, Employee $employee, FormlistBaseEmployee $formlist_employee)
    {
        // dd(User::find(1)->signatures()->get());
        // dd(Signature::find($formlist_employee->fields()->first()->signature_delivered))->first();
        return view('dashboard.projects.bases.employees.formlistsFields', [
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

        return redirect()->route('dashboard.bases.employees.linked', $base);
    }

    public function sectors(Base $base)
    {
        return view('dashboard.projects.bases.sectors', [
            'base' => $base,
            'sectors' => $base->sectors()->get()
        ]);
    }

    public function detachFormlist(Base $base, Request $request)
    {
        $base->formlists()->detach($request->id);

        return redirect()->route('dashboard.bases.formlists.show', $base);
    }
    
    public function formlistPdf(FormlistBaseEmployee $formlist_employee)
    {
        
        // return $html = view('formlistPdf',[
        //     'formlist' => $formlist_employee,
        //     'document' => $formlist_employee->fields()->first()->stoks()->first()->documents()->first()
        // ]);
        
        $html = view('formlistPdf',[
            'formlist' => $formlist_employee,
            'fields' => $formlist_employee->fields()->with("stoks.documents")->get(),
        ]);
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->download("{$formlist_employee->formlist->name}-{$formlist_employee->employee->user->name}.pdf");
    }

    public function removeFieldFormlistByEmployee(
        Base $base, Employee $employee, FormlistBaseEmployee $formlist_employee,Request $request
    )
    {
        $user  = User::where('id',Auth()->user()->id)->first();

        if (!$user->hasSignature()) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'É necessário cadastrar uma assinatura.',
                'footer' => "Erro de Senha."
            ]);
        }

        $check = $user->checkSignature($request->pass);
        if (!$check['success']) {
            return response()->json($check);
        }

        $field = Field::where("id",$request->id);

        if($field->delete()){
            return response()->json([
                'success' => true,
                'type' => 'success',
                'message' => "O item foi retirado do formulário com sucesso!",
                'footer' => "Gerenciamento de fichas."
            ]);
        }

        return response()->json([
            'success' => false,
            'type' => 'erro',
            'message' => "Não foi possível executar a requisição.",
            'footer' => "Erro interno."
        ]);

    }
 
    public function getSimilar(
        Base $base, Employee $employee, FormlistBaseEmployee $formlist_employee,Stoks $stoks
    )
    {
        $product = Product::where("id",$stoks->invoiceProduct->product_id)->first(); 
        // dd($product->stoksWithDetails()->where("sector_id",$stoks->sector_id)->get());
        return response()->json($product->stoksWithDetails()->where("sector_id",$stoks->sector_id)->get());
    }

    public function lowering(
        Base $base, Employee $employee, FormlistBaseEmployee $formlist_employee,Request $request
    )
    {
        $user  = User::where('id',Auth()->user()->id)->first();

        if (!$user->hasSignature()) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'É necessário cadastrar uma assinatura.',
                'footer' => "Erro de Senha."
            ]);
        }

        $check = $user->checkSignature($request->pass);
        if (!$check['success']) {
            return response()->json($check);
        }

        $field = Field::where("id", $request->id)->first();
        $stok = Stoks::where('id', $field->stok_id)->first();
        $event = $formlist_employee->saveEventString($stok->invoiceProduct, $field->qtd_delivered, 1);


        $signature_returned = $employee->signature()->create([
            'uuid' => Str::uuid(),
            'user_id' => intVal(Auth::user()->id),
            'signature' => $employee->user->signature()->signature,
            'event' => $event
        ]);

        if ($signature_returned) {
            $field->update([
                'date_returned' => date("Y-m-d H:i:s"),
                'signature_returned' => $signature_returned->id,
            ]);
            
            return response()->json([
                'success' => true,
                'type'    => 'success',
                'message' => "Devolução realizada com sucesso.",
                'footer'  => "Devolução de material"
            ]);

        }
        return response()->json([
            'success' => false,
            'type' => 'erro',
            'message' => "Não foi possível executar a requisição.",
            'footer' => "Erro interno."
        ]);

    }

}
