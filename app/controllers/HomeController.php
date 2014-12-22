<?php

class HomeController extends BaseController {

	public function __construct(){
		$this->beforeFilter('guest', ['only'=>['welcome']]);
	}

	public function welcome()
	{
		return View::make('welcome');
	}

	public function index(){
		return Redirect::to('app');
	}

}
