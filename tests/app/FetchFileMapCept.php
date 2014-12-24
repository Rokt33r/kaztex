<?php 
$I = new AppTester($scenario);
$I->am('a user');
$I->wantTo('fetch my filemap');


/**
 * Only AUTHENTICATED user can access file system.
 */

$I->sendGET('/apis/user/files');
$I->seeResponseCodeIs(401);

// Logged in
$user = $I->signedIn();

/**
 * A user should have EMPTY storage when just signed up.
 */

$I->sendGET('/apis/user/files');
$result = $I->grabDataFromResponseByJsonPath('$.files')[0];
$I->assertEmpty($result, 'The user should have empty storage when signed up');


/**
 * Return all files and directories
 */

Flysystem::write("/users/{$user->id}/dummy.file", 'This is a test file. :)');
Flysystem::write("/users/{$user->id}/test/another.file", 'This is a test file. :)');

$I->sendGET('/apis/user/files');
$result = $I->grabDataFromResponseByJsonPath('$.files')[0];
$I->assertEquals(3, count($result), 'Expect the size of array to be 3 because the user has 2 files and 1 directory.');


// clean up
Flysystem::deleteDir("/users/{$user->id}");