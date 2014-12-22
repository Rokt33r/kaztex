<?php namespace Kaztex\Users;

use Kaztex\Core\Event\EventDispatcher;

class UserRepository {

    protected $user, $event;

    public function __construct(User $user, EventDispatcher $event){
        $this->user = $user;
        $this->event = $event;
    }

    /**
     * Create a new User and dispatch UserRegisterd event
     * @param $attributes
     * @param EventDispatcher $event
     * @return static
     */
    public function register($attributes){
        $user = $this->user->create($attributes);

        $this->event->dispatch(new Events\UserRegistered($user));

        return $user;
    }
}