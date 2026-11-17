<?php

class TaskController {
    public function index()
    {
        $taskModel = new Task();
        $tasks = $taskModel->getAllTasks();

        require_once 'views/tasks.php';
    }

    public function show($id)
    {
        $taskModel = new Task();
        try {
            $task = $taskModel->getTask($id);
        } catch (Exception $e) {
            http_response_code(404);
            require_once 'views/error404.php';
            return;
        }
        require_once 'views/task_overview.php';
    }
}
