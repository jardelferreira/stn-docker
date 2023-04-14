<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoProgress extends Model
{
    use HasFactory;

    protected $fillable = ['status','description','last_progress','todo_id'];

    private $enum = 
    ['created-light' => 'Criado',
    'finished-success' => 'Finalizado',
    'running-primary' => 'Em Andamento',
    'pending-warning' => 'Pendente',
    'stopped-danger' => 'Parado',
    'cancelled-secondary' => 'Cancelado'];

    public function getEnum()
    {
        return $this->enum;
    } 
}
