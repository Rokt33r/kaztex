<?php namespace Kaztex\Users;

use Kaztex\Core\CommandInterface;

class RegisterUserCommand implements CommandInterface{

    protected $user;

    public function __construct(UserRepository $user){
        $this->user = $user;
    }

    public function execute(array $attributes){
        $user = $this->user->register($attributes);
        return $user;
    }
}