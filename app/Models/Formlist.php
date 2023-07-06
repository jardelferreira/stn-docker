<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Formlist extends Model
{
    use HasFactory;

    protected $fillable = ['id','uuid','name','revision','area','description','base_id'];
    protected $hidden = ['pivot'];

    public function bases()
    {
        return $this->belongsToMany(Base::class,'formlist_base');
    }

    public function base()
    {
        return $this->belongsTo(Base::class);
    }
    public function employees()
    {
        return $this->belongsToMany(Employee::class,'formlist_employee');
    }

    public function ownerBase()
    {
        return $this->hasOneThrough(Base::class,FormlistBaseEmployee::class,'formlist_id','id','id','base_id');
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
