<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use App\Models\Branch;
use App\Models\Receipt;
use App\Models\ReceiptList;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.financeiro.receipts.index',['receipts' => Receipt::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.financeiro.receipts.create',['branches' => Branch::all()]);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReceiptRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceiptRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $receipt  = Receipt::create($data);
        return redirect()->route('dashboard.financeiro.receipts.show',['receipt' => $receipt]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        // dd($receipt->list()->toSql(),ReceiptList::all());
        return view('dashboard.financeiro.receipts.show',['receipt' => $receipt]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        return view('dashboard.financeiro.receipts.edit',['receipt' => $receipt]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReceiptRequest  $request
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceiptRequest $request, Receipt $receipt)
    {
        $receipt->update($request->all());
        return redirect()->route('dashboard.financeiro.receipts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        $receipt->delete();

        return redirect()->route('dashboard.financeiro.receipts');
    }

    public function createList(Receipt $receipt)
    {
        return view('dashboard.financeiro.receipts.createList',['receipt' => $receipt]);

    }

    public function storeList(Receipt $receipt,Request $request)
    {
        $data = [];
        for ($i=0; $i < count($request->qtd); $i++) { 
            array_push($data, new ReceiptList(['qtd' => $request->qtd[$i],'description' => $request->description[$i], 'receipt_id' => $receipt->id]));
        }
        
        $receipt->list()->saveMany($data);

        return redirect()->back();
    }
}
