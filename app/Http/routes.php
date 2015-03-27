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

Route::get('home', 'HomeController@index');

Route::controllers([
	// 'auth' => 'Auth\AuthController',
	// パスワードはそのまま使えるかどうかはわからないけどそのままやってみたい
	'password' => 'Auth\PasswordController',
]);

// オレオレ認証
Route::group(['prefix' => 'auth'], function() {
	Route::resource('login', 'AuthController', 
		['only' => ['index', 'store'],]);
	Route::get('logout', 'AuthController@destroy');
	Route::resource('register', 'RegisterController',
		['only' => ['index', 'store'],]);
});

// データベースログ出力(use only php artisan serv)
// DB::listen(function($sql, $bindings, $time)
// {
//     file_put_contents('php://stdout', "[SQL] {$sql} \n" .
//                       "      bindings:\t".json_encode($bindings)."\n".
//                       "      time:\t{$time} milliseconds\n");
// });
