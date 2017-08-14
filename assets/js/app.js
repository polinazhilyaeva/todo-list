'use strict';

$(document).ready(function () {
    function toggleChecked (event) {
        var clickedElement = $(event.currentTarget),
            task = clickedElement.closest('.task'),
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

    function savePriority (argument) {
        var priority= $(this).sortable('serialize');

        $.post('includes/save_priority.php', priority);
    }

    function deleteTask (event) {
        var clickedElement = $(event.currentTarget),
            taskLi, taskId, postData;

        taskLi = clickedElement.closest('.task');
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

    function deleteProject (event) {
        var clickedElement = $(event.currentTarget),
            projectContainer, projectId, postData;

        projectContainer = clickedElement.closest('.project-container');
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

    function addTask (event) {
        var projectContainer, newTaskInput, deadlineInput,
            newTask, deadline, projectId,
            postData;

        projectContainer = $(event.target).closest('.project-container');

        newTaskInput = projectContainer.find('input[name=new-task]');
        deadlineInput = projectContainer.find('input[name=deadline]');
        projectId = projectContainer.prop('id').split("-")[1];

        newTask = newTaskInput.val();
        deadline = deadlineInput.val();

        postData = {
            task: newTask,
            date: deadline,
            projectId: projectId
        }

        if (newTask !== '') {
            $.post('includes/add_task.php', postData, function (data) {
                var taskList = projectContainer.find('#task-list'),
                    taskItem, checkbox;

                newTaskInput.val('');
                deadlineInput.val('');

                taskItem = $(data).prependTo(taskList);

                taskItem.hide().fadeIn();

                checkbox = taskItem.find('input[type=checkbox]');
                checkbox.click(toggleChecked);

                taskItem.find('.delete-task').click(deleteTask);
                taskItem.find('.edit-task').click(editTask);
            });
        }

        return false;
    }

    function addProject () {
        var newProjectName = $('#newProjectName').val(),
            postData;

        $('#newProjectModal').modal('hide');
        $('#newProjectName').val('');

        if (newProjectName === '') {
            newProjectName = 'New Project';
        }

        postData = {
            name: newProjectName
        }

        if (newProjectName !== '') {
            $.post('includes/add_project.php', postData, function (data) {
                var projectsList = $('#projects-list'),
                    projectItem;

                projectItem = $(data).appendTo(projectsList);

                projectItem.find('.edit-project').click(editProject);
                projectItem.find('.delete-project').click(deleteProject);
                projectItem.find('.add-task').submit(addTask);
                projectItem.find('.datepicker').datepicker({ weekStart: 1 });
                $('.sortable').sortable(sortOptions);

                projectItem.hide().fadeIn();
            });
        }

        return false;
    }

    function editTask (event) {
        var clickedElement = $(event.currentTarget),
            task = clickedElement.closest('.task'),
            taskId = task.prop('id').split("-")[1],
            oldTaskName = task.find('.task-name').html(),
            oldDeadline = task.find('.task-deadline').html();

        $('.editTaskForm').prop('id', 'editTask-' + taskId);
        $('#editTaskName').val(oldTaskName);
        $('#editTaskDeadline').val(oldDeadline);
    }

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

    function updateTask () {
        var taskId = $('.editTaskForm').prop('id').split("-")[1],
            newTaskName = $('#editTaskName').val(),
            newDeadline = $('#editTaskDeadline').val(),
            taskLi = $('#task-' + taskId),
            taskNameEl = taskLi.find('.task-name'),
            deadlineEl = taskLi.find('.task-deadline'),
            deadlineIcon = taskLi.find('.icon-deadline'),
            today = getTodayFormatted(),
            postData;

        $('#editTaskModal').modal('hide');
        $('#editTaskName').val('');
        $('#editTaskDeadline').val('');
        
        postData = {
            id: taskId,
            name: newTaskName,
            deadline: newDeadline
        }

        $.post('includes/update_task.php', postData);

        taskNameEl.html(newTaskName);
        deadlineEl.html(newDeadline);

        if (newDeadline >= today) {
            deadlineIcon.removeClass('color-red').addClass('color-green');
        } else {
            deadlineIcon.removeClass('color-green').addClass('color-red');
        }

        return false;   
    }

    function editProject (event) {
        var projectContainer = $(event.target).closest('.project-container'),
            projectId = projectContainer.prop('id').split("-")[1],
            oldProjectName = projectContainer.find('.project-name').html();

        $('.editProjectForm').prop('id', 'editProject-' + projectId);
        $('#editProjectName').val(oldProjectName);
    }

    function updateProject () {
        var projectId = $('.editProjectForm').prop('id').split("-")[1],
            newProjectName = $('#editProjectName').val(),
            projectEl = $('#project-' + projectId),
            projectNameEl = projectEl.find('.project-name'),
            postData;

        $('#editProjectModal').modal('hide');
        $('#editProjectName').val('');
        
        postData = {
            id: projectId,
            name: newProjectName
        }

        $.post('includes/update_project.php', postData);

        projectNameEl.html(newProjectName);

        return false;   
    }

    var checkboxes = $('input[type=checkbox]'),
        sortOptions;

    // add event listeners
    checkboxes.click(toggleChecked);
    $('.add-task').submit(addTask);
    $('.newProjectForm').submit(addProject);
    $('.delete-task').click(deleteTask);
    $('.delete-project').click(deleteProject);
    $('.edit-task').click(editTask);
    $('.editTaskForm').submit(updateTask);
    $('.edit-project').click(editProject);
    $('.editProjectForm').submit(updateProject);

    sortOptions = {
        cursor: 'move',
        update: savePriority
    };

    $('.sortable').sortable(sortOptions);

    $('#editTaskDeadline').prop('placeholder', getTodayFormatted());
});