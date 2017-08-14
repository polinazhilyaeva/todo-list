<?php

include_once "functions.php";

session_start();

$error_message = '';

if ($_POST) {
    $user = [
        'name' => $_POST['name'],
        'lastname' => $_POST['lastname'],
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];

    if (getSignupErrorsHtml()) {
        $error_message .= getSignupErrorsHtml();
    } else {
        $link = connectToDb();

        $query = "SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($link, $_POST['email']) . "'";
        $result = mysqli_query($link, $query);
        $results_number = mysqli_num_rows($result);

        if ($results_number) {
            $error_message = getNoticeHtml("A user with this email already exists. Do you want to <strong><a href='/login.php'>log in</a></strong> instead?", 'warning');
        } else {
            $_SESSION['id'] = insertUser($link, $user);
            
            mysqli_close($link);

            header('Location: /home.php');      
        }
    }
} elseif (isLoggedIn()) {
    header('Location: /home.php');
}

?>