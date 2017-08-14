<?php

include_once "functions.php";

session_start();

$error_message = '';

if (isset($_GET['logout']) && isLoggedIn()) {
    logout();
    $error_message = getNoticeHtml("You have successfully logged out!", 'success');
} elseif ($_POST) {
    if (getLoginErrorsHtml()) {
        $error_message .= getLoginErrorsHtml();
    } else {
        $link = connectToDb();

        $query = "SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($link, $_POST['email']) . "' AND password = '" . md5(md5($_POST['email']) . $_POST['password']) . "'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        mysqli_close($link);

        if (!$row) {
            $error_message = getNoticeHtml("There isn't a user with this email or a password is incorrect", 'danger');
            $error_message .= getNoticeHtml("Try again or <strong><a href='/signup.php'>sign up</a></strong> instead", 'warning');
        } else {

            $_SESSION['id'] = $row['id'];
            
            header('Location: /home.php');         
        }
    }
} elseif (isLoggedIn()) {
    header('Location: /home.php');
}

?>