<?php

use App\Http\Controllers\GanttController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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