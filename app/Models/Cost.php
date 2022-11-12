<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    protected $table = 'cost_centers';

    protected $fillable = ['name','project_id','description','amount','slug','uuid'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sectorsCost()
    {
        return $this->hasMany(sectorsCosts::class);
    }
}
