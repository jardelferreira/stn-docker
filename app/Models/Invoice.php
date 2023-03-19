<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['name','number','provider_id','value','user_id','issue','project_id',
    'cost_sector_id','cost_center_id','due_date','value_departament','file_path','invoice_type','departament_cost_id','slug','uuid'];

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

    public function amountProducts()
    {
        return $this->hasMany(InvoiceProducts::class)
        ->selectRaw('invoice_products.invoice_id,COUNT(invoice_products.id) as count_products, SUM(invoice_products.value_total) as amount_value')
        ->groupBy('invoice_products.invoice_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function cost()
    {
        return $this->belongsTo(Cost::class,"cost_center_id","id");
    }

    public function sectorCost()
    {
        return $this->belongsTo(sectorsCosts::class,"cost_sector_id","id");
    }
    
    public function departament()
    {
        return $this->belongsTo(DepartamentCost::class,"departament_cost_id","id");
    }
    

}
