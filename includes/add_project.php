<?php 

include_once "functions.php";

session_start();

$project = [
    "name" => $_POST['name'],
    "user_id" => $_SESSION['id']
];

$link = connectToDb();

$project['id'] = insertProject($link, $project);

mysqli_close($link);

echo getProjectHtml($link, $project, true);

?>