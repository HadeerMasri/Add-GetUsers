<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get ( '/', 'MainController@create' );
Route::post ( '/vueitems', 'MainController@storeItem' );
Route::get ( '/vueitems', 'MainController@readItems' );
Route::get ( '/users/show', 'MainController@show' );
Route::post ( '/users/show/{id}', 'MainController@deleteItem' );