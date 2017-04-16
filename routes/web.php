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
Route::get('/login', 'AuthController@viewLogin')->middleware('non-auth');

// Confirm login page
Route::get('/confirm', 'AuthController@viewConfirm')->middleware('non-auth');

// Log out
Route::get('/logout', 'AuthController@logout')->middleware('auth');

// Current User Account page
Route::get('/searches', 'SearchesController@index')->middleware('auth');

Route::group(['prefix' => 'auth'], function () {
    // Submit login form (part 1 of login)
    Route::post('/login', 'AuthController@login');

    // Process confirm token form (part 2 of login)
    Route::post('/confirm', 'AuthController@postConfirm');

    // Confirm using token in URL
    Route::get('/confirm/{token}', 'AuthController@confirm');
});

Route::group(['prefix' => 'users'], function () {
    // Create new user
    Route::post('/', 'UsersController@create');

    // Unsubscribe by ID
    Route::get('/{userId}/unsubscribe', 'UsersController@delete');

    // View a user's searches
    Route::get('/{userId}/searches', 'SearchesController@index');
});

Route::group(['prefix' => 'searches'], function () {
    // Unsubscribe by ID
    Route::get('/{searchId}/unsubscribe', 'SearchesController@unsubscribe');
});

Route::group(['prefix' => 'notifications'], function () {
    // Get a single notification with jobs
    Route::get('/{id}', 'NotificationsController@single');

    // Download jobs from a notification
    Route::get('/{id}/download', 'NotificationsController@download');
});
