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

//Route::get('/', function () {
//    return (new \App\Http\Controllers\ProductionExports())->test2();
////    return (new \App\Http\Controllers\ProductionExports())->view();
//});
//
//Auth::routes();
////
//Route::get('/home', 'HomeController@index')->name('home');

//Route::view('/{path?}', 'app');
//Route::view('/','excel');
Route::get('{any}', function () {
    return view('app'); // or wherever your React app is bootstrapped.
})->where('any', '.*');
