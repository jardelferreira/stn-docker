<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortcut extends Model
{
    use HasFactory;

    protected $fillable = ['shortcut','route_name','atributes','name','url','active'];

    public function shortcutable()
    {
        return $this->morphTo();
    }
    
}
