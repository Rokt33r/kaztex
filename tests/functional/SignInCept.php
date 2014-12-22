<?php 
$I = new FunctionalTester($scenario);
$I->am('a user');
$I->wantTo('sign in');

$email = 'foo@example.com';
$password = 'secret';

$user = $I->haveAnAccount([
    'email'=>$email,
    'password'=>$password
]);

$I->amOnPage('/');
$I->see('Sign In');
$I->click('Sign In');

$I->seeCurrentUrlEquals('/signin');
$I->fillField('email', $email);
$I->fillField('password', $password);
$I->click('Sign In');

$I->seeAuthentication();
$I->seeCurrentUrlEquals('/app');