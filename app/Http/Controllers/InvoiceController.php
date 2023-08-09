<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Provider;
use App\Models\DepartamentCost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view('dashboard.financeiro.invoices.index', [
            'invoicers' => Invoice::all()->sortBy('id', SORT_DESC, true)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(!(Invoice::where("name","NF-0548-COMERCIAL COELHO")->where('departament_cost_id',6)->count() > 0));
        return \view('dashboard.financeiro.invoices.create', [
            'providers' => Provider::all(),
            'departament_costs' => DepartamentCost::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {

        Invoice::create($request->all());

        return \redirect()->route('dashboard.invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $invoice->name . '"'
        ];
        $path = \str_replace('public', 'storage', $invoice->file_path);

        return \response()->file($path, $header);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {

        return  \view('dashboard.financeiro.invoices.edit', [
            'invoice' => $invoice,
            'providers' => Provider::all(),
            'departament_costs' => DepartamentCost::all()

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request)
    {
        $invoice = Invoice::where("uuid", $request->uuid)->first();

        // dd($invoice->departament->slug);
        $invoice->name = "{$request->invoice_type}-{$request->number}-{$invoice->provider->fantasy_name}";
        if ($request->hasFile('file_invoice')) {
            Storage::delete($invoice->file_path);
            $path = "project/{$invoice->project->slug}/cost/{$invoice->cost->slug}/sector/{$invoice->sectorCost->slug}/departament/{$invoice->departament->slug}";
            $path = $request->file('file_invoice')->storeAs("public/files/{$path}", "{$invoice->name}.pdf");
            $invoice->file_path = $path;
        }

        $invoice->update($request->all());

        return \redirect()->route('dashboard.invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Invoice $invoice)
    {
        
        if ($invoice) {
            $invoice->delete();
            Storage::delete($invoice->file_path);

            Session::flash('message', "NF deletada com successo!");
            Session::flash('type', "success");

            return \redirect()->route('dashboard.invoices.index');
        }
        Session::flash('message', "Não foi possível deletar a NF!");
        Session::flash('type', "danger");

        return \redirect()->route('dashboard.invoices.index');
    }
}
