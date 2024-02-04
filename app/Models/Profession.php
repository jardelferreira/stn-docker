<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profession extends Model
{
    use HasFactory; 

    protected $fillable = ['uuid','slug','name','description','salary','aditional','percent'];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['dp','admin'];
        foreach ($permissionRepository->getResources()['professions']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }
}
