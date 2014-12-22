<?php

Route::get('/', ['uses'=>'HomeController@welcome', 'as'=>'welcome']);
Route::get('home', ['uses'=>'HomeController@index', 'as'=>'home']);


Route::get('register', ['uses'=>'RegisterController@create', 'as'=>'register']);
Route::post('register', ['uses'=>'RegisterController@store', 'as'=>'register']);

Route::get('signin', ['uses'=>'SessionsController@create', 'as'=>'signin']);
Route::get('signout', ['uses'=>'SessionsController@destroy', 'as'=>'signout']);

Route::get('sessions', ['uses'=>'SessionsController@create', 'as'=>'sessions']);
Route::post('sessions', ['uses'=>'SessionsController@store', 'as'=>'sessions']);
Route::delete('sessions', ['uses'=>'SessionsController@destroy', 'as'=>'sessions']);
