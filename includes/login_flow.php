<?php

include_once 'functions.php';

session_start();

$error_message = '';

// If a user came from "Log Out" link - log him out and show a notice
if (isset($_GET['logout']) && isLoggedIn()) {
    logout();
    $error_message = getNoticeHtml('You have successfully logged out!', 'success');

// otherwise check if a log in form was submitted
} elseif ($_POST) {

    // Show error messages if there are any
    if (getLoginErrorsHtml()) {
        $error_message .= getLoginErrorsHtml();
    } else {
        $user = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        $link = connectToDb();

        // Check if there is a user with such email and password in a database
        if (!isUser($link, $user)) {
            // If something is wrong - show an error message
            $error_message = getNoticeHtml('There isn\'t a user with this email or a password is incorrect', 'danger');
            $error_message .= getNoticeHtml('Try again or <strong><a href="/signup.php">sign up</a></strong> instead', 'warning');

        // If login and password are valid - log user in and redirect him to an application page
        } else {
            $_SESSION['id'] = $row['id'];
            header('Location: /home.php');         
        }

        mysqli_close($link);
    }

// If a user is logged in - redirect him straight to an application page
} elseif (isLoggedIn()) {
    header('Location: /home.php');
}

?>