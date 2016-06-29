<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('shop',                     'RobotController@createShop');
Route::get('shop/{id}',                 'RobotController@showShop');
Route::delete('shop/{id}',              'RobotController@deleteShop');

Route::post('shop/{id}/robot',          'RobotController@createRobot');
Route::put('shop/{id}/robot/{rid}',     'RobotController@updateRobot');
Route::delete('shop/{id}/robot/{rid}',  'RobotController@deleteRobot');
