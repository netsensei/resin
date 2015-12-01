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

/* Route::get('/', function () {
    return view('index');
}); */

Route::get('/', 'HomeController@index');

Route::get('/object', 'ObjectController@index');
Route::get('/object/without-pid', 'ObjectController@withoutPid');
Route::get('/object/with-pid', 'ObjectController@withPid');
Route::post('/object/upload', 'ObjectController@upload');

Route::get('/document', 'DocumentController@index');
Route::get('/document/orphans', 'DocumentController@orphans');
Route::post('/document/upload', 'DocumentController@upload');

Route::controller('/merge', 'MergeController');

Route::controller('/settings', 'SettingsController');
