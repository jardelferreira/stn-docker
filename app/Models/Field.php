<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'qtd_required', 'qtd_delivered','visible',
        'date_delivered', 'date_returned',
        'signature_delivered', 'signature_returned', 'employee_id',
        'stok_id', 'ca_first', 'ca_second', 'formlist_base_employee_id', 'observation', 'user_id'
    ];


    public function stoks()
    {
        return $this->belongsTo(Stoks::class,'stok_id','id');
    }

public function parseComplementToJson()
    {
        $json = json_decode($this->complements);
        $array = [];
        foreach ($json as $key => $atribute) {
            if ($atribute->parameter == "historico_alteracoes") {
                $atribute->value = json_encode(explode("\n", $atribute->value));
                $array = array_merge($array, [$atribute->parameter => json_decode($atribute->value)]);
            } else {
                $array = array_merge($array, [$atribute->parameter => $atribute->value]);
            }
        }
        $json = json_encode($array);
        return json_decode($json);
    }
}
