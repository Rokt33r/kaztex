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

$flags = [false, false, false];

foreach($result as $file){
    if($file['type']=='dir'){
        if($file['subFiles'][0]['path'] == "users/{$user->id}/test/another.file"){
            $flags[0] = true;
        }
        if($file['path'] == "users/{$user->id}/test"){
            $flags[1] = true;
        }

    }
    if($file['path'] == "users/{$user->id}/dummy.file"){
        $flags[2] = true;
    }
}

foreach($flags as $flag){
    $I->assertTrue($flag);
}

// clean up
Flysystem::deleteDir("/users/{$user->id}");