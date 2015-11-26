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
Route::controller('/settings', 'SettingsController');
Route::get('/object', 'ObjectController@index');
Route::post('/object/upload', 'ObjectController@upload');
Route::get('/document', 'DocumentController@index');
Route::post('/document/upload', 'DocumentController@upload');
//Route::get('/document/unassigned')
// Route::get('/overview')
// Route::get('/import/generate')
// Route::get('/import/download')
