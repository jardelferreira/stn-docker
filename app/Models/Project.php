<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description','initials','uuid'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function amountInvoicesByProject()
    {
        $object = $this->hasMany(Invoice::class)
        ->selectRaw('invoices.project_id, SUM(invoices.value) as amount_project, COUNT(invoices.project_id) as count_invoices')
        ->groupBy('invoices.project_id');

        return $object->count() ? $object->first() : [];
        
    }

    public function amountProductsByProject()
    {
         $this->hasManyThrough(InvoiceProducts::class,Invoice::class)
        ->selectRaw('invoices.project_id, COUNT(invoice_products.id) as count_products, SUM(invoice_products.qtd) as amount_products')
        ->groupBy('invoices.project_id')
        ->first();
    }
    
    public function amountFormlists()
    {
        return $this->hasManyThrough(FormlistBaseEmployee::class,Base::class)
        ->selectRaw('bases.project_id, COUNT(formlist_base_employee.base_id) as count_formlists')
        ->groupBy('bases.project_id')
        ->first();
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class,'provider_project');
    }

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }

    public function departamentCosts()
    {
        return $this->hasMany(DepartamentCost::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_project');
    }

    public function employeesOnBases()
    {
        return $this->hasManyThrough(Employees_Base::class,Base::class);
    }

    public function employeesForLink()
    {
        return Employee::whereNotIn('id',$this->employees()->get()->pluck('id')->toArray());
    }
    public function professions()
    {
        return $this->belongsToMany(Profession::class,'profession_project');
    }

    public function bases()
    {
        return $this->hasMany(Base::class);
    }

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }

    static function getProjectByUuid($uuid)
    {
        return Project::where("uuid",$uuid);
    }
}
