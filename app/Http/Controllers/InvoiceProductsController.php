<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceProductsRequest;
use App\Http\Requests\UpdateInvoiceProductsRequest;
use App\Models\Invoice;
use App\Models\InvoiceProducts;
use Illuminate\Support\Str;

class InvoiceProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Invoice $invoice)
    {
        return view('dashboard.invoicesProducts.index',[
            'invoice' => $invoice
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Invoice $invoice)
    {
        return view('dashboard.invoicesProducts.create', [
            'invoice' => $invoice
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceProductsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceProductsRequest $request, Invoice $invoice)
    {
        for ($i = 0; $i < $request->cont; $i++) {
            InvoiceProducts::create([
                'uuid' => $this->getNewUuid(),
                'slug' => Str::slug($request->name[$i]),
                'owner' => 1,
                'image_path' => "image",
                'invoice_id' => $invoice->id,
                "qtd" => floatVal($request->qtd[$i]),
                "und" => $request->und[$i],
                "name" => $request->name[$i],
                "value_und" => floatVal($request->value_unid[$i]),
                "value_total" => floatval($request->value_unid[$i]) * floatVal($request->qtd[$i]),
                "description" => $request->description[$i],
                "ca_number" => $request->ca_number[$i],
            ]);
        }

        return redirect()->route('dashboard.invoicesProducts.index',['invoice' => $invoice->id]);
    }

    public function getNewUuid()
    {
        return (string) Str::uuid();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceProducts  $invoiceProducts
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceProducts $invoiceProducts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceProducts  $invoiceProducts
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceProducts $invoiceProducts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceProductsRequest  $request
     * @param  \App\Models\InvoiceProducts  $invoiceProducts
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceProductsRequest $request, InvoiceProducts $invoiceProducts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceProducts  $invoiceProducts
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceProducts $invoiceProducts)
    {
        //
    }
}
