<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','slug','profession_id','user_id','registration','cpf','adminssion'];

    public function user()
    {
        return ;
    }
}
