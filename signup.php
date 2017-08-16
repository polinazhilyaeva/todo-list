<?php

include_once 'includes/signup_flow.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <!-- Include favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Signup Page - ToDo List</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet"/>
</head>
<body class="signup-page">
    <div class="page-header header-filter signup" filter-color="teal">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="card card-signup">
                        <h2 class="card-title text-center">Sign Up</h2>
                        <h4 class="card-title text-center">to get started using ToDo List</h4>
                        <?php echo $error_message; ?>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-1">
                                <div class="info info-horizontal">
                                    <div class="icon icon-success">
                                        <i class="material-icons">mood</i>
                                    </div>
                                    <div class="description">
                                        <h4 class="info-title">Easy to Use</h4>
                                        <p class="description">
                                            Simple and intuitive interface which helps you manage your tasks and projects more effectively.
                                        </p>
                                    </div>
                                </div>

                                <div class="info info-horizontal">
                                    <div class="icon icon-rose">
                                        <i class="material-icons">timeline</i>
                                    </div>
                                    <div class="description">
                                        <h4 class="info-title">Productivity Booster</h4>
                                        <p class="description">
                                            The best choice for a person who is passionate about her own productivity.
                                        </p>
                                    </div>
                                </div>

                                <div class="info info-horizontal">
                                    <div class="icon icon-warning">
                                        <i class="material-icons">star</i>
                                    </div>
                                    <div class="description">
                                        <h4 class="info-title">Google's Material Design</h4>
                                        <p class="description">
                                            Combines the classic principles of successful design along with innovation and technology.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <form class="form" method="post">
                                    <div class="content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <input type="text" name="name" class="form-control" required placeholder="First Name..." value="
                                            <?php 
                                                if ($_POST) {
                                                    echo $_POST['name'];
                                                } 
                                            ?>
                                            ">
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">perm_identity</i>
                                            </span>
                                            <input type="text" name="lastname" class="form-control" required placeholder="Last Name..." value="
                                            <?php 
                                                if ($_POST) {
                                                    echo $_POST['lastname']; 
                                                }
                                            ?>
                                            ">
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <input type="email" name="email" class="form-control" required placeholder="Email..." value="
                                            <?php 
                                                if ($_POST) {
                                                    echo $_POST['email']; 
                                                }
                                            ?>">
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <input type="password" name="password"  class="form-control" required placeholder="Password..."  value="
                                            <?php 
                                                if ($_POST) {
                                                    echo $_POST['password']; 
                                                }
                                            ?>">
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <input type="submit" name="submit" value="Sign Up" class="btn btn-primary btn-round">
                                        <hr>
                                        <p class="description">Already registered? 
                                            <a href="/login.php" class="btn btn-primary btn-simple">Log In</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/material.min.js"></script>
    <script src="/assets/js/material-kit.js"></script>
</html>
