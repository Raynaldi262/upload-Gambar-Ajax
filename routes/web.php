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

use Illuminate\Support\Facades\Route;

Route::get('/', 'ImagesController@index');

Route::get('/upload', 'ImagesController@create')->name('upload');
Route::post('/upload/action', 'ImagesController@store')->name('uploaded');

Route::get('/fetch/image', 'ImagesController@fetch_data')->name('fetch');
Route::post('/delete/image', 'ImagesController@destroy')->name('delete');

Route::view('login', 'login');
Route::post('login', 'LoginController@index');
Route::get('logout', 'LoginController@exit');
