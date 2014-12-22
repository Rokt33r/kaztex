<?php namespace Kaztex\Users\Events;

use Kaztex\Users\User;

class UserRegistered {

    public $user;

    public function __construct(User $user){
        $this->user = $user;
    }
}