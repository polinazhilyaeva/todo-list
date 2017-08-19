<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('delete a project');

$projectId = '101';

$I->amGoingTo('log in first');
$I->amOnPage('/todo-app/login.php');
$I->fillField('email', 'test@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Log In');
$I->seeCurrentUrlEquals('/todo-app/home.php');

$I->amGoingTo('check if this project is stored in database and on page');
$I->seeInDatabase('projects', array('id' => $projectId));
$I->seeElement('#project-' . $projectId);

$I->amGoingTo('delete project and check if it was removed from a page');
$I->moveMouseOver(['css' => '#project-' . $projectId . ' nav']);
$I->wait(1);
$I->click('#project-' . $projectId . ' .delete-project');
$I->wait(1);
$I->dontSeeElement('#project-' . $projectId);

$I->amGoingTo('check if the project has been removed from database');
$I->dontSeeInDatabase('projects', array('id' => $projectId));
$I->reloadPage();
$I->wait(1);
$I->dontSeeElement('#project-' . $projectId);