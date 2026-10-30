<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReadViewController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('roles', RoleController::class);



Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::get('/{menu}', [CrudController::class, 'index'])
    ->where('menu', 'role|satuan|vendor|user|barang|margin')
    ->name('crud.index');

Route::get('/{menu}/create', [CrudController::class, 'create'])
    ->where('menu', 'role|satuan|vendor|user|barang|margin')
    ->name('crud.create');

Route::post('/{menu}', [CrudController::class, 'store'])
    ->where('menu', 'role|satuan|vendor|user|barang|margin')
    ->name('crud.store');

Route::get('/{menu}/{id}/edit', [CrudController::class, 'edit'])
    ->where('menu', 'role|satuan|vendor|user|barang|margin')
    ->name('crud.edit');

Route::put('/{menu}/{id}', [CrudController::class, 'update'])
    ->where('menu', 'role|satuan|vendor|user|barang|margin')
    ->name('crud.update');

Route::delete('/{menu}/{id}', [CrudController::class, 'destroy'])
    ->where('menu', 'role|satuan|vendor|user|barang|margin')
    ->name('crud.destroy');


