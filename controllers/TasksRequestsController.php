<?php

/**
 * TasksRequestsController.php
 * This controller handles requests related to tasks, such as adding, deleting, and marking tasks as done.
 * It interacts with the TasksController to perform these operations.
 * 
 * @author Raúl Ribeiro
 * @version 1.0
 * @date 07/06/2025
 */

require_once('TasksController.php');

// Ensure the script is accessed via POST method
// This is a security measure to prevent unauthorized access or misuse of the controller.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create an instance of TasksRequestsController to handle the request
    $tasksRequestController = new TasksRequestsController();

    // Get the action from the POST request
    $action = $_POST['action'] ?? '';

    // Use a match expression to call the appropriate method based on the action
    match($action) {
        'add' => $tasksRequestController->addTask(),
        'delete' => $tasksRequestController->deleteTask(),
        'markAsDone' => $tasksRequestController->markTaskAsDone(),
        default => error_log("Unknown action: " . $action),
    };
}

/**
 * Class TasksRequestsController
 * This class handles requests related to tasks, such as adding, deleting, and marking tasks as done.
 */
class TasksRequestsController {
    private TasksController $tasksController;

    /**
     * Constructor for the TasksRequestsController class.
     * Initializes the TasksController instance to handle task operations.
     */
    public function __construct() {
        $this->tasksController = new TasksController();
    }

    /**
     * Adds a new task based on the POST request data.
     * It retrieves the task details from the request, creates a Task object,
     * and calls the TasksController to add it to the database.
     */
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
                $newTask?->setId($newTaskId);
            }

        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
        }
    }

    /**
     * Deletes a task based on the POST request data.
     * It retrieves the task ID from the request and calls the TasksController to delete it.
     */
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

    /**
     * Marks a task as done based on the POST request data.
     * It retrieves the task ID from the request and calls the TasksController to update its status.
     */
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