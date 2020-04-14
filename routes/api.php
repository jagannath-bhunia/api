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
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('logout', ['as' => 'admin.logout', 'uses' => 'API\UserController@logout']); 

Route::post('details', 'API\UserController@details');
Route::post('productinsert', 'API\ProductController@productinsert');
Route::post('productupdate', 'API\ProductController@productupdate');

Route::post('productdelete', 'API\ProductController@productdelete');
Route::post('productshow', 'API\ProductController@productshow');


// Route::get('show', ['as' => 'show','uses' => 'API\UserController@showbyid']);
// Route::post('insert', ['as' => 'insert','uses' => 'API\UserController@insert']);
// Route::post('update', ['as' => 'update','uses' => 'API\UserController@update']);
// Route::post('delete', ['as' => 'delete','uses' => 'API\UserController@delete']);

});