<?php
$I = new AppTester($scenario);
$I->am('a user');
$I->wantTo('upload my file');

// Logged in
$user = $I->signedIn();

// set a dummy file
$path = storage_path().'/files/dummy.file';
$file = new Symfony\Component\HttpFoundation\File\UploadedFile($path, 'dummy.file');

/**
 * A user can UPLOAD a file.
 */

$I->sendPOST('/apis/user/files', null, ['file'=>$file]);
$I->seeResponseContainsJson(['message'=>'OK']);

$I->assertTrue(Flysystem::has("/users/{$user->id}/dummy.file"), 'The file should be created');

/**
 * A user can UPLOAD a file with a SPECIFIC PATH
 */

$I->sendPOST('/apis/user/files/test/dummy', null, ['file'=>$file]);
$I->seeResponseContainsJson(['message'=>'OK']);

$I->assertTrue(Flysystem::has("/users/{$user->id}/test"), 'The folder should be created automatically');
$I->assertTrue(Flysystem::has("/users/{$user->id}/test/dummy"), 'The file should be created');

// clean up
Flysystem::deleteDir("/users/{$user->id}");