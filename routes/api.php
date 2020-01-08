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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('polusi','PolusiController');


Route::get('/simpan/{data}',function($data){
	$coba = explode("&",$data);
	dd($coba->loc);
});

// Route::post('/stasiun/hitungispu/','HomeController@hitungIspu');