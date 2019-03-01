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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/add_Wallet', 'Wallet@addWallet')->name('home');
Route::get('/all_Wallet', 'Wallet@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/createPdf', 'HomeController@createPdf');
Route::get('/add_records', 'RecordsController@add_records');
Route::get('/all_records', 'RecordsController@index');
Route::get('/balance',     'BalanceController@index');

Route::post('/home/ax_check_wallet','HomeController@ax_check_wallet');
Route::post('/wallet/ax_save_wallet', 'Wallet@ax_save_wallet');
Route::post('/add_records/ax_save_records', 'RecordsController@ax_save_records');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
