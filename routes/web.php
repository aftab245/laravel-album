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

Auth::routes();
// Root index
Route::get('/test/{id?}', 'TestController@index')->name('index_page');
// Root crud operations for album
Route::get('/album/create/', 'TestController@create_album');
Route::post('/album', 'TestController@store_album')->name('store_album');
Route::get('/album/{id}/edit', 'TestController@edit_album')->name('edit_album');
Route::put('/album/{id}', 'TestController@update_album')->name('update_album');
Route::delete('/album/{id}', 'TestController@destroy_album')->name('delete_album');
// Root crud operations for photo
Route::get('/photo/create/{id?}', 'TestController@create_photo');
Route::post('/photo', 'TestController@store_photo')->name('store_photo');
Route::get('/photo/{id}/edit', 'TestController@edit_photo')->name('edit_photo');
Route::put('/photo/{id}', 'TestController@update_photo')->name('update_photo');
Route::delete('/photo/{id}', 'TestController@destroy_photo')->name('delete_photo');
// Child crud operations for album
Route::get('/folder/create/{id}', 'FolderController@create_album');
// Child crud operations for photo
Route::get('/file/create/{id}', 'FileController@create_album');

Route::get('/home', 'HomeController@index')->name('home');