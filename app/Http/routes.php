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
Route::get('faq','HomeController@faq');



Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
Route::get('contest/create',array('uses' => 'ContestController@create', 'as' => 'contest.create'));
Route::post('contest/createFirstTime', 'ContestController@storeFirstTime');
Route::get('contest/administration/judge/{user_id}','JudgementController@contestJudge');
Route::get('contest/category/{type}', 'ContestController@contestCategoryHome');
Route::get('contest/{id}/{judge_string}','JudgementController@checkLink');
Route::resource('contest', 'ContestController', ['except' => ['index']]);

