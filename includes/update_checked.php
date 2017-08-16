<?php 

include_once 'functions.php';

$link = connectToDb();

$task = [
    'id' => $_POST['id'],
    'checked' => $_POST['checked']
];

updateCheckedTask($link, $task);

mysqli_close($link);

?>