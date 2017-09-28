<?php

/**
 * Authentication
 * --------------------------
 */
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

    Route::any('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::post('register', 'AuthController@register');
    Route::get('verify-email/{token}', ['as' => 'verifyEmail', 'uses' => 'AuthController@verifyEmail']);
    Route::get('refresh', 'AuthController@verifyEmail');

});

/**
 * End Points
 * --------------------------
 */
Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () {

    Route::get('/requests', ['uses' => 'SupportRequests@index', 'middleware' => 'zendesk.user_id']);
    Route::post('/requests', ['uses' => 'SupportRequests@store', 'middleware' => 'zendesk.user_id']);
    Route::post('/requests/batch', ['uses' => 'SupportRequests@batchCreate', 'middleware' => 'zendesk.user_id']);

});

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function () {

    Route::get('/ticket-tasks', 'TicketTasksController@index');
    Route::get('/ticket-tasks/{id}', 'TicketTasksController@find');
    Route::post('/ticket-tasks', 'TicketTasksController@store');
    Route::patch('/ticket-tasks/{id}', 'TicketTasksController@update');
    Route::delete('/ticket-tasks/{id}', 'TicketTasksController@destroy');

    Route::get('/ticket-requirements', 'TicketRequirementsController@index');
    Route::get('/ticket-requirements/{id}', 'TicketRequirementsController@find');
    Route::post('/ticket-requirements', 'TicketRequirementsController@store');
    Route::patch('/ticket-requirements/{id}', 'TicketRequirementsController@update');
    Route::delete('/ticket-requirements/{id}', 'TicketRequirementsController@destroy');

    Route::get('/campuses', 'CampusesController@index');

});

/**
 * Default HTML
 * --------------------------
 */
Route::get('/test', ['as' => 'test', 'uses' => 'MainController@test']);
Route::get('/test2', ['as' => 'test', 'uses' => 'MainController@test2']);
Route::get('{path?}', ['as' => 'home', 'uses' => 'MainController@index'])->where('path', '.+');
