<?php

include_once 'config.php';
include_once 'templates.php';

// Establishes connection to the main database of this application
function connectToDb () {
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
    if (mysqli_connect_error()) {
        die('Could not connect to database');
    }

    mysqli_query($link, "SET NAMES utf8");
        
    return $link;
}

// Replaces keys in any given html template with actual values
function templater ($template, $data_array) {
    $html = $template;
    $toReplace; 
    $key;

    foreach ($data_array as $key => $value) {
        $toReplace = ':' . $key;
        $temp = explode($toReplace, $html);
        $html = implode($value, $temp);
    }

    return $html;
}

/***********************************************************
 *Functions-helpers for log in and out process using session
 ***********************************************************/

function isLoggedIn () {
    if ( isset($_SESSION['id'])) {
        $loggedIn = true;
    } else {
        $loggedIn = false;
    }

    return $loggedIn;
}

function logout () {
    unset($_SESSION['id']);
}

/************************************************
 *Functions for getting notices and errors markup
 ************************************************/

function getNoticeHtml ($error, $type) {
    if ($type === 'danger') {
        $icon = 'error_outline';
    } elseif ($type === 'warning') {
        $icon = 'warning';
    } elseif ($type === 'success') {
        $icon = 'check';
    }

    $toReplace = [
        "type" => $type,
        "icon" => $icon,
        "error" => $error
    ];

    return templater(NOTICE_HTML, $toReplace);
}

function getLoginErrorsHtml () {
    $html = '';

    if (!$_POST['email']) {
        $html .= getNoticeHtml("Please enter your email", 'danger');
    } elseif (!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
        $html .= getNoticeHtml("Please enter a valid email address", 'danger');
    }

    if (!$_POST['password']) {
        $html .= getNoticeHtml("Please enter your password", 'danger');
    }

    return $html;
}

function getSignupErrorsHtml () {
    $html = '';

    if (!$_POST['name']) {
        $html .= getNoticeHtml("Please enter your first name", 'danger');
    }

    if (!$_POST['lastname']) {
        $html .= getNoticeHtml("Please enter your lastname", 'danger');
    }

    if (!$_POST['email']) {
        $html .= getNoticeHtml("Please enter your email", 'danger');
    } elseif (!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
        $html .= getNoticeHtml("Please enter a valid email address", 'danger');
    }

    if (!$_POST['password']) {
        $html .= getNoticeHtml("Please enter your password", 'danger');
    } elseif (strlen($_POST['password']) < 8) {
        $html .= getNoticeHtml("Please enter a password at least 8 characters long", 'danger');
    } elseif (!preg_match('`[A-Z]`', $_POST['password'])) {
        $html .= getNoticeHtml("Please include at least one capital letter in your password", 'danger');
    }

    return $html;
}

/*******************************************************
 *Functions for mysql queries and database manipulations
 *******************************************************/

function isUser ($link, $user) {
    $query = "SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($link, $user['email']) . "' AND password = '" . md5(md5($user['email']) . $user['password']) . "'";
    $result = mysqli_query($link, $query);
    
    $row = mysqli_fetch_array($result);

    return $row;
}

function searchUserByEmail ($link, $email) {
    $query = "SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($link, $email) . "'";
    $result = mysqli_query($link, $query);
    
    $results_number = mysqli_num_rows($result);

    return $results_number;
}

function insertUser ($link, $user) {
    $query = "INSERT INTO users (name, last_name, email, password) VALUES ('" . mysqli_real_escape_string($link, $user['name']) . "', '" . mysqli_real_escape_string($link, $user['lastname']) . "', '" . mysqli_real_escape_string($link, $user['email']) . "', '" . md5(md5($user['email']) . $user['password']) . "')";

    mysqli_query($link, $query);

    return mysqli_insert_id($link);
}

function insertTask ($link, $task) {
    $query = "INSERT INTO tasks (name, deadline, project_id) VALUES ('" . mysqli_real_escape_string($link, $task['name']) . "', '" . $task['deadline'] . "', " . $task['project_id'] .  ")";

    mysqli_query($link, $query);

    return mysqli_insert_id($link);
}

