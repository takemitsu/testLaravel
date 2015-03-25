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

Route::group(array('prefix' => 'api'), function() {
	Route::resource('message', 'MessageController',
		['only' => ['index', 'store', 'destroy', 'show'],]);

	Route::resource('message.comment', 'CommentController',
		['only' => ['index', 'store', 'destroy'],]);

	Route::resource('media', 'MediaController',
		['only' => ['index', 'store', 'show'],]);
});


/* とりあえず今は使わないものをコメントアウト
Route::resource('message', 'MessageController',
	['only' => ['index', 'store', 'show'],]);

Route::resource('post', 'PostController',
	['only' => ['index', 'store', 'show'],]);

Route::resource('post.comment', 'CommentController',
	['only' => ['index', 'store', 'show'],]);

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/
