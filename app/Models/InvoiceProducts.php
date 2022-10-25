<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','slug','name','description','qtd','und','value_und','value_total','invoice_id','owner','image_path'];

    public function invoice()
    {
        return $this->hasOne(Invoice::class,'id','invoice_id');
    }
}
