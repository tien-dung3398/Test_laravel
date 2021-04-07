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

use Illuminate\Support\Facades\Route;

//Route::group(['middleware' => ['auth:api']], function () {
Route::group(['prefix' => 'category'], function () {
    Route::get('', 'CategoryController@index');
    Route::get('/{id}/attributes/{attribute_id}','CategoryController@destroyAttributes');
    Route::get('/un-attributes','CategoryController@getAttributes');
    Route::get('/{id}/attributes','CategoryController@setAttributes');
    Route::get('/{id}/list-attributes', 'CategoryController@listAttributes');
    Route::post('', 'CategoryController@store');
    Route::put('{id}', 'CategoryController@update');
    Route::delete('{id}', 'CategoryController@destroy');
});
//});
