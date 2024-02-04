<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\PermissionRepository;
use App\Traits\ProjectTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cost extends Model
{
    use HasFactory,ProjectTrait;

    protected $table = 'cost_centers';

    protected $fillable = ['name','project_id','description','amount','slug','uuid'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sectorsCost()
    {
        return $this->hasMany(sectorsCosts::class);
    }

     public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['admin','financeiro','suprimentos'];
        foreach ($permissionRepository->getResources()['supplyments']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }
}
