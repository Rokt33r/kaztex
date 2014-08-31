<?php


use KazTex\Validators\SignUpFormValidator;
use KazTex\Validators\FormValidationException;

class SignUpController extends BaseController{

	protected $user, $validator;

	function __construct(User $user, SignUpFormValidator $validator){
		$this->user = $user;
		$this->validator = $validator;
	}

	function create(){
		return View::make('signup.create');
	}
	function store(){
		try{
			$this->validator->validate(Input::all());
			$user = $this->user->create([
				'email'=>Input::get('email'),
				'password'=>Hash::make(Input::get('password')),
				'name'=>Input::get('name')
				]);
			Auth::login($user);
			return Redirect::route('index');
		}catch(FormValidationException $e){
			$errors = $e->getErrors();
			return Redirect::back()->withInput()->withErrors($errors);
		}
	}
}
