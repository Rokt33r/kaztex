<?php namespace Kaztex\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Kaztex\Http\Users\Requests\RegisterUserRequest;
use Kaztex\Users\RegisterUserCommand;

class RegisterController extends Controller{

    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function create(){
        return view('register.create');
    }

    public function store(RegisterUserRequest $request, RegisterUserCommand $command){
        $input = $request->only('name', 'email', 'password');
        $user = $command->execute($input);

        $this->auth->login($user);

        return redirect()->intended('/');
    }
}