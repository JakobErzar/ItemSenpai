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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'filldata'], function(){
    Route::get('champions', 'FillDataController@champions');
});

Route::group(['prefix' => 'champion'], function(){
    Route::get('id/{id}', 'ChampionController@showById');
    Route::get('rid/{rid}', 'ChampionController@showByRiotId');
    Route::get('name/{name}', 'ChampionController@showByName');
    Route::get('key/{key}', 'ChampionController@showByKey');
    Route::get('name/{name}/demo', 'ChampionController@nameDemo');
    ROute::get('/demo', 'ChampionController@demo');
});