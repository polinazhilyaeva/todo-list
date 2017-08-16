<?php 

include_once 'functions.php';

// Set timezone to a local client's zone
date_default_timezone_set('Europe/Kiev');
$today = date('Y-m-d');

if (!$_POST['date']) {
    // If a user didn't enter a deadline it will be today by default
    $deadline = $today;
} else {
    // Date format of js datepicker is 'd/m/Y' but into mysql database it's written as 'Y-m-d'
    $date = DateTime::createFromFormat('d/m/Y', $_POST['date']);
    $deadline = $date->format('Y-m-d');
}

$task = [
    'name' => $_POST['task'],
    'deadline' => $deadline,
    'checked' => false,
    'project_id' => $_POST['projectId']
];

$link = connectToDb();

$task['id'] = insertTask($link, $task);

mysqli_close($link);

echo getTaskHtml($task);

?>