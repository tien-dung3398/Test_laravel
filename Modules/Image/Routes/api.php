<?php

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
    Route::group(['prefix' => 'image'], function () {
        Route::get('', 'ImageController@index');
        Route::get('{id}', 'ImageController@show');
        Route::post('', 'ImageController@store');
        Route::put('{id}', 'ImageController@update');
    });
//});

