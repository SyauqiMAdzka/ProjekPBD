<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReadViewController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('roles', RoleController::class);
Route::get('/', [ReadViewController::class, 'dashboard'])->name('dashboard');
Route::get('/data/{dataset}', [ReadViewController::class, 'index'])
    ->whereIn('dataset', ['role', 'satuan', 'vendor', 'user', 'barang', 'margin'])
    ->name('data.index');
