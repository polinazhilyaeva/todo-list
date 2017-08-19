<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('edit a project');

$projectId = '101';
$newName = 'New name of project 3527\\/""6$*w67';

$I->amGoingTo('log in first');
$I->amOnPage('/todo-app/login.php');
$I->fillField('email', 'test@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Log In');
$I->seeCurrentUrlEquals('/todo-app/home.php');

$I->amGoingTo('check if this project is on page and in database with an old name');
$oldName = $I->grabTextFrom('#project-' . $projectId . ' h4');
$I->dontSee($newName, '#project-' . $projectId . ' h4');
$I->seeInDatabase('projects', array('id' => $projectId, 'name' => $oldName));

$I->amGoingTo('edit project and check if it was changed on a page');
$I->dontSeeElement('#editProjectModal');
$I->moveMouseOver(['css' => '#project-' . $projectId . ' nav']);
$I->wait(1);
$I->seeElement('#project-' . $projectId . ' .edit-project');
$I->click('#project-' . $projectId . ' .edit-project');
$I->wait(1);
$I->seeElement('#editProjectModal');
$I->fillField('#editProjectName', $newName);
$I->click('#editProjectModal button');
$I->wait(1);
$I->dontSeeElement('#editProjectModal');
$I->see($newName, '#project-' . $projectId . ' h4');

$I->amGoingTo('check if the project has been changed in a database');
$I->seeInDatabase('projects', array('id' => $projectId, 'name' => $newName));
$I->reloadPage();
$I->wait(1);
$I->dontSee($oldName, '#project-' . $projectId . ' h4');
$I->see($newName, '#project-' . $projectId . ' h4');