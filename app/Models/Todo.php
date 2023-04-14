<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['performer','requester','task','description','priority','start_date','end_date','project_id'];

    private $enum = [
        'urgent' => ['color' => 'danger', 'pt-br' => "Urgente"],
        'high' => ['color' => 'warning', 'pt-br' => 'Alta'],
        'medium' => ['color' => 'info', 'pt-br' => 'Média'],
        'normal' => ['color' => 'info', 'pt-br' => "Normal"],
        'low' => ['color' => 'success', 'pt-br' => 'Baixa']
    ];

    public function getEnum()
    {
        return $this->enum;
    }
}
