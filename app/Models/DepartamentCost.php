<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DepartamentCost extends Model
{
    use HasFactory;

    protected $table = 'departament_costs';

    protected $fillable = ['name','cost_sector_id','amount'];

    public function sectorCost()
    {
        return $this->belongsTo(sectorsCosts::class,'cost_sector_id','id');
    }
    
}
