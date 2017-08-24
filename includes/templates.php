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

define('ADD_PROJECT_MODAL', 
    '<div class="modal fade" id="newProjectModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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
</div>');

define('EDIT_TASK_MODAL', 
    '<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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
</div>');

define('EDIT_PROJECT_MODAL', 
    '<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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
</div>');