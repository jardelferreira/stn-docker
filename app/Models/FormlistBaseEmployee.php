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
        $direction = ['adiciona', 'devolve','baixa'];
        $user = Auth::user();
        $formlist = $this->formlist()->first();
        return "{$user->name} {$direction[$type]} em {$formlist->name} de {$this->employee->user()->first()->name}, {$qtd} {$product->und} de {$product->name}";
    }
    
    public function documentsFromFormlist()
    {
        return $this->fields()->join("stok_documents","stok_documents.stok_id","=","fields.stok_id")
        ->join("documents","documents.id","=","stok_documents.document_id")
        ->select("documents.*");
        
    }
}
