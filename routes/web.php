<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengadaanController;

Route::get('/', function () {
    return view('welcome');
});


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

Route::get('/penerimaan/tambah', [PenerimaanController::class, 'create'])
    ->name('penerimaan.create');

Route::post('/penerimaan/simpan', [PenerimaanController::class, 'penerimaan'])
    ->name('penerimaan.store');

Route::get('/penerimaan/{id}/detail', [PenerimaanController::class, 'penerimaandetailform'])
    ->name('penerimaan.detail');

Route::post('/penerimaan/{id}/detail', [PenerimaanController::class, 'tambahstok'])
    ->name('penerimaan.tambahstok');

Route::get('/penerimaan/cek-stok/{idbarang}', [PenerimaanController::class, 'cekstok']
    )->name('penerimaan.cekstok');

Route::get('/pengadaan/create',
    [PengadaanController::class, 'create']
)->name('pengadaan.create');

Route::post('/pengadaan',
    [PengadaanController::class, 'pengadaan']
)->name('pengadaan.store');

Route::get('/pengadaan/detail/{id}',
    [PengadaanController::class, 'pengadaandetailform']
)->name('pengadaan.detail');

Route::post('/pengadaan/detail/{id}',
    [PengadaanController::class, 'tambahbarang']
)->name('pengadaan.tambahbarang');

Route::delete('/pengadaan/barang/{id}',
    [PengadaanController::class, 'hapusbarang']
)->name('pengadaan.hapusbarang');
