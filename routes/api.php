<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\GanttController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\API\InvoiceAPIController;
use App\Http\Controllers\API\ProjectAPIController;
use App\Http\Controllers\API\InvoiceProductsAPIController;
use App\Http\Controllers\FormlistController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/data',[GanttController::class,'get'])->name('api.gantt.data');
Route::resource('task',TaskController::class);
Route::resource('link', LinkController::class);

Route::get('products',[ProductController::class,'get'])->name('api.products.get');
Route::get('providers',[ProviderController::class,'get'])->name('api.providers.get');

Route::prefix("dashboard")->group(function(){
    Route::post('download-formlists',[FormlistController::class,'generateAndDownloadZip'])
    ->middleware('auth:sanctum')->name('api.dashboard.downloadManyFormlistsPdf');

    Route::get('routes/{name}/{params?}',[ProjectAPIController::class,'getRouteByName'])->name('api.dashboard.getRouteByName');
    Route::prefix('projects')->group(function(){
        Route::post('createInvoices',[InvoiceAPIController::class,'createInvoice'])->name('api.projects.createInvoices');
        Route::post('invoice/popular/{invoice}', [InvoiceProductsAPIController::class, 'store'])->name('api.projects.invoiceProducts.store');
        Route::post('invoiceProducts/validate', [InvoiceProductsAPIController::class, 'validateProducts'])->name('api.projects.invoiceProducts.validateProducts');
        Route::get('products',[ProductController::class,'get'])->name('api.products.products.get');
        Route::get('invoice/{invoice}/products',[InvoiceAPIController::class,'listProducts'])->name('api.projects.invoice.products');
        Route::get('{project}/invoices',[InvoiceAPIController::class,'listInvoices'])->name('api.products.invoices');

    });
});