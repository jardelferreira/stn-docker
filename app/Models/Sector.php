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
        return $this->hasOne(Base::class,'id','base_id');
    }

    public function project() 
    {
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function stoks()
    {
        return $this->hasMany(Stoks::class,'sector_id','id');
    }
    
}
