<?php 
$I = new AppTester($scenario);
$I->am('a user');
$I->wantTo('touch file system');


// Logged in
$user = $I->signedIn();

/**
 * Return NULL value when the requested file NOT FOUND.
 */

// fetch with wrong path
$I->sendGET('/apis/user/files/null');
$result = $I->grabDataFromResponseByJsonPath('$.file')[0];
$I->seeResponseCodeIs(400);
$I->assertNull($result, 'Null should be returned');

// clean up
Flysystem::deleteDir("/users/{$user->id}");