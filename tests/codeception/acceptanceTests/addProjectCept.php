<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('add a new project');

$newProjectName = 'Project 0987-1235';

$I->amGoingTo('log in first');
$I->amOnPage('/todo-app/login.php');
$I->fillField('email', 'test@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Log In');
$I->seeCurrentUrlEquals('/todo-app/home.php');

$I->amGoingTo('verify that this project is not on page and in database');
$I->dontSee($newProjectName, 'h4');
$I->dontSeeInDatabase('projects', array('name' => $newProjectName));

$I->amGoingTo('add a new project');
$I->dontSeeElement('#newProjectModal');
$I->click('[data-target="#newProjectModal"]');
$I->wait(1);
$I->seeElement('#newProjectModal');
$I->fillField('#newProjectName', 'Project 0987-1235');
$I->click('.add-project');
$I->wait(1);

$I->amGoingTo('check if the project was added into a database and on page');
$I->see($newProjectName, 'h4');
$I->seeInDatabase('projects', array('name' => $newProjectName));
$I->reloadPage();
$I->wait(1);
$I->see('Project 0987-1235', 'h4');