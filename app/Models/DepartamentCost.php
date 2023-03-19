<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DepartamentCost extends Model
{
    use HasFactory;

    protected $table = 'departament_costs';

    protected $fillable = ['name', 'cost_sector_id', 'amount', 'slug', 'description', 'uuid', 'cost_center_id', 'project_id'];

    public function sectorCost()
    {
        return $this->belongsTo(sectorsCosts::class, 'cost_sector_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function sumInvoiceValues()
    {
        return $this->hasMany(Invoice::class)
        ->selectRaw('invoices.departament_cost_id,SUM(invoices.value) as amount_invoices, COUNT(invoices.id) as count_invoices')
        ->groupBy('invoices.departament_cost_id');
    }
}
