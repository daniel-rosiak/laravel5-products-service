<?php

use Illuminate\Http\Request;

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
//Route::apiResource('products', 'Api\ProductController');

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::post('/logout', 'Api\AuthController@logout');

Route::get('products', 'Api\ProductController@index');
Route::get('products/{product}', 'Api\ProductController@show');

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::post('products', 'Api\ProductController@store');
});

Route::fallback(function(){
    return response()->json(['error' => 'Not Found!'], 404);
});