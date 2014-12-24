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
$result = $I->grabDataFromResponseByJsonPath('$')[0];
$I->assertEmpty($result, 'The user should have empty storage when signed up');
