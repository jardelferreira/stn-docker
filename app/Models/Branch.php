<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;
    
    protected $fillable = ['nome','cnpj','cep','uf','bairro','logradouro','numero','cidade','complemento'];


    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['filial','admin'];
        foreach ($permissionRepository->getResources()['branchs']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }

}
