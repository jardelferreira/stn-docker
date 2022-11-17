<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','user_id','event','signature','signaturable_id','signaturable_type'];

    public function signaturable()
    {
        return $this->morphTo();
    }
}
