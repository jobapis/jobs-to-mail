<?php

Route::get('/', 'UsersController@index');

Route::group(['prefix' => 'users'], function () {

    // Get all users in array - for testing
    Route::get('/', 'UsersController@all');

    // Create new user
    Route::post('/', 'UsersController@create');

    // Confirm email address
    Route::get('/confirm/{token}', 'UsersController@confirm');

    // Unsubscribe user by ID
    Route::get('/unsubscribe/{userId}', 'UsersController@unsubscribe');
});
