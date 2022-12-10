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

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_project');
    }

    public function professions()
    {
        return $this->belongsToMany(Profession::class,'profession_project');
    }

    public function bases()
    {
        return $this->hasMany(Base::class);
    }

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }
}
