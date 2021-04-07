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
Route::group(['prefix' => 'asset'], function () {
    Route::get('', 'AssetController@index');
    Route::get('/delete/{id}', 'AssetController@destroy');
    Route::get('{id}', 'AssetController@show');
    Route::post('', 'AssetController@store');
    Route::put('{id}', 'AssetController@update');
//    });
});

