<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSector extends Model
{
    use HasFactory;

    protected $table = "product_sectors";
    protected $fillable = ['project_id','sector_id','product_id','stok_min','adjustable','id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
