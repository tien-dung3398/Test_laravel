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
Route::group(['prefix' => 'auth'], function () {
    Route::get('register', 'UserController@register');
});
//});


