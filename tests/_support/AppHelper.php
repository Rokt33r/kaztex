<?php
namespace Codeception\Module;

use Laracasts\TestDummy\Factory as TestDummy;

class AppHelper extends \Codeception\Module
{
    public function have($model, $overrides = []){
        return TestDummy::create($model, $overrides);
    }

    public function haveMany($times, $model, $overrides = []){
        return TestDummy::times($times)->create($model, $overrides);
    }

    public function haveAnAccount($overrides = []){
        return $this->have('Kaztex\Users\User', $overrides);
    }
    public function signedIn($overrides = []){
        $I = $this->getModule('Laravel4');

        $user = $this->haveAnAccount($overrides);

        $I->amLoggedAs($user);

        return $user;
    }
}