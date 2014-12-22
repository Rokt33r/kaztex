<?php namespace Kaztex\Users;

class RegisterCommand{

    protected $user;

    public function __construct(UserRepository $user){
        $this->user = $user;
    }

    public $rules = [
        'email'=>'required|email',
        'password'=>'required|confirmed',
        'name'=>'required'
    ];

    public function handle($input){
        $user = $this->user->register($input);
        return $user;
    }
}