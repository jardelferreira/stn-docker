<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formlist extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','name','initials','revision','area','base_id'];
}
