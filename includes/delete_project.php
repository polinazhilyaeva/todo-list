<?php 

include_once 'functions.php';

$project_id = $_POST['project_id'];

$link = connectToDb();

deleteProject($link, $project_id);

mysqli_close($link);

?>