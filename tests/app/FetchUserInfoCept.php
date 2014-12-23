<?php 
$I = new AppTester($scenario);
$I->am('a user');
$I->wantTo('fetch my information');

// Not logged in
$I->sendGET('/apis/user');
$I->seeResponseCodeIs(401);


// Logged in
$email ='foo@example.com';
$name = 'John Doe';
$password = 'secret';

$user = $I->haveAnAccount([
    'email'=>$email,
    'password'=>$password,
    'name'=>$name
]);
$I->amLoggedAs($user);

$I->sendGET('/apis/user');

$userArray = $I->grabDataFromResponseByJsonPath('$.user')[0];
$I->assertFalse(array_key_exists('password', $userArray), 'Password shouldn\'t be included in the response.');
$I->assertEquals($name, $userArray['name'], 'Name should be included in the response');
$I->assertEquals($email, $userArray['email'], 'Email should be included in the response');