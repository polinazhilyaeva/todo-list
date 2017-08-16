<?php 

include_once 'functions.php';

$task_id = $_POST['task_id'];

$link = connectToDb();

deleteTask($link, $task_id);

mysqli_close($link);

?>