<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    protected $table = "stock_histories";

    protected $fillable = ['type','reason','qtd','event','stock_name','sector_name','base_name',
    'project_name','project_initials','product_name','invoice_product_name','provider_name','user_name',
    'stock_id','sector_id','base_id','project_id','invoice_product_id','provider_id','user_id','product_id'];

    public static function enumTypes()
    {
        // 0 para entradas  e 1 para saídas, 
        return new Collection([
            ["name" => "entrada", "reasons" =>  ['compras','fichas','devolução','transferência','ajuste','fabricação']],
             ["name" => "saida" , "reasons" => ['venda','fichas','devolução','transferência','ajuste','perda','roubo','consumo','condenado']]
        ]);
    }

    public static function saveHistory(int $type,int $reason,float $qtd,string $event = null, int $stock_id)
    {
        $stock = Stoks::where('id',$stock_id)->with(['sector','base','project','invoiceProduct.provider','product'])->first();
        $enum = StockHistory::enumTypes();
        
        $history = StockHistory::create([
            'type' => $enum[$type]['name'],
            'reason' => $enum[$type]['reasons'][$reason],
            'qtd' => $qtd,
            'event' => $event ?? "não informado",
            'stock_name' => $stock->slug,
            'sector_name' => $stock->sector->name,
            'base_name' => $stock->base->name,
            'project_name' => $stock->project->name,
            'project_initials' => $stock->project->initials,
            'product_name' => $stock->product->name,
            'product_id' => $stock->product->id,
            'invoice_product_name' => $stock->invoiceProduct->name,
            'provider_name' => $stock->invoiceProduct->provider->fantasy_name,
            'user_name' => auth()->user()->name,
            'stock_id' => $stock->id,
            'sector_id' => $stock->sector_id,
            'base_id' => $stock->base_id,
            'project_id' => $stock->project_id,
            'invoice_product_id' => $stock->invoice_products_id,
            'provider_id' => $stock->invoiceProduct->provider->id,
            'user_id' => auth()->user()->id
        ]);
    }
}
