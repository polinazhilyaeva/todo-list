<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('edit a task');

$taskId = '375';
$newName = 'I changed my mind 48hfieh*/*837hd';
$newDeadline = '31/12/2017';
$date = DateTime::createFromFormat('d/m/Y', $newDeadline);
$newDeadlineDB = $date->format('Y-m-d');

$I->amGoingTo('log in first');
$I->amOnPage('/todo-app/login.php');
$I->fillField('email', 'test@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Log In');
$I->seeCurrentUrlEquals('/todo-app/home.php');

$I->amGoingTo('check if this task is on page and in database with an old name');
$oldName = $I->grabTextFrom('#task-' . $taskId . ' .task-name');
$oldDeadline = $I->grabTextFrom('#task-' . $taskId . ' .task-deadline');

$date = DateTime::createFromFormat('d/m/Y', $oldDeadline);
$oldDeadlineDB = $date->format('Y-m-d');

$I->dontSee($newName, '#task-' . $taskId . ' .task-name');
$I->dontSee($newDeadline, '#task-' . $taskId . ' .task-deadline');
$I->seeInDatabase('tasks', array('id' => $taskId, 'name' => $oldName, 'deadline' => $oldDeadlineDB));

$I->amGoingTo('edit task and check if it was changed on a page');
$I->dontSeeElement('#editTaskModal');
$I->moveMouseOver(['css' => '#task-' . $taskId]);
$I->wait(1);
$I->seeElement('#task-' . $taskId . ' .edit-task');
$I->click('#task-' . $taskId . ' .edit-task');
$I->wait(1);
$I->seeElement('#editTaskModal');
$I->fillField('#editTaskName', $newName);
$I->fillField('#editTaskDeadline', $newDeadline);
$I->click('#editTaskModal button');
$I->wait(1);
$I->dontSeeElement('#edittaskModal');
$I->see($newName, '#task-' . $taskId . ' .task-name');

$I->amGoingTo('check if the task has been changed in a database');
$I->seeInDatabase('tasks', array('id' => $taskId, 'name' => $newName, 'deadline' => $newDeadlineDB));
$I->reloadPage();
$I->wait(1);
$I->dontSee($oldName, '#task-' . $taskId . ' .task-name');
$I->dontSee($oldDeadline, '#task-' . $taskId . ' .task-deadline');
$I->see($newName, '#task-' . $taskId . ' .task-name');
$I->see($newDeadline, '#task-' . $taskId . ' .task-deadline');