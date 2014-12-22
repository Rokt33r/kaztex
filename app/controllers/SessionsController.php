<?php

use Kaztex\Users\SignInCommand;

class SessionsController extends BaseController{

    public function __construct(){

    }

    public function create(){
        return View::make('sessions.create');
    }

    public function store(){
        $result = $this->execute(SignInCommand::class);

        if(!$result){
            return Redirect::back()->withInput()->withErrors(['message'=>'Certifications are\'t valid.']);
        }

        return Redirect::intended('/app');
    }

    public function destroy(){
        Auth::logout();

        return Redirect::to('/');
    }

}