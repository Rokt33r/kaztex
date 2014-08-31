<?php

use KazTex\Validators\SignInFormValidator;
use KazTex\Validators\FormValidationException;

class SessionsController extends BaseController{

	protected $user, $validator;

	function __construct(User $user, SignInFormValidator $validator){
		$this->user = $user;
		$this->validator = $validator;
	}

	function create(){
		return View::make('sessions.create');
	}
	function store(){
		try{
			$this->validator->validate(Input::all());
			return Redirect::intended('/');
		}catch(FormValidationException $e){
			$errors = $e->getErrors();
			return Redirect::back()->withInput()->withErrors($errors);
		}
	}
	function destroy(){
		Auth::logout();
		try{
			return Redirect::back();
		}catch(InvalidArgumentException $e){
			return Redirect::route('index');
		}
	}
}
