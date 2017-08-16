<?php 

include_once 'functions.php';

// Date format of js datepicker is 'd/m/Y' but into mysql database it's written as 'Y-m-d'
$date = DateTime::createFromFormat('d/m/Y', $_POST['deadline']);
$deadline = $date->format('Y-m-d');

$task = [
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'deadline' => $deadline
];

$link = connectToDb();

updateTask($link, $task);

mysqli_close($link);

?>