<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('log in to an app and then log out');

$I->amGoingTo('log in first');
$I->amOnPage('/todo-app/login.php');
$I->fillField('email', 'test@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Log In');
$I->seeCurrentUrlEquals('/todo-app/home.php');
$I->see('Test User');

$I->amGoingTo('log out now');
$I->click('Log Out');
$I->seeCurrentUrlEquals('/todo-app/login.php?logout=1');
$I->see('You have successfully logged out!');
$I->wait(1);

$I->amGoingTo('try to access an application after logging out');
$I->amOnPage('/todo-app/home.php');
$I->seeCurrentUrlEquals('/todo-app/login.php');