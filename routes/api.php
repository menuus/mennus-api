<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::apiResource('orders', 'OrdersController');
    Route::post('/push_token', 'UserController@pushToken');
});


Route::apiResource('food_courts', 'FoodCourtsController');
Route::apiResource('establishments', 'EstablishmentsController');
Route::apiResource('plates', 'PlatesController');
Route::apiResource('menu_types', 'MenuTypesController');
Route::apiResource('plate_categories', 'PlateCategoriesController');
Route::apiResource('establishment_categories', 'EstablishmentCategoriesController');
Route::apiResource('images', 'ImagesController');

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::get('/unauthorized', 'UserController@unauthorized');
Route::group(['middleware' => ['CheckClientCredentials', 'auth:api']], function () {
    Route::post('logout', 'UserController@logout');
    Route::post('details', 'UserController@details');
});