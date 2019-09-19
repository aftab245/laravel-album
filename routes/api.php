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

Route::prefix('v1')->group(function () {
    // get api for root and child
    Route::get('file-system/{id?}', 'HomeController@getFileSystem');
    // post,put,delete api for album
    Route::post('directory', 'AlbumController@store');
    Route::put('directory/{id}', 'AlbumController@update');
    Route::delete('directory', 'AlbumController@destroy');
    // post,put,delete api for photo
    Route::post('files', 'PhotoController@store');
    Route::put('files/{id}', 'PhotoController@update');
    Route::delete('files', 'PhotoController@destroy');
});