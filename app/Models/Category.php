<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['admin','suprimentos'];
        foreach ($permissionRepository->getResources()['supplyments-categories']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }
}
