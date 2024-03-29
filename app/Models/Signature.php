<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','user_id','event','signature','signaturable_id','signaturable_type','signature_image','location'];

    public function signaturable()
    {
        return $this->morphTo();
    }

    static function generateSignature()
    {
        
    }

    public function autoEvent(User $user = null, $event = '')
    {
        $date = date_create(now())->format("d-m-Y H:i:s");
        if ($user) {
            return "Assinatura genérica gerada em: {$date}, pelo usuário: {$user->name} - '";
        }
        return "Assinatura genérica gerada em: {$date}";

    }

    public function setLocation($lat,$lng)
    {
        
    }

    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }
}
