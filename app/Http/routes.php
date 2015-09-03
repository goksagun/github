<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Test route
 * Used for GitHub api testing
 */
Route::get('git', 'HomeController@getGit');

/**
 * Authenticated routes
 */
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@getIndex');
    Route::get('search', 'HomeController@getSearch');
});

/**
 * Auth routes
 */
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
