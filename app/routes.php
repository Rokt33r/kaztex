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

Route::group(array('before' => 'auth'), function(){
	Route::post('apis/posts/make',
		['uses'=>'PostApiController@make', 'as'=>'apis.posts.make']);
	Route::get('apis/posts/{post_id}',
		['uses'=>'PostApiController@show', 'as'=>'apis.posts.show']);
	Route::delete('apis/posts/{post_id}',
		['uses'=>'PostApiController@destroy', 'as'=>'apis.posts.destroy']);
	Route::put('apis/posts/{post_id}/body',
		['uses'=>'PostApiController@editBody', 'as'=>'apis.posts.edit.body']);
	Route::put('apis/posts/{post_id}/title',
		['uses'=>'PostApiController@editTitle', 'as'=>'apis.posts.edit.title']);
	Route::put('apis/posts/{post_id}/drawings',
		['uses'=>'PostApiController@editDrawings', 'as'=>'apis.posts.edit.drawings']);

});
Route::get('test', function(){
	$user = User::find(1);
	return $user->posts;
});
