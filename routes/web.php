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

Route::get('/', 'UsersController@index');

Route::group(['prefix' => 'users'], function () {

    // Get all users in array - for testing
    Route::get('/', 'UsersController@all');

    // Create new user
    Route::post('/', 'UsersController@create');

    // Confirm email address
    Route::get('/confirm/{token}', 'UsersController@confirm');
});
