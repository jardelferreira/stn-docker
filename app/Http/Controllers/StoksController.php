<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoksRequest;
use App\Http\Requests\UpdateStoksRequest;
use App\Models\Invoice;
use App\Models\InvoiceProducts;
use App\Models\Provider;
use App\Models\Sector;
use App\Models\Stoks;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Sector $sector)
    {   
        // dd($sector->stoks()->with('invoiceProduct.invoice')->get());
        return view('dashboard.projects.bases.sectors.stoks.index',[
            'sector' => $sector,
            'stoks' => $sector->stoks()->with('invoiceProduct.invoice')->get(),
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
    public function store(StoreStoksRequest $request)
    {
        $result = [];
        $sector = Sector::where('id',$request->sector)->first();

        foreach ($request->products as $key => $product) {
            $invoice_product = InvoiceProducts::where('id',$product['id'])->first();
            try {
               $result[$key] = Stoks::create([
                    'uuid' => Str::uuid(),
                    'slug' => $invoice_product->slug,
                    'sector_id' => $sector->id,
                    'base_id' => $sector->base_id,
                    'project_id' => $sector->project_id,
                    'invoice_products_id' => intval($product['id']),
                    'qtd' => floatval($product['qtd']),
                    'image_path' => $invoice_product->image_path,
                    'status' => 'disponível',
                ]);
            } catch (\Throwable $th) {
                return response()->json($th);
            }
           
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

    public function getProductsByInvoiceId(Invoice $invoice)
    {
        return  response()->json($invoice->products()->get());
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
    
}
