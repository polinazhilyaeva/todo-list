<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('add a new task to a project');

$newTaskName = 'Task 7676/"794287';
$newTaskDeadline = '01/09/2017';
$date = DateTime::createFromFormat('d/m/Y', $newTaskDeadline);
$newDeadlineDB = $date->format('Y-m-d');
$projectId = '101';

$I->amGoingTo('log in first');
$I->amOnPage('/todo-app/login.php');
$I->fillField('email', 'test@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Log In');
$I->seeCurrentUrlEquals('/todo-app/home.php');

$I->amGoingTo('verify that this task is not on page and in database');
$I->dontSee($newTaskName, '.task-name');
$I->dontSee($newTaskDeadline, '.task-deadline');
$I->dontSeeInDatabase('tasks', array('name' => $newTaskName, 'deadline' => $newDeadlineDB, 'project_id' => $projectId));

$I->amGoingTo('add a new task');
$I->seeElement('#project-' . $projectId);
$I->fillField('#project-'. $projectId . ' input[name="new-task"]', $newTaskName);
$I->fillField('#project-'. $projectId . ' input[name="deadline"]', $newTaskDeadline);
$I->click('#project-'. $projectId . ' #add-task');
$I->wait(1);

$I->amGoingTo('check if a task is added on a page and in database');
$I->see($newTaskName, ['css' => '#project-'. $projectId . ' .task-name']);
$I->see($newTaskDeadline, ['css' => '#project-'. $projectId . ' .task-deadline']);
$I->seeInDatabase('tasks', array('name' => $newTaskName, 'deadline' => $newDeadlineDB, 'project_id' => $projectId));
$I->reloadPage();
$I->see($newTaskName, ['css' => '#project-'. $projectId . ' .task-name']);
$I->see($newTaskDeadline, ['css' => '#project-'. $projectId . ' .task-deadline']);