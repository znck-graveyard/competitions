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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::resource('entries','EntriesController');
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
Route::get('contest/{type}', 'ContestController@contestCategoryHome');

Route::post('contest/createFirstTime', 'ContestController@storeFirstTime');

Route::resource('contest', 'ContestController', ['except' => ['index']]);
