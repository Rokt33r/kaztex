<?php

use Kaztex\Users\UserRepository;

class UserController extends BaseController{

    protected $user;

    public function __construct(UserRepository $user){
        $this->user = $user;
    }

    public function index(){
        $user = Auth::user();
        if(empty($user)){
            $response = ['message'=>'Not authorized'];
            return Response::make($response, 401);
        }
        $response = ['user'=>$user->toArray()];

        return Response::make($response, 200);
    }
}