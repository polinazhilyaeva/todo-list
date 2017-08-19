<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('prioritize tasks inside a project');

$thirdTaskId = '377';
$projectId = '101';

$I->amGoingTo('log in first');
$I->amOnPage('/todo-app/login.php');
$I->fillField('email', 'test@test.com');
$I->fillField('password', 'Zaq12wsx');
$I->click('Log In');
$I->seeCurrentUrlEquals('/todo-app/home.php');

$I->amGoingTo('verify that priority of the first task is 0, the second is 1, the third - 2');
$taskIds = $I->grabMultiple('#project-' . $projectId . ' .task', 'id');

foreach ($taskIds as $priority => $taskId) {
    $id = explode('-', $taskId);
    $I->seeInDatabase('tasks', array('id' => $id[1], 'priority' => $priority));
}

$I->dragAndDrop('#task-' . $thirdTaskId, '#drop-here');
$I->wait(2);

$I->amGoingTo('verify that priority has changed: the first task has 1, the second has 2, the third has 0');
$taskIds = $I->grabMultiple('#project-' . $projectId . ' .task', 'id');

foreach ($taskIds as $priority => $taskId) {
    $id = explode('-', $taskId);
    $I->seeInDatabase('tasks', array('id' => $id[1], 'priority' => $priority));
}

$I->reloadPage();
$I->wait(1);

$taskIds = $I->grabMultiple('#project-' . $projectId . ' .task', 'id');

foreach ($taskIds as $priority => $taskId) {
    $id = explode('-', $taskId);
    $I->seeInDatabase('tasks', array('id' => $id[1], 'priority' => $priority));
}