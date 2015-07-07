<?php
Route::get('/', 'HomeController@index');
Route::get('faq', 'HomeController@faq');
Route::get('login/facebook', 'Auth\AuthController@facebookLogin');
Route::get('login/facebook/callback', 'Auth\AuthController@facebookLoginHandle');

Route::controller('auth', 'Auth\AuthController');
Route::controller('password', 'Auth\PasswordController');

Route::group(['prefix' => 'contest'], function () {
    Route::get('create', ['uses' => 'ContestController@create', 'as' => 'contest.create']);
    Route::get('administration/judge/{id}', 'JudgementController@contestJudge');
    Route::get('judge/{uid}', 'JudgementController@checkLink');

    Route::post('createFirstTime', 'ContestController@storeFirstTimeContest');
    Route::post('create', 'ContestController@store');

    Route::get('category/{slug}', ['as' => 'contest.category', 'uses' => 'ContestController@category']);
});
Route::resource('contest', 'ContestController', ['except' => ['index', 'store']]);
Route::bind('contest', function ($slug) {
    return \App\Contest::whereSlug($slug)->firstOrFail();
});

Route::resource('contest.entry', 'EntriesController');
Route::bind('entry', function ($uuid) {
    return \App\Entry::whereUuid($uuid)->firstOrFail();
});

Route::group(['prefix' => 'submission'], function () {
    Route::get('create', ['uses' => 'EntriesController@create', 'as' => 'submission.create']);
    Route::post('entryFirstTime', 'EntriesController@storeFirstTimeEntry');
    Route::post('create', 'EntriesController@store');
});

Route::resource('submission', 'EntriesController', ['except' => ['store']]);

Route::get('users/entries', 'HomeController@userEntries');
Route::get('users/{username}', 'HomeController@userProfile');
