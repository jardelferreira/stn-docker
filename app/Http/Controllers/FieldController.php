<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Field;
use App\Models\Sector;
use App\Models\FormlistBaseEmployee;
use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use App\Models\Signature;
use App\Models\Stoks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormlistBaseEmployee $formlist_employee)
    {
        // dd($formlist_employee->id);
        return view('dashboard.projects.bases.employees.fields.create', [
            'base' => $formlist_employee->base()->first(),
            'formlist' => $formlist_employee->id,
            'employee' => $formlist_employee->employee,
            'formlist_employee' => $formlist_employee->with('base.sectors.stoks.invoiceProduct.invoice')->first()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFieldRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFieldRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFieldRequest  $request
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFieldRequest $request, Field $field)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        //
    }

    public function getSectors(FormlistBaseEmployee $formlist_employee)
    {
        $sectors = $formlist_employee->base->sectors()->pluck('name', 'id');
        // dd($sectors);
        $array = [];
        foreach ($sectors as $key => $value) {
            array_push($array, ['id' => $key, 'name' => $value]);
        }
        // dd($array);
        return response()->json($array);
    }

    public function getStoksBySector(FormlistBaseEmployee $formlist_employee, Sector $sector)
    {
        $stoks = $sector->stoks()->where('qtd',">", 0)->with('invoiceProduct')->get();
        $array = [];
        foreach ($stoks as $key => $value) {
            $array[$key] = ['id' => $value->id, 'name' => $value->invoiceProduct->name, "qtd" => $value->qtd];
        }

        return response()->json($array);
    }

    public function salveField(FormlistBaseEmployee $formlist_employee, Request $request)
    {
        $employee = $formlist_employee->employee()->first();
        // dd($formlist_employee);
        if (!$employee->user->hasSignature()) {
            //redireciona o usuário que não tem assinatura
            return redirect()->route('dashboard.users.show', [
                'user' => $employee->user
            ])->with(['message' => "O usuário ainda não possui senha para assinar, favor gerar senha, favor Gerar senhar"]);
        }
        $stok = Stoks::where('id', $request->stok_id)->first();
        $signature = $employee->signature()->create([
            'uuid' => Str::uuid(),
            'user_id' => Auth::user()->id,
            'signature' => $employee->user->signature()->signature,
            'event' => $formlist_employee->saveEventString($stok->invoiceProduct, $request->qtd_delivered)
        ]);
        // dd(date("Y-m-d H:i:s"));

        $dados = [
            'uuid' => Str::uuid(),
            'ca_first' => $stok->invoiceProduct->ca_number,
            'date_delivered' => date("Y-m-d H:i:s"),
            'user_id' => intVal(Auth::user()->id),
            'employee_id' => intVal($employee->id),
            'formlist_base_employee_id' => intVal($formlist_employee->id),
            'signature_delivered' => $signature->id,
            'qtd_required' => 0
        ];
        $dados = array_merge($dados, $request->all());
        // dd($dados);
        Field::create($dados);

        return redirect()->route('dashboard.bases.employees.formlists.fields', [
            'formlist_employee' => $formlist_employee,
            'employee' => $formlist_employee->employee,
            'base' => $formlist_employee->base
        ]);
    }

    public function signatureField(FormlistBaseEmployee $formlist_employee, Request $request)
    {

        $employee = $formlist_employee->employee()->first();

        if (!$employee->user->hasSignature()) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'É necessário cadastrar uma assinatura.',
                'footer' => "Erro de Senha."
            ]);
        }
        
        $check = $employee->user->checkSignature($request->pass);
        if (!$check['success']) {
            return response()->json($check);
        }
 
        if($request->signature_delivered){
            $signature_delivered = $request->signature_delivered;
        }else{

            $signature_delivered = $employee->signature()->create([
                'uuid' => Str::uuid(),
                'user_id' => Auth::user()->id,
                'signature' => $employee->user->signature()->signature,
                'event' => "O Item será adicionado a ficha."
            ]);
            
        }
        if ($signature_delivered) {
            return response()->json([
                'success' => true,
                'type' => 'success',
                'signature_id' => $signature_delivered->id,
                'event' => "O Produto será enviado agora...",
                'message' => "Documento assinado com sucesso!",
            ]);
        }
        return response()->json([
            'success' => false,
            'type' => 'error',
            'message' => 'Erro ao tentar assinar documento!'
        ]);
    }

    public function salveFieldAfterAssign(FormlistBaseEmployee $formlist_employee, StoreFieldRequest $request)
    {
        $employee = $formlist_employee->employee()->first();
        $stok = Stoks::where('id', $request->stok_id)->first();
        $event = $formlist_employee->saveEventString($stok->invoiceProduct, $request->qtd_delivered);

        $dados = [
            'uuid' => Str::uuid(),
            'ca_first' => $stok->invoiceProduct->ca_number,
            'date_delivered' => date("Y-m-d H:i:s"),
            'user_id' => intVal(Auth::user()->id),
            'employee_id' => intVal($employee->id),
            'formlist_base_employee_id' => intVal($formlist_employee->id),
            'signature_delivered' => $request->signature_id, //trazer via request
            'qtd_required' => 0
        ];
        $dados = array_merge($dados, $request->all());

        Field::create($dados);
        
        $stok->update(['qtd' => $stok->qtd - $request->qtd_delivered]);

        $signature = Signature::where("id",$request->signature_id);
        $signature->update(['event' => $event]);

        return redirect()->route('dashboard.bases.employees.formlists.fields', [
            'formlist_employee' => $formlist_employee,
            'employee' => $formlist_employee->employee,
            'base' => $formlist_employee->base
        ]);
    }
}
