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



Route::get('/','StasiunController@all_stasiun')->name('index');
Route::resource('stasiun','StasiunController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tambah-stasiun','HomeController@tambah')->name('tambah-stasiun');
Route::get('/stasiun/detail/{id}','HomeController@detail');
Route::get('/stasiun/ubah/{id}','HomeController@ubah');
Route::post('/stasiun/ubah','HomeController@update')->name('update');
Route::get('/stasiun/hapus/{id}','HomeController@hapus');
Route::post('/stasiun/tambah','HomeController@store')->name('tambah');
Route::get('export', 'ExportController@export')->name('export');
Route::get('dampak', 'IspuController@dampak')->name('dampak');
Route::get('dampakispu', 'IspuController@dampakIspu')->name('dampakispu');
