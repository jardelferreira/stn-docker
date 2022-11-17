<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Formlist extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','name','revision','area','description'];

    public function bases()
    {
        return $this->belongsToMany(Base::class,'formlist_base');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class,'formlist_employee');
    }

    public function ownerBase()
    {
        return $this->hasOneThrough(Base::class,FormlistBase::class);
    }

    public function formlistBase()
    {
        return $this->belongsToMany(Formlist::class,'formlist_base','base_id','formlist_id');
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class,'formlist_base_employee');
    }
}
