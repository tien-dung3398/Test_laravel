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
    Route::group(['prefix' => 'attribute'], function () {
        Route::get('', 'AttributeController@index');
        Route::get('{id}', 'AttributeController@show');
        Route::post('', 'AttributeController@store');
        Route::put('{id}', 'AttributeController@update');
    });
//});

