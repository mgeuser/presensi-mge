<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/login',[
	'uses'=>'GeneralController@loginPage',
	'as'=>'login'
]);
Route::post('/login','GeneralController@loginCheck');
Route::get('logout','GeneralController@logout');
Route::get('/masuk','GeneralController@masuk');
Route::get('/pulang','GeneralController@pulang');
Route::get('/', [
	'uses'=>'GeneralController@beranda',
	'as'=>'beranda'
]);

Route::get('/manajemen','GeneralController@manajemen');
Route::post('/manajemen','GeneralController@tambahUser');
Route::post('/add_presensi','GeneralController@tambahPresensi');
Route::get('/delete_user/{id}','GeneralController@hapusUser');
Route::get('/single_user/{id?}','GeneralController@getSingleUser');
Route::get('/single_presensi/{id?}','GeneralController@getSinglePresensi');
Route::post('/update_user/{id?}','GeneralController@updateUser');
Route::post('/update_presensi/{id?}','GeneralController@updatePresensi');
Route::get('/delete_presensi/{id?}','GeneralController@deletePresensi');
Route::get('/presensibulanan','GeneralController@presensiPerbulan');
Route::get('/bookmark','GeneralController@bookmark');
Route::post('/bookmark','GeneralController@tambahBookmark');
Route::get('/delete_bookmark/{id}','GeneralController@deleteBookmark');
Route::get('/file_manager','GeneralController@fileServerPage');
Route::post('/file_manager','GeneralController@uploadFileManager');

Route::get('generate_presensi_cuy','GeneralController@generatePresensi');
Route::get('export_table','GeneralController@exportTable');
Route::get('normalisasi','GeneralController@normalisasi');