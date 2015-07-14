<?php
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

/*
 * Static routes
 */
Route::get('about', 'HomeController@about');
Route::get('terms', 'HomeController@terms');

Route::group([], function () {
    /*
     * Auth routes
     */
    Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::get('login/facebook', ['as' => 'auth.facebook', 'uses' => 'Auth\AuthController@facebookLogin']);
    Route::get('login/facebook/callback',
        ['as' => 'auth.facebook.callback', 'uses' => 'Auth\AuthController@facebookLoginHandle']);
    Route::get('login/google', ['as' => 'auth.google', 'uses' => 'Auth\AuthController@googleLogin']);
    Route::get('login/google/callback',
        ['as' => 'auth.google.callback', 'uses' => 'Auth\AuthController@googleLoginHandle']);
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);
    Route::get('register', ['as' => 'auth.signup', 'uses' => 'Auth\AuthController@getRegister']);

    Route::post('login', 'Auth\AuthController@postLogin');
    Route::post('register', 'Auth\AuthController@postRegister');
    /*
     * Password routes
     */
    Route::get('recovery', ['as' => 'password.forgot', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::get('reset', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);

    Route::post('recovery', 'Auth\PasswordController@postEmail');
    Route::post('reset/{token?}', 'Auth\PasswordController@postReset');
});

Route::get('contest/category/{slug}', ['as' => 'contest.category', 'uses' => 'ContestController@category']);
Route::group(['prefix' => 'contest/{contest}'], function () {
    Route::get('cover/{width?}/{height?}', ['as' => 'contest.cover', 'uses' => 'ContestController@cover']);
    Route::get('request', ['as' => 'contest.request', 'uses' => 'ContestController@request']);
    Route::get('review/{token?}', ['as' => 'contest.review', 'uses' => 'ContestController@review']);
    Route::get('publish/{token?}', ['as' => 'contest.publish', 'uses' => 'ContestController@publish']);
    Route::get('entry/{uuid}/upvote', 'EntriesController@upVotes');
    Route::get('entry/{uuid}/downvote', 'EntriesController@downVotes');
});
Route::resource('contest', 'ContestController');
Route::bind('contest', function ($slug) {
    return \App\Contest::whereSlug($slug)->firstOrFail();
});
Route::resource('contest.entry', 'EntriesController');
Route::bind('entry', function ($uuid) {
    return \App\Entry::whereUuid($uuid)->firstOrFail();
});
/*
Route::group(['prefix' => 'submission'], function () {
    Route::get('create', ['uses' => 'EntriesController@create', 'as' => 'submission.create']);
    Route::post('entryFirstTime', 'EntriesController@storeFirstTimeEntry');
    Route::post('create', 'EntriesController@store');
});
*/

Route::resource('submission', 'EntriesController', ['except' => ['store']]);

Route::get('me', ['as' => 'me', 'uses' => 'ProfileController@me']);
Route::get('me/contests', ['as' => 'me.contests', 'uses' => 'ProfileController@contests']);
Route::get('preferences', ['as' => 'me.preferences', 'uses' => 'ProfileController@preferences']);
Route::post('contestant/update', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
Route::group(['prefix' => 'contestant/{username}'], function () {
    Route::get('/', ['as' => 'user.profile', 'uses' => 'ProfileController@show']);
    Route::get('photo/{width?}/{height?}', ['as' => 'user.photo', 'uses' => 'ProfileController@photo']);
    Route::get('cover/{width?}/{height?}', ['as' => 'user.cover', 'uses' => 'ProfileController@cover']);
    Route::get('entries', ['as' => 'user.entries', 'uses' => 'ProfileController@entries']);
});
Route::bind('username', function ($value) {
    if (is_numeric($value)) {
        $user = \App\User::whereId($value)->first();
        if ($user) {
            return $user;
        }
    }

    return \App\User::whereUsername($value)->firstOrFail();
});