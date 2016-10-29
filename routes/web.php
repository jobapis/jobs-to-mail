<?php

// Homepage
Route::get('/', function () {
    return view('users.index');
});

// Terms page
Route::get('/terms', function () {
    return view('static.terms');
});

// Login page
Route::get('/login', 'AuthController@viewLogin');

// Confirm login page
Route::get('/confirm', 'AuthController@viewConfirm');

Route::group(['prefix' => 'auth'], function () {

    // Submit login form (part 1 of login)
    Route::post('/login', 'AuthController@login');

    // Process confrim token form (part 2 of login)
    Route::post('/confirm', 'AuthController@confirm');

    // Confirm using token in URL
    Route::get('/confirm/{token}', 'AuthController@confirm');
});

Route::group(['prefix' => 'users'], function () {

    // Create new user
    Route::post('/', 'UsersController@create');

    // Unsubscribe by ID
    Route::get('/{userId}/unsubscribe', 'UsersController@delete');

    // View a user's searches
    Route::get('/{userId}/searches', 'UsersController@searches');
});

Route::group(['prefix' => 'searches'], function () {

    // Unsubscribe by ID
    Route::get('/{searchId}/unsubscribe', 'SearchesController@unsubscribe');

});
