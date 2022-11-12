<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','slug','profession_id','user_id','registration','cpf','admission','signature'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profession()
    {
        return  $this->belongsTo(Profession::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class,'employee_project');
    }

    public function signatures()
    {
        return $this->morphMany(Signature::class,'signaturable');
    }
}
