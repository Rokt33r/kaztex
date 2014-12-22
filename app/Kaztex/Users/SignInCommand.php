<?php namespace Kaztex\Users;

class SignInCommand {

    public $rules = [
        'email'=>'required',
        'password'=>'required'
    ];

    public function handle($input){
        extract($input);
        if(\Auth::attempt([
            'email'=>$email,
            'password'=>$password
        ])){
            return true;
        }
        return false;
    }
}