<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biometric extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','template'];

    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function usersAvailable()
    {
       return ;
    }
}
