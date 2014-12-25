<?php 
$I = new AppTester($scenario);
$I->am('a user');
$I->wantTo('fetch a file information');


// Logged in
$user = $I->signedIn();

/**
 * Return NULL value when the requested file NOT FOUND.
 */
$I->sendGET('/apis/user/files/null');
$result = $I->grabDataFromResponseByJsonPath('$.file')[0];
$I->seeResponseCodeIs(400);

$I->assertNull($result, 'Null should be returned');


Flysystem::write("/users/{$user->id}/test/dummy.file", 'This is a test file. :)');
/**
 * Fetch information of a file
 */
$I->sendGET('/apis/user/files/test/dummy.file');
$result = $I->grabDataFromResponseByJsonPath('$.file')[0];

$I->assertNotNull($result['type']);
$I->assertNotNull($result['path']);
$I->assertNotNull($result['timestamp']);
$I->assertNotNull($result['size']);

/**
 * Fetch information of a directory
 */
$I->sendGET('/apis/user/files/test');
$result = $I->grabDataFromResponseByJsonPath('$.file')[0];

$I->assertNotNull($result['type']);
$I->assertNotNull($result['path']);
$I->assertFalse(array_key_exists('meme', $result));
$I->assertFalse(array_key_exists('timestamp', $result));
$I->assertFalse(array_key_exists('size', $result));

/**
 * Fetch the data of a file
 */
$I->sendGET('/apis/user/files/test/dummy.file', ['order'=>'load']);
$result = $I->grabDataFromResponseByJsonPath('$.data')[0];

$I->assertEquals('This is a test file. :)', $result);



// clean up
Flysystem::deleteDir("/users/{$user->id}");