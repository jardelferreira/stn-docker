<?php

namespace App\Http\Controllers\API;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InvoiceProducts;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreInvoiceProductsAPIRequest;
use App\Http\Requests\StoreInvoiceProductsRequest;

class InvoiceProductsAPIController extends Controller
{
    public function store(Invoice $invoice, StoreInvoiceProductsRequest $request)
    {
        $invoice_products = [];
        // return response()->json($request->all());
        foreach ($request->data as $product) {
            array_push($invoice_products, [
                'uuid' => Str::uuid(),
                'slug' => Str::slug($product['name']),
                'owner' => 1,
                'image_path' => "image",
                'invoice_id' => $invoice->id,
                "qtd" => floatVal($product['qtd']),
                "qtd_available" => floatVal($product['qtd']),
                "und" => $product['und'],
                "name" => $product['name'],
                "value_und" => floatVal($product['value_unid']),
                "value_total" => floatval($product['value_unid']) * floatVal($product['qtd']),
                "description" => $product['description'],
                "ca_number" => $product['ca_number'],
                "product_id" => $product['product_id'],
            ]);
        }
        $invoice_products = InvoiceProducts::insert($invoice_products);
        return response()->json([
            'success' => true,
            'type' => 'success',
            'message' => 'Produtos cadastrados com sucesso.',
            'footer' => "Cadastro de produdo em nota."
        ]);
    }

    public function validateProducts(StoreInvoiceProductsAPIRequest $request)
    {
        return response()->json(['success' => true, 'message' => 'produto validado']);
    }

    public function InvoiceProducts(Invoice $invoice)
    {
        return response()->json(['data' => $invoice->products()->get()]);
    }
}
