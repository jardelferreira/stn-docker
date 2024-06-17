<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ProjectAPIController extends Controller
{
    public function createInvoices(Request $request)
    {
        // $invoice = Invoice::create($request->all());

        return response()->json([
            'success' => true,
            'message' => "Nota fiscal cadastrada com sucesso.",
            'invoice' => ""
        ]);
    }
    public function getRouteByname($name, $params)
    {
        $params = json_decode($params);
        $array =[];
        foreach ($params as $key => $value) {
            $array[$key] = $value;
        }
        // return response()->json(['params' => $array,'name' => $name]);
        return response()->json(route($name,$array));
    }
}
