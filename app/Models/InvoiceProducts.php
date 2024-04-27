<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','slug','name','description','product_id','qtd','qtd_available', 'und','value_und','value_total','invoice_id','owner','image_path','ca_number'];

    public function invoice()
    {
        return $this->hasOne(Invoice::class,'id','invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function provider()
    {
        return $this->hasOneThrough(Provider::class, Invoice::class,"id","id","invoice_id","provider_id");
    }
}
