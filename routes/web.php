<?php

use App\Http\Controllers\CostController;
use App\Http\Controllers\DepartamentCostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SectorsCostsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::prefix('dashboard')->middleware('auth')->group(function(){
    
    Route::prefix('usuarios')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('dashboard.users');
        Route::get('/cadastro', [UserController::class, 'create'])->name('dashboard.users.create');
        Route::get('/{user}', [UserController::class, 'show'])->name('dashboard.users.show');
        Route::get('/{user}/editar', [UserController::class, 'edit'])->name('dashboard.users.edit');
    
        Route::post('/', [UserController::class, 'store'])->name('dashboard.users.store');
    
        Route::delete('/', [UserController::class, 'destroy'])->name('dashboard.users.destroy');
        Route::put('/', [UserController::class, 'update'])->name('dashboard.users.update');

        Route::get('{id}/permissoes',[UserController::class,'permissions'])->name('dashboard.users.permissions');
        Route::put('{user}/permissoes/update',[UserController::class,'permissionsUpdate'])->name('dashboard.users.permissions.update');
        Route::get('{id}/funcoes',[UserController::class,'roles'])->name('dashboard.users.roles');
        Route::put('{user}/funcoes/update',[UserController::class,'rolesUpdate'])->name('dashboard.users.roles.update');
    });

    Route::prefix('permissoes')->group(function(){
        Route::get('/',[PermissionController::class,'index'])->name('dashboard.permissions');
        Route::get('/{id}/editar',[PermissionController::class,'edit'])->name('dashboard.permissions.edit');
        Route::get('/criar',[PermissionController::class,'create'])->name('dashboard.permissions.create');
        Route::get('/{id}',[PermissionController::class,'show'])->name('dashboard.permissions.show');
        Route::get('/{permission}/vincular',[PermissionController::class,'roles'])->name('dashboard.permissions.roles');
        
        Route::put('/{permission}/update',[PermissionController::class,'syncRolesById'])->name('dashboard.permissions.sync');
        Route::put('/',[PermissionController::class,'update'])->name('dashboard.permissions.update');
        Route::post('/',[PermissionController::class,'store'])->name('dashboard.permissions.store');
        Route::delete('/',[PermissionController::class,'destroy'])->name('dashboard.permissions.destroy');
  
    });

    Route::prefix('funcoes')->group(function(){
        Route::get('/',[RoleController::class,'index'])->name('dashboard.roles');
        Route::get('/{id}/editar',[RoleController::class,'edit'])->name('dashboard.roles.edit');
        Route::get('/criar',[RoleController::class,'create'])->name('dashboard.roles.create');
        Route::get('/{role}/funcao',[RoleController::class,'show'])->name('dashboard.roles.show');
        Route::get('/{role}/vincular',[RoleController::class,'permissions'])->name('dashboard.roles.permissions');
        
        
        Route::put('/{role}/update',[RoleController::class,'syncPermissionsById'])->name('dashboard.roles.sync');
        Route::put('/',[RoleController::class,'update'])->name('dashboard.roles.update');
        Route::post('/',[RoleController::class,'store'])->name('dashboard.roles.store');
        Route::delete('/',[RoleController::class,'destroy'])->name('dashboard.roles.destroy');
  
    });

    Route::prefix('projects')->group(function(){
        Route::get('/',[ProjectController::class,'index'])->name('dashboard.projects');
        Route::get('/criar',[ProjectController::class,'create'])->name('dashboard.projects.create');
        Route::get('/{project}',[ProjectController::class,'show'])->name('dashboard.projects.show');
        Route::get('/{project}/editar',[ProjectController::class,'edit'])->name('dashboard.projects.edit');
        
        Route::post('/',[ProjectController::class,'store'])->name('dashboard.projects.store');
        Route::put('/',[ProjectController::class,'update'])->name('dashboard.projects.update');
        Route::delete('/',[ProjectController::class,'destroy'])->name('dashboard.projects.destroy');
    });

    Route::prefix('custos')->group(function(){
        Route::get('/',[CostController::class,'index'])->name('dashboard.costs.index');
        Route::get('/criar',[CostController::class,'create'])->name('dashboard.costs.create');
        Route::get('/{cost}',[CostController::class,'show'])->name('dashboard.costs.show');
        Route::get('/{cost}/editar',[CostController::class,'edit'])->name('dashboard.costs.edit');

        Route::post('/',[CostController::class,'store'])->name('dashboard.costs.store');
        Route::put('/',[CostController::class,'update'])->name('dashboard.costs.update');
        Route::delete('/',[CostController::class,'delete'])->name('dashboard.costs.destroy');
        
    });

    Route::prefix('setordecustos')->group(function(){
        Route::get('/',[SectorsCostsController::class,'index'])->name('dashboard.costs_sectors.index');
        Route::get('/criar',[SectorsCostsController::class,'create'])->name('dashboard.costs_sectors.create');
        Route::get('/{sector}',[SectorsCostsController::class,'show'])->name('dashboard.costs_sectors.show');
        Route::get('/{sector}/editar',[SectorsCostsController::class,'edit'])->name('dashboard.costs_sectors.edit');

        Route::post('/',[SectorsCostsController::class,'store'])->name('dashboard.costs_sectors.store');
        Route::put('/',[SectorsCostsController::class,'update'])->name('dashboard.costs_sectors.update');
        Route::delete('/',[SectorsCostsController::class,'delete'])->name('dashboard.costs_sectors.destroy');
        
    });
    Route::prefix('departamentodecustos')->group(function(){
        Route::get('/',[DepartamentCostController::class,'index'])->name('dashboard.costs_departaments.index');
        Route::get('/criar',[DepartamentCostController::class,'create'])->name('dashboard.costs_departaments.create');
        Route::get('/{departament}',[DepartamentCostController::class,'show'])->name('dashboard.costs_departaments.show');
        Route::get('/{departament}/editar',[DepartamentCostController::class,'edit'])->name('dashboard.costs_departaments.edit');

        Route::post('/',[DepartamentCostController::class,'store'])->name('dashboard.costs_departaments.store');
        Route::put('/',[DepartamentCostController::class,'update'])->name('dashboard.costs_departaments.update');
        Route::delete('/',[DepartamentCostController::class,'destroy'])->name('dashboard.costs_departaments.destroy');
        
    });
    Route::prefix('fornecedores')->group(function(){
        Route::get('/',[ProviderController::class,'index'])->name('dashboard.providers.index');
        Route::get('/criar',[ProviderController::class,'create'])->name('dashboard.providers.create');
        Route::get('/{provider}',[ProviderController::class,'show'])->name('dashboard.providers.show');
        Route::get('/{provider}/editar',[ProviderController::class,'edit'])->name('dashboard.providers.edit');

        Route::post('/',[ProviderController::class,'store'])->name('dashboard.providers.store');
        Route::put('/',[ProviderController::class,'update'])->name('dashboard.providers.update');
        Route::delete('/',[ProviderController::class,'destroy'])->name('dashboard.providers.destroy');
        
    });
    Route::prefix('notas')->group(function(){
        Route::get('/',[InvoiceController::class,'index'])->name('dashboard.invoices.index');
        Route::get('/criar',[InvoiceController::class,'create'])->name('dashboard.invoices.create');
        Route::get('/{invoice}',[InvoiceController::class,'show'])->name('dashboard.invoices.show');
        Route::get('/{invoice}/editar',[InvoiceController::class,'edit'])->name('dashboard.invoices.edit');

        Route::post('/',[InvoiceController::class,'store'])->name('dashboard.invoices.store');
        Route::put('/',[InvoiceController::class,'update'])->name('dashboard.invoices.update');
        Route::delete('/{invoice}',[InvoiceController::class,'destroy'])->name('dashboard.invoices.destroy');
        
    });

});
