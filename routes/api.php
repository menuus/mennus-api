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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('food_courts', 'FoodCourtsController');
Route::apiResource('establishments', 'EstablishmentsController');
Route::apiResource('plates', 'PlatesController');
Route::apiResource('menu_types', 'MenuTypesController'); //TODO: add to welcome page
Route::apiResource('plate_categories', 'PlateCategoriesController'); //TODO: add to welcome page
Route::apiResource('establishment_categories', 'EstablishmentCategoriesController'); //TODO: add to welcome page
Route::apiResource('images', 'ImagesController');
