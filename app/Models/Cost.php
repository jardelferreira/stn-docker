<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    protected $table = 'cost_centers';

    protected $fillable = ['name','project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
