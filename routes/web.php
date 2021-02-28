<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/',"Guest@index");
Route::get("/search","Search@index");
Route::get("/favourites","FavouritesController@index");
Route::post("/search/result","Search@result");
Route::post("/search/save","Search@save");
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
