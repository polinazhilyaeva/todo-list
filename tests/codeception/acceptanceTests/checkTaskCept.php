<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('mark task as done');

$taskId = '375';

$I->amGoingTo('log in first');
$I->amOnPage('/todo-app/login.php');
$I->fillField('email', 'test@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Log In');
$I->seeCurrentUrlEquals('/todo-app/home.php');

$I->amGoingTo('verify that this task is unchecked');
$I->dontSeeCheckboxIsChecked('#task-' . $taskId . ' input[type=checkbox]');
$I->seeInDatabase('tasks', array('id' => $taskId, 'checked' => '0'));

$I->amGoingTo('check this task to mark it as done');
$I->executeJS('$("#task-' . $taskId . ' input[type=checkbox]").click();');
$I->wait(1);

$I->amGoingTo('verify that this task is now checked');
$I->seeElement('#task-' . $taskId . '.checked');
$I->seeCheckboxIsChecked('#task-' . $taskId . ' input[type=checkbox]');
$I->seeInDatabase('tasks', array('id' => $taskId, 'checked' => '1'));
$I->reloadPage();
$I->wait(1);
$I->seeElement('#task-' . $taskId . '.checked');
$I->seeCheckboxIsChecked('#task-' . $taskId . ' input[type=checkbox]');