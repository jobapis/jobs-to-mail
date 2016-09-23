<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'users'], function () {

    // Get all users in array - for testing
    Route::get('/', function () {
        return response()->json(
            \JobApis\JobsToMail\Models\User::with('tokens')->get()
        );
    });

    // Create new user
    Route::post('/', 'UsersController@create');
});
