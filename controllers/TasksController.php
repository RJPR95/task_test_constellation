<?php
/**
 * TasksController class
 * This class handles operations related to tasks, such as retrieving, adding, marking as done, and deleting tasks.
 * It interacts with the database using PDO and manages Task objects.
 * 
 * @author Raúl Ribeiro
 * @version 1.0
 * @date 07/06/2025
 */

// Get the database connection
require_once(__DIR__ . '/../classes/db.php');
require_once(__DIR__ . '/../classes/Task.php');

class TasksController {
    private PDO $pdo;

    /**
     * Constructor for the TasksController class.
     * Initializes the PDO instance for database operations.
     */
    public function __construct() {
        global $pdo; 
        $this->pdo = $pdo;
    }

    /**
     * Gets all tasks from the database.
     * 
     * @return array Returns an array of Task objects.
     */
    public function getAllTasks(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM tasks");
            $tasks = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $newTask = new Task($row['Title'], $row['Description'], (string)$row['Due_Date']);
                $newTask?->setId((int)$row['ID']);
                $newTask?->setIsDone((int)$row['Done']);
                $tasks[] = $newTask;
            }
            return $tasks;
        } catch (PDOException $e) {
            error_log("Error fetching tasks: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Creates a new task in the database.
     *
     * @param Task $task The task object to be created.
     * @return bool Returns true on success, false on failure.
     */
    public function addTask(Task $task): bool {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO tasks (title, description, due_date, set_date) VALUES (?, ?, ?, NOW())");
            return $stmt->execute([
                $task?->getTitle(),
                $task?->getDescription(),
                $task?->getDueDate()?->format('Y-m-d H:i:s')
            ]);
        } catch (PDOException $e) {
            error_log("Error creating task: " . $e->getMessage());
            return false;
        } finally {
            header('Location: ../index.php'); 
            exit();
        }
    }

    /**
     * Marks a task as done in the database.
     *
     * @param int $id The ID of the task to be marked as done.
     * @return bool Returns true on success, false on failure.
     */
    public function markTaskAsDone(int $id): bool {
        try {
            $task = $this->getTaskById($id);
            $stmt = $this->pdo->prepare("UPDATE tasks SET Done = ? WHERE ID = ?");
            return $stmt->execute([$task?->isTaskDone() ? 0 : 1, $id]);
        } catch (PDOException $e) {
            error_log("Error marking task as done: " . $e->getMessage());
            return false;
        } finally {
            header('Location: ../index.php'); 
            exit();
        }
    }

    /**
     * Get a task by its ID from the tasks array.
     * 
     * @param int $id The ID of the task to retrieve.
     * @return Task|null Returns the Task object if found, null otherwise.
     */
    public function getTaskById(int $id): ?Task {
        $tasks = $this->getAllTasks();
        foreach ($tasks as $task) {
            if ($task->getId() === $id) {
                return $task;
            }
        }
        return null;
    }

    /**
     * Deletes a task from the database.
     *
     * @param int $id The ID of the task to be deleted.
     * @return bool Returns true on success, false on failure.
     */
    public function deleteTask(int $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE ID = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting task: " . $e->getMessage());
            return false;
        } finally {
            header('Location: ../index.php');
            exit();
        }
    }
}