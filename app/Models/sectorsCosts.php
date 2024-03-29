<?php

namespace App\Models;

use App\Traits\ProjectTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sectorsCosts extends Model
{
    use HasFactory,ProjectTrait;
 
    protected $table = 'cost_sectors';

    protected $fillable = ['name','amount','cost_center_id','description','slug','project_id','uuid'];

    public function cost()
    {
        return $this->belongsTo(Cost::class,'cost_center_id','id');
    }

    public function departamentsCost()
    {
        return $this->hasMany(DepartamentCost::class);
    }
}
