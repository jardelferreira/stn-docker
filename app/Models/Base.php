<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory;

    protected $fillable = ['id','uuid','slug','name','description','place','project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }
}
