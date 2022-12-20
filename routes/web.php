<?php

use Illuminate\Support\Facades\Route;

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
    return view('dashboard');
});

//Route Resource
Route::resource('/pengiriman_barang', 
\App\Http\Controllers\PengirimanBarangController::class);
Route::resource('/laporan_keluhan', 
\App\Http\Controllers\LaporanKeluhanController::class);
Route::resource('/kurir', 
\App\Http\Controllers\KurirController::class);