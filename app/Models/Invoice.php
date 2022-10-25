<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['name','number','provider_id','value','user_id','issue','project_id',
    'cost_sector_id','cost_center_id','due_date','file_path','invoice_type','departament_cost_id','slug','uuid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function products()
    {
        return $this->hasMany(InvoiceProducts::class);
    }
}
