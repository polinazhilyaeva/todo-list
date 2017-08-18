<?php

include_once 'includes/homepage_flow.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
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
    <title>My ToDo List</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet"/>
</head>

<body>
<nav class="navbar navbar-primary">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-primary">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">My ToDo List</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-primary">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a>
                    <?php 
                        $user = getUserById($link, $_SESSION['id']);
                        echo $user['name'] . ' ' . $user['last_name'];
                    ?>
                    </a>
                </li>
                <li>
                    <a href="/login.php?logout=1">
                        <i class="material-icons">exit_to_app</i>
                        Log Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper">
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div id="projects-list">
                        <!-- Get all projects and tasks of logged in user from database and render them from the server -->
                        <?php 
                            renderCurrentUserProjects($link); 
                        ?>
                    </div>
                    <div class="text-center">
                        <a href="#" class="btn btn-info btn-round" data-toggle="modal" data-target="#newProjectModal">
                            <i class="material-icons">add</i> Add ToDo List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="copyright pull-center">
                &copy; 2017 &middot; Made by <a class="footer-logo" href="https://www.polinazhilyaeva.com" target="blank"><img src="assets/img/polinazhilyaeva_bw.svg" alt="Polina Zhilyaeva"></a>
            </div>
        </div>
    </footer>
</div>

<!-- Modal window for adding a new project -->
<div class="modal fade" id="newProjectModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-notice">
    <div class="modal-content">
        <div class="modal-body">
            <div class="form-group">
                <form class="newProjectForm">
                    <input type="text" class="form-control" id="newProjectName" placeholder="Name your new project">
                    <div class=" text-center">
                        <button class="btn btn-success btn-round add-project">
                            <i class="material-icons">add</i> Add ToDo List
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Modal window for editing a task -->
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-notice">
    <div class="modal-content">
        <div class="modal-body">
            <h5 class="text-center">Enter a new name and choose a new deadline for this task</h5>
            <div class="form-group">
                <form class="editTaskForm">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons color-green">edit</i>
                                </span>
                                <div class="form-group is-empty">
                                    <input type="text" name="new-task" required id="editTaskName" placeholder="Enter a new name for a task" class="form-control">
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons color-green">today</i>
                                </span>
                                <div class="form-group label-static">
                                    <input type="text" name="deadline" id="editTaskDeadline" class="datepicker form-control text-center" data-date-format="dd/mm/yyyy"><span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success btn-round">
                                <i class="material-icons">save</i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Modal window for editing a project -->
<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-notice">
    <div class="modal-content">
        <div class="modal-body">
            <h5 class="text-center">Enter a new name for this project</h5>
            <div class="form-group">
                <form class="editProjectForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons color-green">edit</i>
                                </span>
                                <div class="form-group is-empty">
                                    <input type="text" name="new-task" required id="editProjectName" placeholder="Enter a new name for a project" class="form-control">
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success btn-round">
                                <i class="material-icons">save</i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>
</body>
    <!-- Libraries and components -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/material.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/material-kit.js"></script>
    
    <!-- Main application script -->
    <script src="assets/js/app.js"></script>
</html>
