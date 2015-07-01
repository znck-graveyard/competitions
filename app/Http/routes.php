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
Route::controller('auth', 'Auth\AuthController');
Route::controller('password', 'Auth\PasswordController');

Route::group(['prefix' => 'contest'], function () {
    Route::get('create', ['uses' => 'ContestController@create', 'as' => 'contest.create']);
    Route::get('administration/judge/{id}', 'JudgementController@contestJudge');
    Route::get('category/{type}', 'ContestController@contestCategoryHome');
    Route::get('judge/{uid}', 'JudgementController@checkLink');

    Route::post('createFirstTime', 'ContestController@storeFirstTimeContest');
    Route::post('create', 'ContestController@store');
});

Route::group(['prefix' => 'contest',], function () {
    Route::get('category/{slug}', ['as' => 'contest.category', 'uses' => 'ContestController@category']);
});
Route::resource('contest', 'ContestController', ['except' => ['index', 'store']]);
Route::bind('contest', function ($slug) {
    return \App\Contest::whereSlug($slug)->firstOrFail();
});

Route::group(['prefix' => 'submission'], function () {
    Route::get('create', ['uses' => 'EntriesController@create', 'as' => 'submission.create']);
    Route::post('entryFirstTime', 'EntriesController@storeFirstTimeEntry');
    Route::post('create', 'EntriesController@store');

});

Route::resource('submission', 'EntriesController', ['except' => ['store']]);

Route:
get('users/{username}', 'HomeController@userProfile');

