<?php 

include_once "functions.php";

$link = connectToDb();

if (isset($_POST['id']) && isset($_POST['checked'])) {
    $task = [
        "id" => $_POST['id'],
        "checked" => $_POST['checked']
    ];

    updateCheckedTask($link, $task);
}

mysqli_close($link);

?>