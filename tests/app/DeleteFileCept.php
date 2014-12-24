<?php 
$I = new AppTester($scenario);
$I->am('a user');
$I->wantTo('delete a file');

$user = $I->signedIn();

/**
 * A user can DELETE a file.
 */
Flysystem::write("/users/{$user->id}/dummy.file", 'This is a test file. :)');

$I->sendDELETE('/apis/user/files/dummy.file');

$I->assertFalse(Flysystem::has("/users/{$user->id}/dummy.file"));

/**
 * A user can DELETE RECURSIVELY.
 */
Flysystem::write("/users/{$user->id}/test/another.file", 'This is a test file. :)');

$I->sendDELETE('/apis/user/files/test');

$I->assertFalse(Flysystem::has("/users/{$user->id}/test"));
$I->assertFalse(Flysystem::has("/users/{$user->id}/test/another.file"));

// clean up
Flysystem::deleteDir("/users/{$user->id}");