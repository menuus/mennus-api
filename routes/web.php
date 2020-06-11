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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api', function () {
    return view('endpoints');
});

Route::get('/theproject', function () {
    return view('theproject');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/order_delete', 'HomeController@order_delete')->name('order_delete');
Route::post('/order_call', 'HomeController@order_call')->name('order_call');
Route::post('/order_finish', 'HomeController@order_finish')->name('order_finish');