function insertProject ($link, $project) {
    $query = "INSERT INTO projects (name, user_id) VALUES ('" . mysqli_real_escape_string($link, $project['name']) . "', " . $project['user_id'] .  ")";

    mysqli_query($link, $query);

    return mysqli_insert_id($link);
}

function updateTask ($link, $task) {
    $query = "UPDATE tasks SET name = '" . $task['name'] . "', deadline = '" . $task['deadline'] . "' WHERE id=" . $task['id'];

    mysqli_query($link, $query);
}

function updateProject ($link, $project) {
    $query = "UPDATE projects SET name = '" . $project['name'] . "' WHERE id=" . $project['id'];

    mysqli_query($link, $query);
}

function updateCheckedTask ($link, $task) {
    $query = "UPDATE tasks SET checked = " . $task['checked'] . " WHERE id=" . $task['id'];

    mysqli_query($link, $query);
}

// Updates tasks field 'priority' based on an array received from JQuery 'sortable' plugin
function savePriority ($link, $tasks) {
    $i = 0;

    foreach ($tasks as $task_id) {
        $query = "UPDATE tasks SET priority = " . $i . " WHERE id=" . $task_id;
        mysqli_query($link, $query);
        $i++;
    }
}

function getProjectTasks ($link, $project_id) {
    $tasks = [];

    $query = "SELECT * FROM tasks WHERE project_id = " . $project_id . " ORDER BY priority ASC, id DESC";

    mysqli_query($link, $query);

    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_array($result)) {
        $tasks[] = $row;
    }

    return $tasks;
}

function getUserProjects ($link, $user_id) {
    $projects = [];

    $query = "SELECT * FROM projects WHERE user_id = " . $user_id;

    mysqli_query($link, $query);

    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_array($result)) {
        $projects[] = $row;
    }

    return $projects;
}

function deleteTask ($link, $task_id) {
    $query = "DELETE FROM tasks WHERE id='" . $task_id . "'";

    mysqli_query($link, $query);
}

function deleteProject ($link, $project_id) {
    $tasks = getProjectTasks ($link, $project_id);

    // First delete all the tasks from this project
    foreach ($tasks as $task) {
        deleteTask($link, $task['id']);
    }

    $query = "DELETE FROM projects WHERE id='" . $project_id . "'";

    mysqli_query($link, $query);
}

/************************************************
 *Functions for getting tasks and projects markup
 ************************************************/

function getTaskHtml ($task) {
    if ($task['checked']) {
        $checked = 'checked';
    } else {
        $checked = '';
    }

    // Date format of js datepicker is 'd/m/Y' but into mysql database it's written as 'Y-m-d'
    $date = DateTime::createFromFormat('Y-m-d', $task['deadline']);
    $deadline = $date->format('d/m/Y');

    $toReplace = [
        "task" => $task['name'],
        "date" => $deadline,
        "checked" => $checked,
        "id" => $task['id']
    ];

    return templater(TASK_HTML, $toReplace);
}

function getProjectTasksHtml ($tasks) {
    $html = '';

    if ($tasks) {
        foreach ($tasks as $task) {
            $html .= getTaskHtml($task);
        }
    }

    return $html;
}

function getProjectHtml ($link, $project, $empty) {
    // Set timezone to a local client's zone
    date_default_timezone_set('Europe/Kiev');
    $today = date('d/m/Y');

    // Variable $empty is 'true' when a new project is being added
    if ($empty) {
        $tasksHtml = '';
    } else {
        $tasks = getProjectTasks($link, $project['id']);
        $tasksHtml = getProjectTasksHtml($tasks);
    }

    $toReplace = [
        "id" => $project['id'],
        "name" => $project['name'],
        "date" => $today,
        "tasks" => $tasksHtml
    ];

    return templater(PROJECT_HTML, $toReplace);
}

function renderCurrentUserProjects ($link) {
    $html = '';

    $projects = getUserProjects($link, $_SESSION['id']);

    if ($projects) {
        foreach ($projects as $project) {
            $html .= getProjectHtml ($link, $project, false);
        }
    }

    echo $html;
}