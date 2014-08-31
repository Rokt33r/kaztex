<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// Index
Route::get('/', ['uses'=>'HomeController@index', 'as'=>'index']);

// Sign in
Route::post('sessions',
	['uses'=>'SessionsController@store', 'as'=>'sessions.store']);

Route::get('signin', ['uses'=>'SessionsController@create','as'=>'signin']);
Route::get('sessions/create',
	['uses'=>'SessionsController@create', 'as'=>'sessions.create']);

// Sign out
Route::get('signout', ['uses'=>'SessionsController@destroy', 'as'=>'signout']);
Route::delete('sessions', ['uses'=>'SessionsController@destroy', 'as'=>'sessions.destroy']);

// Sign up
Route::get('signup', ['uses'=>'SignUpController@create', 'as'=>'signup.create']);
Route::post('signup', ['uses'=>'SignUpController@store', 'as'=>'signup.store']);


Route::get('test', function(){
	$user = User::find(1);
	return $user->posts;
});
