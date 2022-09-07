<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'providers';

    protected $fillable = ['corporate_name','fantasy_name','cnpj','headquarters','email','phone_number','address','slug','uuid'];
    // futuramente -> email,fone,address,

    
}
