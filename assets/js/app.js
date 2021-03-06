'use strict';

function TodoApp () {
    // Define options for JQuery 'sortable' plugin
    var sortOptions = {
        cursor: 'move',
        update: savePriority
    };

    this.init = function () {
        // Initiate JQuery 'sortable' plugin
        $('.sortable').sortable(sortOptions);

        // Make placeholder of task deadline today's date
        $('#editTaskDeadline').prop('placeholder', getTodayFormatted());

        // Add event listeners
        // for tasks
        $('.check-task').click(toggleChecked);
        $('.add-task').submit(addTask);
        $('.edit-task').click(prepareEditTaskModal);
        $('.editTaskForm').submit(editTask);
        $('.delete-task').click(deleteTask);

        // for projects
        $('.newProjectForm').submit(addProject);
        $('.delete-project').click(deleteProject);
        $('.edit-project').click(prepareEditProjectModal);
        $('.editProjectForm').submit(editProject);
    }

    /* Sends an array with elements order received 
     * from JQuery 'sortable' plugin to a server */
    function savePriority () {
        var priority= $(this).sortable('serialize');

        $.post('includes/save_priority.php', priority);
    }

    /* Returns todays date as a string in format 'dd/mm/yyyy'
     */
    function getTodayFormatted () {
        var today = new Date(),
            dd = today.getDate(),
            mm = today.getMonth() + 1,
            yyyy = today.getFullYear(),
            todayFormatted;

        if (dd < 10) {
            dd = '0' + dd;
        }

        if (mm < 10) {
            mm = '0' + mm;
        }

        todayFormatted = dd + '/' + mm + '/' + yyyy;

        return todayFormatted;
    }

    /* Toggles a class 'checked' and updates a 'checked' field in a database 
     */
    function toggleChecked (event) {
        var clickedElement = $(event.currentTarget),
            task = clickedElement.closest('.task'),
            // get task id from an 'id' attribute written as 'task-123'
            taskId = task.prop('id').split("-")[1],
            isChecked, postData;

        task.toggleClass('checked');

        if (task.hasClass('checked')) {
            isChecked = true;
        } else {
            isChecked = false;
        }

        postData = {
            id: taskId,
            checked: isChecked
        }
        
        $.post('includes/update_checked.php', postData);
    }

    /* Removes a task DOM object and sends an AJAX request to a server 
     * to delete a task from a database */
    function deleteTask (event) {
        var clickedElement = $(event.currentTarget),
            taskLi, taskId, postData;

        taskLi = clickedElement.closest('.task');
        // get task id from an 'id' attribute written as 'task-123'
        taskId = taskLi.prop('id').split("-")[1];

        postData = {
            task_id: taskId
        }

        taskLi.fadeOut(300, function() {
            taskLi.remove();
        });

        $.post('includes/delete_task.php', postData);    

        return false;
    }

    /* Removes a project DOM object and sends an AJAX request to a server 
     * to delete a project from a database */
    function deleteProject (event) {
        var clickedElement = $(event.currentTarget),
            projectContainer, projectId, postData;

        projectContainer = clickedElement.closest('.project-container');
        // get project id from an 'id' attribute written as 'project-123'
        projectId = projectContainer.prop('id').split("-")[1];

        postData = {
            project_id: projectId
        }

        projectContainer.fadeOut(300, function() {
            projectContainer.remove();
        });

        $.post('includes/delete_project.php', postData);    

        return false;
    }

    /* Appends a new task DOM object to an appropriate project container
     * and sends an AJAX request to a server to insert new task to a database */
    function addTask (event) {
        var projectContainer, newTaskInput, deadlineInput,
            newTask, deadline, projectId,
            postData;

        projectContainer = $(event.target).closest('.project-container');

        newTaskInput = projectContainer.find('input[name=new-task]');
        deadlineInput = projectContainer.find('input[name=deadline]');

        newTask = newTaskInput.val();
        deadline = deadlineInput.val();

        // get project id from an 'id' attribute written as 'project-123'
        projectId = projectContainer.prop('id').split("-")[1];

        postData = {
            task: newTask,
            date: deadline,
            projectId: projectId
        }

        if (newTask !== '') {
            $.post('includes/add_task.php', postData, function (data) {
                var taskList = projectContainer.find('#task-list'),
                    taskItem, checkbox;

                // empty inputs for adding a new task
                newTaskInput.val('');
                deadlineInput.val('');

                // 'data' parameter contains generated by a server html markup
                taskItem = $(data).prependTo(taskList);
                taskItem.hide().fadeIn();

                // add event listener to a checkbox
                checkbox = taskItem.find('.check-task');
                checkbox.click(toggleChecked);

                // add event listeners to 'delete' and 'edit' buttons
                taskItem.find('.delete-task').click(deleteTask);
                taskItem.find('.edit-task').click(prepareEditTaskModal);
            });
        }

        return false;
    }

    /* Prepares a modal window for editing a task 
     * by filling in data of an appropriate task */
    function prepareEditTaskModal (event) {
        var clickedElement = $(event.currentTarget),
            task = clickedElement.closest('.task'),
            // get task id from an 'id' attribute written as 'task-123'
            taskId = task.prop('id').split("-")[1],
            oldTaskName = task.find('.task-name').html(),
            oldDeadline = task.find('.task-deadline').html();

        $('.editTaskForm').prop('id', 'editTask-' + taskId);
        $('#editTaskName').val(oldTaskName);
        $('#editTaskDeadline').val(oldDeadline);
    }

    /* Updates values of a task in html view and sends an AJAX request 
     * to a server to update this values in a database */
    function editTask () {
        var // get task id from an 'id' attribute written as 'task-123'
            taskId = $('.editTaskForm').prop('id').split("-")[1],
            newTaskName = $('#editTaskName').val(),
            newDeadline = $('#editTaskDeadline').val(),
            taskLi = $('#task-' + taskId),
            taskNameEl = taskLi.find('.task-name'),
            deadlineEl = taskLi.find('.task-deadline'),
            deadlineIcon = taskLi.find('.icon-deadline'),
            postData;

        $('#editTaskModal').modal('hide');
        // empty values of inputs in a modal window
        $('#editTaskName').val('');
        $('#editTaskDeadline').val('');
        
        postData = {
            id: taskId,
            name: newTaskName,
            deadline: newDeadline
        }

        $.post('includes/update_task.php', postData);

        // update name and deadline of a task in html view
        taskNameEl.html(newTaskName);
        deadlineEl.html(newDeadline);

        return false;   
    }

    /* Removes a task DOM object and sends an AJAX request to a server 
     * to delete a task from a database */
    function deleteTask (event) {
        var clickedElement = $(event.currentTarget),
            taskLi, taskId, postData;

        taskLi = clickedElement.closest('.task');
        // get task id from an 'id' attribute written as 'task-123'
        taskId = taskLi.prop('id').split("-")[1];

        postData = {
            task_id: taskId
        }

        taskLi.fadeOut(300, function() {
            taskLi.remove();
        });

        $.post('includes/delete_task.php', postData);    

        return false;
    }

    /* Appends a new project DOM object to an appropriate container
     * and sends an AJAX request to a server to insert new project to a database */
    function addProject () {
        var newProjectName = $('#newProjectName').val(),
            postData;

        $('#newProjectModal').modal('hide');
        // empty value of input in a modal window
        $('#newProjectName').val('');

        // if a user didn't enter a name for a project make it default name
        if (newProjectName === '') {
            newProjectName = 'New Project';
        }

        postData = {
            name: newProjectName
        }

        $.post('includes/add_project.php', postData, function (data) {
            var projectsList = $('#projects-list'),
                projectItem;

            // 'data' parameter contains generated by a server html markup
            projectItem = $(data).appendTo(projectsList);
            projectItem.hide().fadeIn();

            // add event listeners and all the functionality for rendered elements
            projectItem.find('.edit-project').click(prepareEditProjectModal);
            projectItem.find('.delete-project').click(deleteProject);
            projectItem.find('.add-task').submit(addTask);
            projectItem.find('.datepicker').datepicker({ weekStart: 1 });
            $('.sortable').sortable(sortOptions);
        });

        return false;
    }

    /* Removes a project DOM object and sends an AJAX request to a server 
     * to delete a project from a database */
    function deleteProject (event) {
        var clickedElement = $(event.currentTarget),
            projectContainer, projectId, postData;

        projectContainer = clickedElement.closest('.project-container');
        // get project id from an 'id' attribute written as 'project-123'
        projectId = projectContainer.prop('id').split("-")[1];

        postData = {
            project_id: projectId
        }

        projectContainer.fadeOut(300, function() {
            projectContainer.remove();
        });

        $.post('includes/delete_project.php', postData);    

        return false;
    }

    /* Prepares a modal window for editing a project 
     * by filling in data of an appropriate project */
    function prepareEditProjectModal (event) {
        var projectContainer = $(event.target).closest('.project-container'),
            // get project id from an 'id' attribute written as 'project-123'
            projectId = projectContainer.prop('id').split("-")[1],
            oldProjectName = projectContainer.find('.project-name').html();

        $('.editProjectForm').prop('id', 'editProject-' + projectId);
        $('#editProjectName').val(oldProjectName);
    }

    /* Updates values of a project in html view and sends an AJAX request 
     * to a server to update this values in a database */
    function editProject () {
        var // get project id from an 'id' attribute written as 'project-123'
            projectId = $('.editProjectForm').prop('id').split("-")[1],
            newProjectName = $('#editProjectName').val(),
            projectEl = $('#project-' + projectId),
            projectNameEl = projectEl.find('.project-name'),
            postData;

        $('#editProjectModal').modal('hide');
        // empty value of input in a modal window
        $('#editProjectName').val('');
        
        postData = {
            id: projectId,
            name: newProjectName
        }

        $.post('includes/update_project.php', postData);

        // update name of a project in html view
        projectNameEl.html(newProjectName);

        return false;   
    }

    return this;
}
    
$(document).ready(function () {
    var app = new TodoApp();

    app.init();
});