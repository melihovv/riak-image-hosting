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

Route::get('/', 'ImagesController@index')
    ->name('images.index');

Route::post('/', 'ImagesController@store')
    ->name('images.store');

Route::get('/{image}', 'ImagesController@show')
    ->name('images.show');
