<?php

require_once('TasksController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tasksRequestController = new TasksRequestsController();
    $action = $_POST['action'] ?? '';

    match($action) {
        'add' => $tasksRequestController->addTask(),
        'delete' => $tasksRequestController->deleteTask(),
        'markAsDone' => $tasksRequestController->markTaskAsDone(),
        default => error_log("Unknown action: " . $action),
    };
}

class TasksRequestsController {
    
    private TasksController $tasksController;

    public function __construct() {
        $this->tasksController = new TasksController();
    }

    function addTask() {
        try {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $dueDate = $_POST['duedate'] ?? '';

            $newTask = new Task($title, $description, $dueDate);
            $newTaskId = $this->tasksController->addTask($newTask);

            if (!$newTaskId) {
                error_log("Failed to create task: " . $title);
                throw new Exception("Failed to create task.");
            } else {
                $newTask->setId($newTaskId);
            }

        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
        }
    }

    function deleteTask() {
        try {
            $id = $_POST['id'] ?? '';

            if (!$this->tasksController->deleteTask($id)) {
                error_log("Failed to delete task: " . $title);
                throw new Exception("Failed to delete task.");
            }

        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
        }
    }

    function markTaskAsDone() {
        try {
            $id = $_POST['id'] ?? '';

            if (!$this->tasksController->markTaskAsDone($id)) {
                error_log("Failed to mark task as done: " . $id);
                throw new Exception("Failed to mark task as done.");
            }

        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
        }
    }
}