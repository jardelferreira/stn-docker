<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FormlistBaseEmployee extends Model
{
    use HasFactory;

    protected $table = 'formlist_base_employee';
    protected $fillable = ['id','formlist_id','base_id','employee_id'];

    public function formlist()
    {
        return $this->belongsTo(Formlist::class);
      
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function base()
    {
        return $this->belongsTo(Base::class);
    }

}
