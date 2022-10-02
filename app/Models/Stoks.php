<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stoks extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','slug','sector_id','base_id','project_id','invoice_products_id','qtd','status','image_path'];
    
}
