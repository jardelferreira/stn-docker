<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'providers';

    protected $fillable = ['corporate_name','fantasy_name','cnpj','headquarters','email','phone','address','slug','uuid'];
    // futuramente -> email,fone,address,

    static function filterProvidersByNames($query)
    {
        return Provider::where([
            ['fantasy_name','LIKE',"%$query%"],
            ['corporate_name','LIKE',"%$query%"]
            ])->get();
    }
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
