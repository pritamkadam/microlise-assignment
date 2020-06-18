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
    return redirect('contents.index');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::resource('contents', 'ContentController');
Route::resource('favourites', 'FavouriteController');
Route::resource('file-upload', 'FileUploadController');
