<?php 
$I = new FunctionalTester($scenario);
$I->am('a user');
$I->wantToTest('redirecting proper paths when signed in');

$email = 'foo@example.com';
$password = 'secret';

$user = $I->haveAnAccount([
    'email'=>$email,
    'password'=>$password
]);

$I->amOnPage('/');
$I->see('Sign In');
$I->click('Sign In');

$I->amOnPage('/');
$I->seeCurrentUrlEquals('app');

$I->amOnPage('register');
$I->seeCurrentUrlEquals('app');

$I->amOnPage('signin');
$I->seeCurrentUrlEquals('app');
