<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stoks extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','slug','sector_id','base_id','product_id',
    'project_id','invoice_products_id','qtd','status','image_path','user_id'];
    
    public function invoiceProduct()
    {
        return $this->hasOne(InvoiceProducts::class,'id','invoice_products_id');
    }
     
    public function sector()
    {
        return $this->hasOne(Sector::class);
    }

    public function parentOfProduct() {
        // return $this->hasOneThrough(Product::class,invoiceProducts::class);
        // return $this->belongsTo(Product::class,'product_id');
    }
}
