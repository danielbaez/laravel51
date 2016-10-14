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

// User dependency injection
Route::bind('user', function($user){
    return App\User::find($user);
});

Route::get('auth/login', [
	'as' => 'login-get',
	'uses' => 'Auth\AuthController@getLogin'
	]);

Route::post('auth/login', [
	'as' => 'login-post',
	'uses' => 'Auth\AuthController@postLogin'
]);

Route::get('auth/logout', [
	'as' => 'logout',
	'uses' => 'Auth\AuthController@getLogout'
]);

Route::group(['middleware' => ['auth', 'no-cache'], 'prefix'=>'admin'], function () {
    
	Route::get('/', ['as' => 'home','uses' => 'HomeController@home']);	

	Route::group( ['middleware' => ['administrador']], function() {
		Route::resource('user', 'UserController');	
	});

	Route::group( ['middleware' => ['agente']], function() {
		Route::get('/calls', ['as' => 'calls', 'uses' => 'CallController@index']);
		Route::post('/calls/operation', ['as' => 'calls-operation', 'uses' => 'CallController@operation']);
	});

});
