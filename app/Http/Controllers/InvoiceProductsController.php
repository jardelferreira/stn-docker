<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceProductsRequest;
use App\Http\Requests\UpdateInvoiceProductsRequest;
use App\Models\InvoiceProducts;

class InvoiceProductsController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceProductsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceProductsRequest $request)
    {
        //
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
