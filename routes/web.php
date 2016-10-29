<?php

Route::get('/', 'UsersController@index');

Route::get('/login', 'UsersController@viewLogin');

Route::get('/terms', function () {
    return view('static.terms');
});

Route::group(['prefix' => 'users'], function () {

    // Create new user
    Route::post('/', 'UsersController@create');

    // Confirm email address
    Route::get('/confirm/{token}', 'UsersController@confirm');

    // Unsubscribe by ID
    Route::get('/{userId}/unsubscribe', 'UsersController@unsubscribe');

    // View a user's searches
    Route::get('/{userId}/searches', 'UsersController@searches');
});

Route::group(['prefix' => 'searches'], function () {

    // Unsubscribe by ID
    Route::get('/{searchId}/unsubscribe', 'SearchesController@unsubscribe');

});
