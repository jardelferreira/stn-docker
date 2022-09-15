<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory;

    protected $fillable = ['id','uuid','name','description','place','project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
