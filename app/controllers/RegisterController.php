<?php

use Kaztex\Users\UserRepository;
use Kaztex\Users\RegisterCommand;

class RegisterController extends BaseController{

    protected $user;

    public function __construct(UserRepository $user){
        $this->user = $user;
        $this->beforeFilter('guest', []);
    }

    public function create(){
        return View::make('register.create');

    }

    public function store(){
        $user = $this->execute(RegisterCommand::class);

        Auth::login($user);

        return Redirect::intended('/app');
    }

}