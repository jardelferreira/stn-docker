<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','slug','profession_id','user_id','registration','cpf','admission','id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profession()
    {
        return  $this->belongsTo(Profession::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class,'employee_project');
    }

    public function bases()
    {
        return $this->belongsToMany(Base::class,'employee_base');
    }

    // public function signatures()
    // {
    //     return $this->morphMany(Signature::class,'signaturable');
    // }

    public function formlistsByBase(int $base_id)
    {
        return $this->belongsToMany(Formlist::class,'formlist_base_employee')->wherePivot('base_id','=',$base_id)->withPivot('id');
        // return $this->hasManyThrough(
        //     Formlist::class,
        //     FormlistBaseEmployee::class,
        //     'employee_id', // Foreign key on FormlistBaseEmployee table
        //     'id', // Foreign key on Formlist table
        //     'id', // Local key on Employee table
        //     'formlist_base_id', // Local key on FormlistBaseEmployee table
        // );
    }

    public function formlists()
    {
        return $this->belongsToMany(Formlist::class,'formlist_base_employee')->withPivot(['id','base_id']);
    }

    public function formlistsFromEmployee()
    {
        return $this->hasMany(FormlistBaseEmployee::class);
    }

    public function signatures()
    {
        return $this->morphOne(Signature::class,'signaturable');
    }

    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['admin','acl'];
        foreach ($permissionRepository->getResources()['employees']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }
}
