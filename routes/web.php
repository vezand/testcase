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



Route::resource('/', 'DocumentsController');


Route::post('saveDocument', 'DocumentsController@saveDocument');
Route::post('getDocument/{id}', 'DocumentsController@getDocument');

