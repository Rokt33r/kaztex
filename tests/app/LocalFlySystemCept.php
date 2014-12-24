<?php 
$I = new AppTester($scenario);
$I->am('a user');
$I->wantTo('touch file system');

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
$result = $I->grabDataFromResponseByJsonPath('$')[0];
$I->assertEmpty($result, 'The user should have empty storage when signed up');


// set a dummy file
$path = storage_path().'/files/dummy.file';
$file = new Symfony\Component\HttpFoundation\File\UploadedFile($path, 'dummy.file');

/**
 * A user can UPLOAD a file.
 */

// send a file without a specific path
$I->sendPOST('/apis/user/files', null, ['file'=>$file]);
$I->seeResponseContainsJson(['message'=>'OK']);

// check if the file successfully saved
$I->sendGET('/apis/user/files/dummy.file');
$result = $I->grabDataFromResponseByJsonPath('$.file')[0];
$path = $result['path'];

$I->assertContains('dummy.file', $path);

/**
 * A user can UPLOAD a file with a SPECIFIC PATH
 */

// send file with a specific path
$I->sendPOST('/apis/user/files/test/dummy', null, ['file'=>$file]);
$I->seeResponseContainsJson(['message'=>'OK']);

// check if the file successfully saved
$I->sendGET('/apis/user/files/test/dummy');
$result = $I->grabDataFromResponseByJsonPath('$.file')[0];
$path = $result['path'];

$I->assertContains('test/dummy', $path);

$I->sendGET('/apis/user/files');
$result = $I->grabDataFromResponseByJsonPath('$')[0];

$I->assertEquals(3, count($result), 'The user should have 2 files and 1 directory');

/**
 * Return NULL value when the requested file NOT FOUND.
 */

// fetch with wrong path
$I->sendGET('/apis/user/files/null');
$result = $I->grabDataFromResponseByJsonPath('$.file')[0];
$I->seeResponseCodeIs(400);
$I->assertNull($result, 'Null should be returned');

/**
 * A user can DELETE a file or a directory.
 */
$I->sendDELETE('/apis/user/files/test');
$I->sendDELETE('/apis/user/files/dummy.file');

$I->sendGET('/apis/user/files');
$result = $I->grabDataFromResponseByJsonPath('$')[0];
$I->assertEmpty($result, 'The storage should be empty.');

Flysystem::deleteDir("/users/{$user->id}");