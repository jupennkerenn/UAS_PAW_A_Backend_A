<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::apiResource('/pengiriman_barangs', 
App\Http\Controllers\PengirimanBarangController::class);
Route::apiResource('/laporan_keluhans', 
App\Http\Controllers\LaporanKeluhanController::class);
Route::apiResource('/kurirs', 
App\Http\Controllers\KurirController::class);

Route::group(['middleware'=>'auth:api'],function(){
    Route::post('user/{id}', 'Api\UserController@update');
    Route::get('user/{id}', 'Api\UserController@show');
    Route::post('logout','Api\AuthController@logout');
});