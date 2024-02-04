<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'providers';

    protected $fillable = ['user_id','corporate_name','fantasy_name','cnpj','headquarters','email','phone','address','slug','uuid'];
    // futuramente -> email,fone,address,

    static function filterProvidersFromProjectByNames($query,Sector $sector)
    {
        $sector = Sector::where('id',$sector);
        return $sector;
        return $sector->project->providers()->where([
            ['fantasy_name','LIKE',"%$query%"],
            ['corporate_name','LIKE',"%$query%"]
        ])->get()->toJson();

        return Provider::where([
            ['fantasy_name','LIKE',"%$query%"],
            ['corporate_name','LIKE',"%$query%"]
            ])->get();
    }
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class,'provider_project','provider_id','project_id');
    }

    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['admin','suprimentos'];
        foreach ($permissionRepository->getResources()['supplyments-providers']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }
}
