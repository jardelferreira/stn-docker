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


    public function users()
    {
        // dd($this->formlist_id);
        return $this->belongsToMany(User::class,'formlist_base_user');
        return User::leftJoin('formlist_base_user',"users.id","formlist_base_user.user_id")->where("formlist_base_user.formlist_base_id",$this->id);
    }
}
