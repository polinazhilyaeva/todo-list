<?php 

include_once "functions.php";

$date = DateTime::createFromFormat('d/m/Y', $_POST['deadline']);
$deadline = $date->format("Y-m-d");

$task = [
    "id" => $_POST['id'],
    "name" => $_POST['name'],
    "deadline" => $deadline
];

$link = connectToDb();

updateTask($link, $task);

mysqli_close($link);

?>