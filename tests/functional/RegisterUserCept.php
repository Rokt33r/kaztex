<?php 
$I = new FunctionalTester($scenario);

$I->am('a user');
$I->wantTo('sign up kaztex');

$I->amOnPage('/');
$I->see('Sign Up');

$I->fillField('name', 'John Doe');
$I->fillField('email', 'foo@example.com');
$I->fillField('password', 'secret');
$I->fillField('password_confirmation', 'secret');
$I->click('Sign Up');

$I->amOnRoute('home');
$I->seeRecord('users', ['name'=>'John Doe']);