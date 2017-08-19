<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('sign up');

$I->amGoingTo('verify that this user is not presented in a database');
$I->dontSeeInDatabase('users', array('name' => 'New', 'last_name' => 'User', 'email' => 'new@test.com'));

$I->amGoingTo('sign up to an app');
$I->amOnPage('/todo-app/signup.php');
$I->fillField('name', 'New');
$I->fillField('lastname', 'User');
$I->fillField('email', 'new@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Sign Up');
$I->seeCurrentUrlEquals('/todo-app/home.php');
$I->see('New User');

$I->amGoingTo('verify that a new user has been added to a database');
$I->seeInDatabase('users', array('email' => 'new@test.com'));