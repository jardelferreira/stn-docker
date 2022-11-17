<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid','qtd_required','qtd_delivered',
        'date_delivered','date_returned',
        'signature_delivered','signature_returned',
        'stok_id','ca_first','ca_second','formlist_base_employee_id','observation','add_by'];
}
