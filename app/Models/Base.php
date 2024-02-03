<?php

namespace App\Models;

use App\Traits\ProjectTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory, ProjectTrait;

    protected $fillable = ['id','uuid','slug','name','description','place','project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }
    
    public function formlists()
    {
        return $this->belongsToMany(Formlist::class,'formlist_base');
    }
    
    public function employees()
    {
        return $this->belongsToMany(Employee::class,'employee_base','base_id','employee_id');
    }

    public function employeesForLink()
    {
        return Employee::whereNotIn('id',$this->employees()->get()->pluck('id')->toArray());
    }

    public function formlistsByEmlpoyee() {
        return $this->belongsToMany(Formlist::class,'formlist_base_employee')
        ->withPivot(['formlist_base_employee.id as pivot_formlist_id', 'formlist_base_employee.employee_id as employee_id' ]);
    }
} 
