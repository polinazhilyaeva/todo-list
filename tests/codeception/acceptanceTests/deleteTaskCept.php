<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('delete a task from a project');

$taskId = '375';

$I->amGoingTo('log in first');
$I->amOnPage('/todo-app/login.php');
$I->fillField('email', 'test@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Log In');
$I->seeCurrentUrlEquals('/todo-app/home.php');

$I->amGoingTo('check if this task is stored in database and on page');
$I->seeInDatabase('tasks', array('id' => $taskId));
$I->seeElement('#task-' . $taskId);

$I->amGoingTo('delete a task and check if it was removed from a page');
$I->moveMouseOver(['css' => '#task-' . $taskId]);
$I->wait(1);
$I->click('#task-' . $taskId . ' .delete-task');
$I->wait(1);
$I->dontSeeElement('#task-' . $taskId);

$I->amGoingTo('check if the task has been removed from database');
$I->dontSeeInDatabase('tasks', array('id' => $taskId));
$I->reloadPage();
$I->wait(1);
$I->dontSeeElement('#task-' . $taskId);