<?php


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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group( function () {
    Route::apiResource('products', 'App\Http\Controllers\API\ProductController');
});
*/
Route::post('register', 'App\Http\Controllers\API\AuthController@register');
Route::post('login', 'App\Http\Controllers\API\AuthController@login');


Route::middleware('auth:api')->group( function (){
    Route::apiResource('products', 'App\Http\Controllers\API\ProductController');
    Route::apiResource('categories', 'App\Http\Controllers\API\CategoryController');
    Route::apiResource('stores', 'App\Http\Controllers\API\StoreController');
    Route::post('logout', 'App\Http\Controllers\API\AuthController@logout');
    Route::post('prods', 'App\Http\Controllers\API\CategsProdsController@storeProducts');
    Route::post('categs', 'App\Http\Controllers\API\CategsProdsController@storeCategories');
});

