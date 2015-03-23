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

Route::resource('message', 'MessageController',
	['only' => ['index', 'store', 'show'],]);


Route::group(array('prefix' => 'api'), function() {
	Route::resource('message', 'MessageController',
		['only' => ['index', 'store', 'destroy', 'show'],]);
});


/* とりあえず今は使わないものをコメントアウト
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
