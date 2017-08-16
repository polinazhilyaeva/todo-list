<?php 

include_once 'functions.php';

$project = [
    'id' => $_POST['id'],
    'name' => $_POST['name']
];

$link = connectToDb();

updateProject($link, $project);

mysqli_close($link);

?>