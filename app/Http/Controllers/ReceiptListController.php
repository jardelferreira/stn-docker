<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptListRequest;
use App\Http\Requests\UpdateReceiptListRequest;
use App\Models\ReceiptList;

class ReceiptListController extends Controller
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
     * @param  \App\Http\Requests\StoreReceiptListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceiptListRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceiptList  $receiptList
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiptList $receiptList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReceiptList  $receiptList
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiptList $receiptList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReceiptListRequest  $request
     * @param  \App\Models\ReceiptList  $receiptList
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceiptListRequest $request, ReceiptList $receiptList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReceiptList  $receiptList
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceiptList $receiptList)
    {
        //
    }
}
