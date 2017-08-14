<?php 

include_once "functions.php";

$link = connectToDb();

$tasks = $_POST['task'];

savePriority($link, $tasks);

mysqli_close($link);

?>