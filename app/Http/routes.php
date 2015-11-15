<?php

/**
 * Authentication
 * --------------------------
 */
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

    Route::any('fellowshipone', ['as' => 'authEndpoint', 'uses' => 'AuthController@fellowshipone']);
    Route::post('register', 'AuthController@register');
    Route::get('verify-email', 'AuthController@verifyEmail');

});

/**
 * End Points
 * --------------------------
 */
Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () {

    Route::get('/test', 'SupportRequests@listRequests');

});

/**
 * Default HTML
 * --------------------------
 */
Route::get('{path?}', 'MainController@index')->where('path', '.+');
