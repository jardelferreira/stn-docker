<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormlistBase extends Model
{
    use HasFactory;

    protected $table = 'formlist_base';

    protected $fillable = ['id','formlist_id','base_id'];
    protected $hidden = ['pivot'];

}
