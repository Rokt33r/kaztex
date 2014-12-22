<?php namespace Kaztex\Users;

class UserRepository {

    protected $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function register($attributes){
        extract($attributes);
        $user = $this->user->create([
            'email'=>$email,
            'name'=>$name,
            'password'=>$password
        ]);

        return $user;
    }
}