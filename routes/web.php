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
    return redirect(route('contents.index'));
});

Auth::routes();

Route::get('contents/favorites', 'ContentController@favorites')->name('contents.favorites');
Route::resource('contents', 'ContentController');
Route::resource('file-upload', 'FileUploadController');

Route::post('contents/{id}/toggle-favorite', 'ContentController@toggleFavorite')->name('contents.toggle-favorite');
