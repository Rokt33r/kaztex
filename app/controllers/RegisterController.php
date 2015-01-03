<?php

use Kaztex\Users\UserRepository;
use Kaztex\Users\RegisterCommand;

/**
 * Class RegisterController
 */
class RegisterController extends BaseController{

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user){
        $this->user = $user;
        $this->beforeFilter('guest', []);
    }

    /**
     * @return mixed
     */
    public function create(){
        return View::make('register.create');

    }

    /**
     * @return mixed
     * @throws \Kaztex\Core\InvalidInputException
     */
    public function store(){
        $user = $this->execute(RegisterCommand::class);

        Auth::login($user);

        return Redirect::intended('/app');
    }

}