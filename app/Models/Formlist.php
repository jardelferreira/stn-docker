<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Formlist extends Model
{
    use HasFactory;

    protected $fillable = ['id','uuid','name','revision','area','description','base_id'];
    protected $hidden = ['pivot'];

    public function bases()
    {
        return $this->belongsToMany(Base::class,'formlist_base');
    }

    public function base()
    {
        return $this->belongsTo(Base::class);
    }
    public function employees()
    {
        return $this->belongsToMany(Employee::class,'formlist_employee');
    }

    public function ownerBase()
    {
        return $this->hasOneThrough(Base::class,FormlistBaseEmployee::class,'formlist_id','id','id','base_id');
    }

    public function formlistBase()
    {
        return $this->belongsToMany(Formlist::class,'formlist_base','base_id','formlist_id');
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class,'formlist_base_employee');
    }

    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['admin'];
        foreach ($permissionRepository->getResources()['formlists']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }
}
