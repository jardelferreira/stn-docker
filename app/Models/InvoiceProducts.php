<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','name','description','qtd','und','value_unid','value_total','invoice_id','owner','image_path'];

    
}
