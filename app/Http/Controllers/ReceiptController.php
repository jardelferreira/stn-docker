<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Receipt;
use App\Models\ReceiptList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Svg\Tag\Rect;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.financeiro.receipts.index', ['receipts' => Receipt::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(auth()->user()->id);
        if (!$user->hasSignature()) {
            return redirect()->route('dashboard.users.show', [
                'user' => $user
            ])->with(['message' => "O usuário ainda não possui senha para assinar, favor gerar senha, favor Gerar senhar"]);
        }
        return view('dashboard.financeiro.receipts.create', ['branches' => Branch::all()]);
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
        return redirect()->route('dashboard.financeiro.receipts.show', ['receipt' => $receipt]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        // dd($receipt);
        // $receipt->temporary_link = "";
        // $receipt->save();

        if (!$receipt->user->hasSignature()) {
            //redireciona o usuário que não tem assinatura
            return redirect()->route('dashboard.users.show', [
                'user' => $receipt->user
            ])->with(['message' => "O usuário ainda não possui senha para assinar, favor gerar senha, favor Gerar senhar"]);
        }

        return view('dashboard.financeiro.receipts.show', ['receipt' => $receipt]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        return view('dashboard.financeiro.receipts.edit', ['receipt' => $receipt]);
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
        return view('dashboard.financeiro.receipts.createList', ['receipt' => $receipt]);
    }

    public function storeList(Receipt $receipt, Request $request)
    {
       $data = [];
        for ($i = 0; $i < count($request->qtd); $i++) {
            array_push($data, new ReceiptList(['qtd' => $request->qtd[$i], 'description' => $request->description[$i], 'receipt_id' => $receipt->id]));
        }

        $receipt->list()->saveMany($data);

        return redirect()->back();
    }

    public function externAssignShow(Receipt $receipt, Request $request)
    {
        if (!$request->hasValidSignature()) {
            $receipt->temporary_link = "";
            $receipt->save();
            abort(401);
        }
        return view('extern.assign.receipt', [
            'receipt' => $receipt
        ]);
    }

    public function externAssign(Receipt $receipt, Request $request)
    {
       
        $signature = $receipt->signature()->create([
            'uuid' => Str::uuid(),
            'user_id' => $receipt->user->id,
            'signature' => $receipt->user->signature()->signature,
            'event' => $receipt->saveEventString(),
            'signature_image' => $request->dataUrl,
        ]);
        $receipt->signature_id = $signature->id;
        
        return response()->json(['receipt' => $receipt]);
    }

    public function assignWithDocument(Receipt $receipt, Request $request)
    {
        $signature = $receipt->signature()->create([
            'uuid' => Str::uuid(),
            'user_id' => Auth::user()->id,
            'signature' => $receipt->user->signature()->signature,
            'event' => $receipt->saveEventString(now())
        ]);
    }

    public function preAssignDigial(Receipt $receipt, Request $request)
    {
    }

    public function externReceiptShow(Receipt $receipt, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        // dd(URL::signedRoute('extern.externShow',['receipt' => $receipt->id]));
        return view('extern.receipt', ['receipt' => $receipt]);
    }

    public function genTemporaryLink(Receipt $receipt, Request $request)
    {
        $to_time = strtotime($request->datetime);
        $now_time = strtotime(now());
        $gap = $to_time - $now_time;
        $time = round(strtotime($request->datetime) - strtotime(now())) / 60;
        if (round(($time)) < 60 || $to_time < $now_time) {
            return response()->json(['minutos' => round(($time)), 'tempo menor que o esperado']);
        }

        $receipt->temporary_link = URL::temporarySignedRoute('extern.externAssignShow', now()->addMinutes($time), ['receipt' => $receipt->id]);

        $receipt->save();

        return response()->json(['receipt' => $receipt]);
    }

    public function genPublicLink(Receipt $receipt)
    {
        $receipt->link = URL::signedRoute('extern.receiptShow', ['receipt' => $receipt->id]);
        $receipt->save();

        return redirect()->back();
    }
}
