<?php

include_once 'functions.php';

session_start();
$link = connectToDb();

// If not authorized user tries to access an app - redirect him to login page
if(!isLoggedIn()) {
    header('Location: /login.php');
    die;
}

?>