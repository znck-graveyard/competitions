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

Route::get('/', 'HomeController@index');
Route::get('faq', 'HomeController@faq');


Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'contest'], function () {
    Route::get('create', ['uses' => 'ContestController@create', 'as' => 'contest.create']);
    Route::get('administration/judge/{id}', 'JudgementController@contestJudge');
    Route::get('category/{type}', 'ContestController@contestCategoryHome');
    Route::get('judge/{uid}', 'JudgementController@checkLink');

    Route::post('createFirstTime', 'ContestController@storeFirstTime');
    Route::post('create', 'ContestController@store');
});
Route::resource('contest', 'ContestController', ['except' => ['index', 'store']]);

