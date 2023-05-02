<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','branch_id','signature_id','favored','value','local','register'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function list()
    {
        return $this->hasMany(ReceiptList::class);
    }

    public function signature()
    {
        return $this->morphOne(Signature::class, 'signaturable');
    }
    
    public function saveEventString()
    {
        $date = date_create(now())->format("d-m-Y H:i:s");
        return "Recibo gerado por {$this->user->name}, em {$this->created_at}, no valor de R$ {$this->value} para o favorecido: {$this->favored}, Nº do documento: {$this->register} - assinado digitalmente em: {$date}";
    }
}
