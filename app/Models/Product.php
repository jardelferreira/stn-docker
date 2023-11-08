<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function stoksWithDetails() {
        return $this->hasManyThrough(Stoks::class,InvoiceProducts::class)->with('invoiceProduct');
    }
}
