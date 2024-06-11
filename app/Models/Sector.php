<?php

namespace App\Models;

use App\Traits\ProjectTrait;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sector extends Model
{
    use HasFactory,ProjectTrait;

    protected $fillable = ['id','uuid','name','description','base_id','project_id'];

    public function base()
    {
        return $this->hasOne(Base::class,'id','base_id');
    }

    public function project() 
    {
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function stoks()
    {
        return $this->hasMany(Stoks::class,'sector_id','id');
    }

    public function stoksWithoutDocument($document_id){
        $document = Document::find($document_id);
        return $this->stoks()->whereNotIn('id',$document->stoks()->pluck('document_id'));
    }
    
    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['admin'];
        foreach ($permissionRepository->getResources()['sectors']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class,Stoks::class,'sector_id','id',"id","product_id")
        ->selectRaw("SUM(stoks.qtd) as qtd_total,products.name,products.id,sector_id")
        ->groupBy(['products.id','sector_id']);
        // ->groupBy('sector_id');
    }
    
}
