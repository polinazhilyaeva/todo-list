<?php

include_once 'functions.php';

session_start();

$error_message = '';

// Check if a sign up form was submitted
if ($_POST) {

    // Show error messages if there are any
    if (getSignupErrorsHtml()) {
        $error_message .= getSignupErrorsHtml();
    } else {
        $link = connectToDb();
        
        // Check if there is already a user with such email in a database
        if (searchUserByEmail($link, $_POST['email'])) {
            $error_message = getNoticeHtml('A user with this email already exists. Do you want to <strong><a href="/login.php">log in</a></strong> instead?', 'warning');

        // If not - add new user to a database, log him in and redirect to an application page
        } else {
            $user = [
                'name' => $_POST['name'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];

            $_SESSION['id'] = insertUser($link, $user);
            header('Location: /home.php');      
        }

        mysqli_close($link);
    }

// If a user is logged in - redirect him straight to an application page
} elseif (isLoggedIn()) {
    header('Location: /home.php');
}

?>