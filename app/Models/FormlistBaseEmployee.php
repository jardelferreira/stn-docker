<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormlistBaseEmployee extends Model
{
    use HasFactory;

    protected $table = 'formlist_base_employee';
    protected $fillable = ['id', 'formlist_id', 'base_id', 'employee_id'];
    protected $hidden = ['pivot'];


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

    public function saveEventString($product, $qtd, $type = 0)
    {
        $direction = ['adicionou em', 'deu baixa em','devolveu em'];
        $user = Auth::user();
        $formlist = $this->formlist()->first();
        $now = explode(" ",date("d-m-Y H:m:s"));
        return "{$user->name}, {$direction[$type]} em {$formlist->name} de {$this->employee->user()->first()->name}, {$qtd} - {$product->und}, de {$product->description}, ID-{$product->id}, {$now[0]} as {$now[1]}.";
    }
    
    public function documentsFromFormlist()
    {
        return $this->fields()->join("stok_documents","stok_documents.stok_id","=","fields.stok_id")
        ->join("documents","documents.id","=","stok_documents.document_id")
        ->select("documents.*")->distinct();
        
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'formlist_base_user','user_id','formlist_base_id');
    }

    public function formlistBase()
    {
        return $this->belongsTo(FormlistBase::class,"formlist_id");
    }

    public function formlistAndEmployee()
    {
        return $this->hasMany(Employee::class,'id')->join('formlists','formlists.id','formlist_base_employee.formlist_id');
    }
} 
