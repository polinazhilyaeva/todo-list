<?php 

include_once "functions.php";

$today = date('Y-m-d');

if (!$_POST['date']) {
    $deadline = $today;
} else {
    $date = DateTime::createFromFormat('d/m/Y', $_POST['date']);
    $deadline = $date->format("Y-m-d");
}

$task = [
    "name" => $_POST['task'],
    "deadline" => $deadline,
    "checked" => false,
    "project_id" => $_POST['projectId']
];

$link = connectToDb();

$task['id'] = insertTask($link, $task);

mysqli_close($link);

echo getTaskHtml($task);

?>