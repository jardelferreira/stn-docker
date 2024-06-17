<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreInvoiceAPIRequest;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;

class InvoiceAPIController extends Controller
{
    public function createInvoice(StoreInvoiceAPIRequest $request)
    {
        $invoice = Invoice::create($request->all());
        // $invoice = Invoice::first();
        return response()->json([
            'success' => true,
            'message' => "Nota fiscal cadastrada com sucesso.",
            'invoice' => $invoice,
            'invoice_route' => route('api.projects.invoiceProducts.store',$invoice)
        ]);
    }

    public function listInvoices(Project $project)
    {
        // dd($project);
        return response()->json([
            'data' => $project->invoices()->get()
        ]);
    }

    public function listProducts(Invoice $invoice)
    {
        return response()->json([
            'invoice' => $invoice,
            'products' => $invoice->products()->get()
        ]);
    }
}
