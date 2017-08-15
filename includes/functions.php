<?php

include_once "config.php";
include_once "templates.php";

// Establish connection to the main database of this application

function connectToDb () {
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
    if (mysqli_connect_error()) {
        die("Could not connect to database");
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

/*********************************************
 *Functions-helpers for log in and out process
 *********************************************/

function isLoggedIn() {
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

function updateCheckedTask ($link, $task) {
    $query = "UPDATE tasks SET checked = " . $task['checked'] . " WHERE id=" . $task['id'];

    mysqli_query($link, $query);
}

function deleteTask ($link, $task_id) {
    $query = "DELETE FROM tasks WHERE id='" . $task_id . "'";

    mysqli_query($link, $query);
}

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

function deleteProject ($link, $project_id) {
    $tasks = getProjectTasks ($link, $project_id);

    foreach ($tasks as $task) {
        deleteTask($link, $task['id']);
    }

    $query = "DELETE FROM projects WHERE id='" . $project_id . "'";

    mysqli_query($link, $query);
}

function updateProject ($link, $project) {
    $query = "UPDATE projects SET name = '" . $project['name'] . "' WHERE id=" . $project['id'];

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

    $date = DateTime::createFromFormat('Y-m-d', $task['deadline']);
    $deadline = $date->format("d/m/Y");
    $today = date('d/m/Y');

    if ($deadline >= $today) {
        $color = 'color-green';
    } else {
        $color = 'color-red';
    }

    $toReplace = [
        "task" => $task['name'],
        "date" => $deadline,
        "checked" => $checked,
        "color" => $color,
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
    date_default_timezone_set('Europe/Kiev');
    $date = date('d/m/Y');

    if ($empty) {
        $tasksHtml = '';
    } else {
        $tasks = getProjectTasks($link, $project['id']);
        $tasksHtml = getProjectTasksHtml($tasks);
    }

    $toReplace = [
        "id" => $project['id'],
        "name" => $project['name'],
        "date" => $date,
        "tasks" => $tasksHtml
    ];

    return templater(PROJECT_HTML, $toReplace);
}

function renderCurrentUserProjects ($link) {
    $html = '';

    $query = "SELECT * FROM projects WHERE user_id = " . $_SESSION['id'];

    mysqli_query($link, $query);

    $result = mysqli_query($link, $query);
    
    while ($project = mysqli_fetch_array($result)) {
        $html .= getProjectHtml ($link, $project, false);
    }

    echo $html;
}