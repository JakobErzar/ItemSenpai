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
        Route::get('/', 'FillDataController@getIndex');
        Route::get('champions', 'FillDataController@champions');
        Route::get('items', 'FillDataController@items');
        Route::get('items-maps', 'FillDataController@item_maps');
        Route::get('summoner-spells', 'FillDataController@summoner_spells');
        Route::get('meme-builds', 'FillDataController@meme_builds');
        Route::get('team-comps', 'FillDataController@team_comps');
        Route::get('role-builds', 'FillDataController@role_builds');
        Route::get('winrate-builds/{from}/{to}', 'FillDataController@winrate_builds');
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
        Route::get('items', 'RandomController@getItems');
        Route::get('all', 'RandomController@getAll');
    });
    
    Route::group(['prefix' => 'memebuild'], function() {
        Route::get('demo', 'MemeBuildController@demo');
        //Route::get('all', 'MemeBuildController@getAll');
        Route::get('make/{id}', 'MemeBuildController@make');
        Route::get('teach/{id}', 'MemeBuildController@teach');
        Route::get('random', 'MemeBuildController@random');
    });
    
    Route::group(['prefix' => 'teamcomps'], function() {
        //Route::get('all', 'TeamCompsController@getAll');
        Route::get('random', 'TeamCompsController@random');
    });
    
    Route::group(['prefix' => 'winrate'], function() {
        Route::get('all', 'WinrateBuildController@getAll');
        Route::get('random', 'WinrateBuildController@random');
    });
    
    Route::group(['prefix' => 'rolebuild'], function() {
        Route::get('all', 'RoleBuildController@getAll');
    });
});

Route::any( '{catchall}', function ( $page ) {
    //dd( $page . ' requested' );
    return view('newindex');
} )->where('catchall', '(.*)');