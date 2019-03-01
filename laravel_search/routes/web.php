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

Route::get('/home','Home@index', function () {

});

Route::get('/','Home@index', function () {

});

Route::get('/add_file','Home@add_file', function () {

});

Route::post('/home/ax_save_file','Home@ax_save_file');

Route::get('Files/insert_data', 'Home@ax_save_file');
Route::post('/home/ax_search_file','Home@ax_search_file');
