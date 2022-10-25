<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = ['id','uuid','name','description','base_id','project_id'];

    public function base()
    {
        return $this->belongsTo(Base::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stoks::class,'sector_id','id');
    }
    
}
