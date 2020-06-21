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
//Route::post('/test', 'ReportController@genReport3');
//Route::post('/test1', 'ReportController@genReport2');


Route::group(['middleware' => 'auth:api'], function(){
// Here goes all the route requiring auth

    Route::get('/details', 'API\UserController@details');

    Route::get('/centrales', 'AdminRoleController@centrales');
    Route::post('/centrales', 'AdminRoleController@createCentrale');
    Route::get('/centrales/{centrale_id}', 'AdminRoleController@getCentraleById');
    Route::put('/centrales/{centrale_id}', 'AdminRoleController@updateCentraleById');
    Route::get('/downloadReport', 'AdminRoleController@downloadReport');

    Route::get('/newPrevisions', 'UserRoleController@newPrevisions');
    Route::get('/newReport', 'UserRoleController@newProductions');
    Route::post('/reports', 'UserRoleController@saveInfos');
    Route::get('/reports', 'UserRoleController@lastDayReports');
    Route::get('/reports/{report_id}', 'UserRoleController@getReportById');
    Route::put('/reports/{report_id}', 'UserRoleController@updateReportById');


});
