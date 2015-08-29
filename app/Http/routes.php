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

/*
Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/
Route::group(['prefix' => 'api'], function() {
    Route::group(['prefix' => 'filldata'], function(){
        Route::get('champions', 'FillDataController@champions');
        Route::get('items', 'FillDataController@items');
        Route::get('items-maps', 'FillDataController@item_maps');
        Route::get('summoner-spells', 'FillDataController@summoner_spells');
    });
    
    Route::group(['prefix' => 'champion'], function(){
        Route::get('id/{id}', 'ChampionController@showById');
        Route::get('rid/{rid}', 'ChampionController@showByRiotId');
        Route::get('name/{name}', 'ChampionController@showByName');
        Route::get('key/{key}', 'ChampionController@showByKey');
        Route::get('name/{name}/demo', 'ChampionController@nameDemo');
        Route::get('/demo', 'ChampionController@demo');
    });
    
    Route::group(['prefix' => 'item'], function(){
        Route::get('rid/{rid}', 'ItemController@showByRiotId');
        Route::get('/demo', 'ItemController@demo');
    });
    
    Route::group(['prefix' => 'summoner_spell'], function() {
        Route::get('rid/{rid}', 'SummonerSpellController@showByRiotId');
        Route::get('/demo', 'SummonerSpellController@demo');
    });
    
    Route::group(['prefix' => 'random'], function() {
        Route::get('build', 'RandomController@getBuild');
    });
});

Route::any( '{catchall}', function ( $page ) {
    //dd( $page . ' requested' );
    return view('newindex');
} )->where('catchall', '(.*)');