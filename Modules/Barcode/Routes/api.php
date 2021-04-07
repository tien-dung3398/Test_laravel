<?php

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

//Route::group(['middleware' => ['auth:api']], function () {
Route::group(['prefix' => 'barcode'], function () {
    Route::get('', 'BarcodeController@index');
    Route::get('/search', 'BarcodeController@searchBarcodes');
    Route::get('/set-barcode', 'BarcodeController@setBarcodes');
    Route::get('{id}', 'BarcodeController@show');
    Route::post('', 'BarcodeController@store');
    Route::put('{id}', 'BarcodeController@update');
//    });
});

