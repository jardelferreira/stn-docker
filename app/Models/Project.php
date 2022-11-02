<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description','initials','uuid'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class,'provider_project');
    }
}
