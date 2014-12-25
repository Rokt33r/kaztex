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

$I->sendPOST('/apis/user/files', ['mode'=>'upload'], ['file'=>$file]);
$I->seeResponseContainsJson(['message'=>'OK']);

$I->assertTrue(Flysystem::has("/users/{$user->id}/dummy.file"), 'The file should be created');

/**
 * A user can UPLOAD a file with a SPECIFIC PATH
 */

$I->sendPOST('/apis/user/files/test/dummy', ['mode'=>'upload'], ['file'=>$file]);
$I->seeResponseContainsJson(['message'=>'OK']);

$I->assertTrue(Flysystem::has("/users/{$user->id}/test"), 'The folder should be created automatically');
$I->assertTrue(Flysystem::has("/users/{$user->id}/test/dummy"), 'The file should be created');

/**
 * Invalid path
 */

$I->sendPOST('/apis/user/files/dummy.file/ww', ['mode'=>'upload'], ['file'=>$file]);
$I->seeResponseCodeIs(400);


/**
 * Duplicate name is not allowed.
 */

$I->sendPOST('/apis/user/files/test/dummy', ['mode'=>'upload'], ['file'=>$file]);
$I->seeResponseCodeIs(400);

// clean up
Flysystem::deleteDir("/users/{$user->id}");