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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login', 'API\UserController@login');

Route::group(['middleware' => 'auth:api'], function(){
// Here goes all the route requiring auth
//    Route::post('/register', 'API\UserController@register');
    Route::get('/details', 'API\UserController@details');

//    Route::get('/centrale/{id}', 'CentraleController@getById');
//    Route::get('/centrales', 'CentraleController@getAll');
    Route::post('/centrales', 'AdminRoleController@createCentrale');

//    Route::post('/test', 'ReportController@index');

    Route::get('/newPrevisions', 'UserRoleController@newPrevisions');

    Route::get('/newReport', 'UserRoleController@newProductions');
    Route::post('/newReport', 'UserRoleController@saveInfos');

});
