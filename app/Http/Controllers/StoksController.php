<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stoks;
use App\Models\Sector;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Document;
use App\Models\Provider;
use Illuminate\Support\Str;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use App\Models\InvoiceProducts;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreStoksRequest;
use App\Http\Requests\UpdateStoksRequest;
use App\Models\ProductSector;

class StoksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Sector $sector)
    {   
        // dd($sector->products()->get()->toArray());
        // dd($sector->stoks()->with('invoiceProduct')->where('slug','like','%lixadeira%')->get());
        // dd($sector->stoks()->with('invoiceProduct.invoice')->get());
        return view('dashboard.projects.bases.sectors.stoks.index',[
            'sector' => $sector,
            'stoks' => $sector->stoks()->with('invoiceProduct.invoice')->where('qtd','>',0)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Sector $sector)
    {
        // dd($sector->project->providers()->get());
        return view('dashboard.projects.bases.sectors.stoks.create',[
            'sector' => $sector
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStoksRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Sector $sector, StoreStoksRequest $request)
    {
        $result = [];
        $sector = Sector::where('id',$request->sector)->first();

        foreach ($request->products as $key => $product) {
            $invoice_product = InvoiceProducts::where('id',$product['id'])->first();
            //criar controle para evitar inserir quatidade maior que a disponível
            $qtd_remaining = floatVal($invoice_product->qtd_available) - floatval($product['qtd']);
            try {
                $result[$key] = Stoks::create([
                    'uuid' => Str::uuid(),
                    'slug' => $invoice_product->slug,
                    'sector_id' => $sector->id,
                    'base_id' => $sector->base_id,
                    'project_id' => $sector->project_id,
                    'invoice_products_id' => intval($product['id']), 
                    'qtd' => floatval($product['qtd']),
                    'product_id' => $invoice_product->product_id,
                    'image_path' => $invoice_product->image_path,
                    'status' => 'disponível',
                ]);
                StockHistory::saveHistory(0,0,floatval($product['qtd']),"Adicionado pelo sistema",$result[$key]['id']);
            } catch (\Throwable $th) {
                return response()->json($th);
            }
            // Salvar histórico, 0 é entrada e 1 é ficha
            $invoice_product->update(['qtd_available' => $qtd_remaining]);
           
        }
       return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return \Illuminate\Http\Response
     */
    public function show(Stoks $stoks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return \Illuminate\Http\Response
     */
    public function edit(Stoks $stoks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStoksRequest  $request
     * @param  \App\Models\Stoks  $stoks
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoksRequest $request, Stoks $stoks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stoks  $stoks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stoks $stoks)
    {
        //
    }

    public function getProductsByInvoiceId(Sector $sector, Invoice $invoice)
    {
        // dd($invoice);
        return  response()->json($invoice->products()->where('qtd_available','>',0)->get());
    }
    
    public function getAllInvoicesFromProviderByProject(Request $request)
    {
        $provider = Provider::where('id',$request->provider)->first();
        $invoices = $provider->invoices()->where('number','LIKE',"%$request->q%")->get();

        return response()->json($invoices);
    }
    
    public function filterProviders(Request $request,Sector $sector)
    {   
        $providers = $sector->project->providers()->where([
            ['fantasy_name','LIKE',"%$request->q%"],
            ['corporate_name','LIKE',"%$request->q%"]
        ])->get();

        return response()->json($providers);
    }

    public function getProductsFromInvoice(Request $request)
    {
        $invoice = Invoice::where('id',$request->invoice);
        $products = $invoice->products()->get();

        return response()->json($products);

    }

    public function removeFromStock(Sector $sector, Request $request)
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
        $stok = Stoks::where("id",$request->id)->first();
        $qtd = $stok->qtd - floatval($request->qtd);

        if ($qtd < 0) {
            return response()->json([
                'success' => false,
                'type' => 'error',
                'message' => "Quantidade insuficiente no estoque, existem {$stok->qtd} und do produto: {$stok->invoiceProduct->description}",
                'footer' => "Retirada de estoque."
            ]);
        }
        if($stok->update(['qtd' => $qtd])){
            $stok = Stoks::where("id",$request->id)->first();
            // Salvar histórico, 0 é entrada e 1 é ficha
            StockHistory::saveHistory(1,4,floatval($request->qtd),"Adicionado pelo sistema",$request->id);
            return response()->json([
                'success' => true,
                'type' => 'success',
                'message' => "Retirada do estoque com sucesso, Restam {$stok->qtd} und do produto: {$stok->invoiceProduct->description}",
                'footer' => "Retirada de estoque."
            ]);
        };
        return response()->json([
            'success' => false,
            'type' => 'error',
            'message' => "Descupe-nos, ocorreu um erro interno no processo.",
            'footer' => "Retirada de estoque."
        ]);

    }

    public function documents(Sector $sector, Stoks $stok) {

        return view('dashboard.projects.bases.sectors.stoks.documents',[
            "stok" => $stok,
            "documents" => $stok->documents()->get()
        ]);
    }
    public function detachDocument(Sector $sector,Stoks $stok,Document $document)
    {
        $stok->documents()->detach($document->id);
        return redirect()->back()->with('detach',"O Documento foi desvinculado com sucesso!");
    }

    public function products(Sector $sector)
    {   
        dd($sector->products()->get());
        return view('dashboard.projects.bases.sectors.stoks.products',[
            "products" => $sector->products()->get(),
            "sector" => $sector
        ]);
    }

    public function defineStokMin(Sector $sector, Request $request)
    {
        // dd($request->all());
        $product = Product::where("id",$request->product_id)->first();
        // dd($product->stokMinToProduct()->get());
        if ($request->product_sector_id != 0) {
            $product_sector = ProductSector::where("id",$request->product_sector_id)->first();
            $product_sector->update([
                'id' => $request->product_sector_id,
                'product_id' => $product->id,
                'sector_id' => $sector->id,
                'project_id' => $sector->project->id,
                'stok_min' => $request->stok_min,
            ]);
        } else {
            ProductSector::create([
                'product_id' => $product->id,
                'sector_id' => $sector->id,
                'project_id' => $sector->project->id,
                'stok_min' => $request->stok_min,
            ]);
        }
        
        return redirect()->back();
    }
}
