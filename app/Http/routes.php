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
    return view('demo');
});

Route::get("/test2", "TestController@test2");
Route::get("/test", "TestController@test");
Route::controller("dd", "\App\Http\Controllers\DemoController");

require_once dirname(__FILE__) . "/rapyd.php";