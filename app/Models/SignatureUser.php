<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','signature_id','signature'];

    protected $table = "signature_user";
}
