<?php

use Kaztex\Users\UserRepository;

class UserController extends BaseController{

    protected $user;

    public function __construct(UserRepository $user){
        $this->user = $user;
    }

    public function index(){
        $user = Auth::user();

        $response = ['user'=>$user->toArray()];

        return Response::make($response, 200);
    }
}