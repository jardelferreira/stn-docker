<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function stoks() {
        return $this->hasMany(Stoks::class);
    }

    public function invoiceProduct()
    {
        return $this->hasOne(InvoiceProducts::class);
    }

    public function stoksWithDetails() {
        return $this->hasManyThrough(Stoks::class,InvoiceProducts::class)->with('invoiceProduct');
    }

    public static function resourcesModel():array
    {
        $permissionRepository = new PermissionRepository();
        $permissions = ['admin','suprimentos'];
        foreach ($permissionRepository->getResources()['supplyments-products']['permissions'] as $value) {
            array_push($permissions,$value['slug']);
        };
        // dd($permissions);
        return $permissions;
    }

    public function stokMin()
    {
        return $this->belongsToMany(Product::class,'product_sectors')->selectRaw("product_sectors.stok_min");
    }
}
