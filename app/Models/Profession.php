<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory; 

    protected $fillable = ['uuid','slug','name','description','salary','aditional','percent'];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
