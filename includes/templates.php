<?php

define('NOTICE_HTML', 
    '<div class="alert alert-:type">
        <div class="container-fluid">
            <div class="alert-icon">
                <i class="material-icons">:icon</i>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="material-icons">clear</i></span>
            </button>:error
        </div>
    </div>');

define('TASK_HTML', 
    '<li class="task :checked" id="task-:id">
        <div class="row">
            <div class="col-xs-2 col-sm-1">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="optionsCheckboxes" class="check-task" :checked>
                        <span class="checkbox-material"><span class="check"></span></span>
                    </label>
                </div>
            </div>
            <div class="col-xs-6 col-sm-8">
                <p class="task-name">:task</p>
                <p><i class="material-icons icon-deadline">schedule</i> <span class="task-deadline">:date</span></p>
            </div>
            <div class="col-xs-4 col-sm-3 text-right">
                <a href="#" class="btn btn-success btn-just-icon btn-simple edit-task" data-toggle="modal" data-target="#editTaskModal">
                    <i class="material-icons">edit</i>
                </a>
                <a href="#" class="btn btn-danger btn-just-icon btn-simple delete-task">
                    <i class="material-icons">delete</i>
                </a>
            </div>
        </div>
    </li>');

define('PROJECT_HTML', 
    '<div class="card project-container" id="project-:id">
        <nav class="navbar navbar-info">
            <div class="container-fluid">
                <div class="col-xs-8 col-sm-9 pull-left">
                    <h4 class="project-name">:name</h4>
                </div>
                <div>
                    <div class="col-xs-4 col-sm-3 text-right">
                        <a href="#" class="btn btn-just-icon btn-simple edit-project" data-toggle="modal" data-target="#editProjectModal">
                            <i class="material-icons">edit</i>
                        </a>
                        <a href="#" class="btn btn-just-icon btn-simple delete-project">
                            <i class="material-icons">delete</i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
            <div class="card card-plain card-form-horizontal">
                <div class="content">
                    <form class="add-task">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons color-green">add_box</i>
                                    </span>
                                    <div class="form-group is-empty">
                                        <input type="text" name="new-task" placeholder="Start typing here to add a task" class="form-control">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons color-green">today</i>
                                    </span>
                                    <div class="form-group label-static">
                                        <input type="text" name="deadline" class="datepicker form-control text-center" placeholder=":date" data-date-format="dd/mm/yyyy"><span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-success btn-block" id="add-task" value="Add Task"></input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <div>
            <ul class="list-unstyled sortable" id="task-list">
                :tasks
            </ul>
        </div>
    </div>');