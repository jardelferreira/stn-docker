<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\User;
use App\Models\Field;
use App\Models\Stoks;
use App\Models\Sector;
use App\Models\Employee;
use App\Models\Signature;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FormlistBaseEmployee;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use phpDocumentor\Reflection\Types\Boolean;

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
        // dd($formlist_employee->employee->signatures()->get());
        // dd($formlist_employee->id);
        return view('dashboard.projects.bases.employees.fields.create', [
            'base' => $formlist_employee->base,
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


    public function showSignature(Request $request, Signature $signatureField, Field $field)
    {
        // dd($signatureField);
        if (!$request->hasValidSignature(false)) {
            abort(401);
        }
        // dd($signatureField->signaturable()->first());
        if ($signatureField->signaturable->user_id) {
            $user = User::where("id", $signatureField->user_id)->first();
            return view("showSignature", [
                "user" => $signatureField->signaturable()->first(),
                'signature' => $signatureField,
                'field' => $field

            ]);
        }
        return view('showSignature', [
            'user' => $signatureField->signaturable,
            'signature' => $signatureField,
            'field' => $field
        ]);
        // return $signatureField->with('signaturable')->get();
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

    public function getStoksBySector(FormlistBaseEmployee $formlist_employee, Sector $sector, Request $request)
    {
        $stoks = $sector->stoks()->where('qtd', ">", 0)
            ->with('invoiceProduct')->where('slug', 'LIKE', "%$request->q%")->orderBy('slug', 'ASC')->get();

        $array = [];
        foreach ($stoks as $key => $value) {
            $array[$key] = ['id' => $value->id, 'name' => $value->invoiceProduct->name, "qtd" => $value->qtd,  'ca' => $value->invoiceProduct->ca_number];
        }

        return response()->json($array);
    }

    public function salveField(FormlistBaseEmployee $formlist_employee, Request $request)
    {
        if (!$request->location) {
            return redirect()->back()->with(['message' => "Não foi possível seguir sem os dados da Geolocalização."]);
        }

        $employee = $formlist_employee->employee()->first();
        if (!$employee->user->hasSignature()) {
            //redireciona o colaborador que não tem assinatura
            return redirect()->route('dashboard.users.show', [
                'user' => $employee->user
            ])->with(['message' => "O usuário ainda não possui senha para assinar, favor gerar senha, favor gerar senhar"]);
        }

        $stok = Stoks::where('id', $request->stok_id)->first();

        // dd($formlist_employee->saveEventString($stok->invoiceProduct, $request->qtd_delivered));

        $signature = $employee->user->signatures()->create([
            'uuid' => Str::uuid(),
            'user_id' => Auth::user()->id,
            'location' => $request->location,
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
        $dados = array_merge($dados, $request->except('location'));
        // dd($dados);
        Field::create($dados);

        return redirect()->route('dashboard.bases.employees.formlists.fields', [
            'formlist_employee' => $formlist_employee,
            'employee' => $formlist_employee->employee,
            'base' => $formlist_employee->base
        ]);
    }

    public function devolutionField(
        Base $base,
        Employee $employee,
        FormlistBaseEmployee $formlist_employee,
        Request $request
    ) {

        if (!$request->location) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'Geolocalização obrigatória.',
                'footer' => "Erro de Geolocalização."
            ]);
        }
        $employee = $formlist_employee->employee()->first();
        if (!$employee->user->hasSignature()) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'Crie uma senha para o colaborador.',
                'footer' => "Erro de Senha.",
                'redirection' => route('dashboard.users.show', $employee->user)
            ]);
        }

        $check = $employee->user->checkSignature($request->pass);
        if (!$check['success']) {
            return response()->json($check);
        }
        $field = Field::where("id", $request->id)->first();
        $stok = Stoks::where('id', $field->stok_id)->first();
        $event = $formlist_employee->saveEventString($stok->invoiceProduct, $field->qtd_delivered, 2);


        $signature_returned = $employee->user->signatures()->create([
            'uuid' => Str::uuid(),
            'user_id' => intVal(Auth::user()->id),
            'signature' => $employee->user->signature()->signature,
            'location' => $request->location,
            'event' => $event
        ]);

        if ($signature_returned) {
            $field->update([
                'date_returned' => date("Y-m-d H:i:s"),
                'signature_returned' => $signature_returned->id,
            ]);

            if ($request->sector_id == $stok->sector_id) {
                $stok->update(['qtd' => floatval($stok->qtd) + floatval($field->qtd_delivered)]);
            } else {
                # code...
                $sector = Sector::where("id",$request->sector_id)->first();
                // $stok->old_id = $stok->id;
                Stoks::create([
                    'uuid' => Str::uuid(),
                    'slug' => Str::slug("{$sector->id}-{$stok->slug}"),
                    'sector_id' => $sector->id,
                    'base_id' => $sector->base->id,
                    'project_id' => $sector->project_id,
                    'invoice_products_id' => $stok->invoice_products_id,
                    'qtd' => $field->qtd_delivered,
                    'product_id' => $stok->product_id,
                    'image_path' => $stok->image_path,
                    'status' => 'disponível',
                ]);
            }

            return response()->json([
                'success' => true,
                'type'    => 'success',
                'message' => "Devolução realizada com sucesso.",
                'footer'  => "Devolução de material"
            ]);
        }
        return response()->json([
            'success' => false,
            'type' => 'error',
            'message' => 'Erro ao tentar assinar documento!',
            'footer'  => "Devolução de material"

        ]);
    }

    public function signatureField(FormlistBaseEmployee $formlist_employee, Request $request)
    {

        $employee = $formlist_employee->employee()->first();
        if (!$request->location) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'Geolocalização obrigatória.',
                'footer' => "Erro de Geolocalização."
            ]);
        }
        if (!$employee->user->hasSignature()) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'É necessário cadastrar uma assinatura para este usuário.',
                'footer' => "Erro de Senha."
            ]);
        }

        $check = $employee->user->checkSignature($request->pass, $employee->user->name);
        if (!$check['success']) {
            return response()->json($check);
        }

        //caso já tenha sido gerado uma assinatura previamente e por erros o processo em tela não seguiu
        if ($request->signature_delivered) {
            $signature_delivered = $request->signature_delivered;
        } else {

            $signature_delivered = $employee->user->signatures()->create([
                'uuid' => Str::uuid(),
                'user_id' => Auth::user()->id,
                'signature' => $employee->user->signature()->signature,
                'location' => $request->location,
                'event' => "pre assinatura."
            ]);
        }
        if ($signature_delivered) {
            return response()->json([
                'success' => true,
                'type' => 'success',
                'signature_id' => $signature_delivered->id,
                'event' => "pre assinatura",
                'message' => "Assinatura gerada com sucesso!",
            ]);
        }
        return response()->json([
            'success' => false,
            'type' => 'error',
            'message' => 'Erro ao tentar assinar documento!'
        ]);
    }

    //salvar após gerar a assinatura acima
    public function salveFieldAfterAssign(FormlistBaseEmployee $formlist_employee, StoreFieldRequest $request)
    {
        $signature = Signature::where("id", $request->signature_delivered)->first();

        if (!$request->location) {
            $signature->delete();
            return redirect()->back()->with(['message' => "Não foi possível seguir sem os dados da Geolocalização."]);
        }
        $employee = $formlist_employee->employee()->first();
        $stok = Stoks::where("id", intval($request->stok_id))->first();
        $event = $formlist_employee->saveEventString($stok->invoiceProduct, $request->qtd_delivered);

        if ($stok->qtd < $request->qtd_delivered) {
            $signature->delete();
            return redirect()->back()
                ->withErrors(["message" => "Quantidade: {$stok->qtd}, solicitado: {$request->qtd_delivered}, insuficiente em estoque. O produto que você tentou adicionar não tem em estoque ou não tem a quantidade disponível."]);
        }
        $dados = [
            'uuid' => Str::uuid(),
            'ca_first' => $stok->invoiceProduct->ca_number,
            'date_delivered' => date("Y-m-d H:i:s"),
            'user_id' => intVal(Auth::user()->id),
            'employee_id' => intVal($employee->id),
            'formlist_base_employee_id' => intVal($formlist_employee->id),
            'signature_delivered' => $signature->id, //trazer via request
            'qtd_required' => 0
        ];
        $dados = array_merge($dados, $request->all());
        // return $signature;
        $field = Field::create($dados);
        if ($field) {
            $stok->update(['qtd' => ($stok->qtd - $request->qtd_delivered)]);

            $signature->update(['event' => $event]);
            // dd($signature);

            return redirect()->route('dashboard.bases.employees.formlists.fields', [
                'formlist_employee' => $formlist_employee,
                'employee' => $formlist_employee->employee,
                'base' => $formlist_employee->base
            ]);
        } else {
            return redirect()->back()->withErrors(["message" => "Ocorreu um erro durante a gravação do campo na ficha."]);
        }
    }


    public function ajaxSalveFieldAfterAssign(FormlistBaseEmployee $formlist_employee, Request $request)
    {
        $signature = Signature::where("id", $request->signature_id)->first();
        if (!$request->location) {
            $signature->delete();
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'Geolocalização obrigatória.',
                'footer' => "Erro de Geolocalização."
            ]);
        }
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

        $signature->update(['event' => $event]);

        return response()->json([
            'success' => true,
            'type' => 'success',
            'event' => "Recarregando a página...",
            'message' => "Operação finalizada com sucesso!",
        ]);
    }

    public function lowering(
        Base $base,
        Employee $employee,
        FormlistBaseEmployee $formlist_employee,
        Request $request
    ) {
        if (!$request->location) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'Geolocalização obrigatória.',
                'footer' => "Erro de Geolocalização."
            ]);
        }
        $user  = User::where('id', Auth()->user()->id)->first();

        if (!$user->hasSignature()) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'É necessário cadastrar uma assinatura de usuário.',
                'footer' => "Erro de Senha."
            ]);
        }

        $check = $user->checkSignature($request->user_pass);
        if (!$check['success']) {
            return response()->json($check);
        }

        $field = Field::where("id", $request->id)->first();
        $stok = Stoks::where('id', $field->stok_id)->first();
        $event = $formlist_employee->saveEventString($stok->invoiceProduct, $field->qtd_delivered, 1);


        $signature_returned = $user->signatures()->create([
            'uuid' => Str::uuid(),
            'user_id' => intVal(Auth::user()->id),
            'signature' => $user->signature()->signature,
            'location' => $request->location,
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
                'message' => "Baixa realizada com sucesso.",
                'footer'  => "Baixa de material"
            ]);
        }
        return response()->json([
            'success' => false,
            'type' => 'erro',
            'message' => "Não foi possível executar a requisição.",
            'footer' => "Erro interno."
        ]);
    }

    public function userHasPass(Request $request)
    {

        $user  = User::where('id', Auth()->user()->id)->first();

        if (!$user->hasSignature()) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'É necessário cadastrar uma assinatura para o usuário.',
                'footer' => "Erro de Senha."
            ]);
        }

        $check = $user->checkSignature($request->pass);
        if (!$check['success']) {
            return response()->json($check);
        }
    }

    //falta implementar uma rota específica para Fields
    public function removeFieldFormlistByEmployee(Field $field, Request $request)
    {
        if (!$request->location) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'Geolocalização obrigatória.',
                'footer' => "Erro de Geolocalização."
            ]);
        }
        $user  = User::where('id', Auth()->user()->id)->first();

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

        if ($field->delete()) {
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

    public function employeeHasPas(Request $request)
    {
        $employee  = Employee::where('id', $request->id)->first();

        if (!$employee->user->hasSignature()) {
            return response()->json([
                'success' => false,
                'type' => 'info',
                'message' => 'É necessário cadastrar uma assinatura para o funcionário.',
                'footer' => "Erro de Senha."
            ]);
        }

        $check = $employee->user->checkSignature($request->pass, $employee->user->name);
        if (!$check['success']) {
            return response()->json($check);
        }
    }

    function documents(Base $base, Employee $employee, FormlistBaseEmployee $formlist_employee, Stoks $stok)
    {
        return view('dashboard.projects.bases.employees.fields.documents', [
            "stok" => $stok,
            "employee" => $employee,
            "formlist_employee" => $formlist_employee
        ]);
    }

    function documentsFromStokIdJson(Base $base, Employee $employee, FormlistBaseEmployee $formlist_employee, Stoks $stok)
    {
        return response()->json(['data' => $stok->documents()->get()]);
    }
}
