<?php

/**
 * Class that describes a task.
 * This class encapsulates the properties and methods related to a task,
 * including its title, description, due date, and status (done or not).
 * It provides methods to get task details, set its status, and calculate days left until the due date.
 * 
 * @author Raúl Ribeiro
 * @version 1.0
 * @date 07/06/2025
 */

class Task {
    private int $id = -1;
    private bool $done = false;

    /**
     * Constructor for the Task class.
     *
     * @param string $title The title of the task.
     * @param string $description The description of the task.
     * @param string $dueDate The due date of the task.
     */
    public function __construct(private string $title, private string $description, private string $dueDate){
        if(!$title || !$description || !$dueDate){
            error_log("The title, description and due date are mandatory when creating a new task.");
            throw new InvalidArgumentException("Missing mandatory fields.");
        }
    }

    /**
     * Sets the ID of the task.
     *
     * @param int $id The ID to set for the task.
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Gets the ID of the task.
     *
     * @return int The ID of the task.
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Gets the title of the task.
     * 
     * @return string The title of the task.
     */
    public function getTitle(): string{
        return $this->title;
    }

    /**
     * Gets the description of the task.
     * 
     * @return string The description of the task.
     */
    public function getDescription(): string{
        return $this->description;
    }

    /**
     * Gets the due date of the task.
     * 
     * @return DateTime The due date of the task as a DateTime object.
     */
    public function getDueDate(): DateTime{
        return new DateTime($this->dueDate);
    }

    /**
     * Gets the how many days are left until the task's due date.
     * If the due date is in the past, it returns a negative number.
     * If the due date is today, it returns 0.
     * If the due date is in the future, it returns a positive number.
     * 
     * @return int The number of days left until the due date.
     */
    public function getDaysLeft(): int{
        $interval = (new DateTime())->diff($this->getDueDate());
        $daysLeft = $interval->days;

        // If the interval's invert property is true, it means the due date is in the past.
        if ($interval->invert) {
            $daysLeft = -$daysLeft;
        }
        return $daysLeft;
    }

    /**
     * Sets the status of the task as done or not done.
     *
     * @param bool $isDone The status to set for the task.
     */
    public function setIsDone(bool $isDone): void {
        $this->done = $isDone;
    }

    /**
     * Checks if the task is done.
     * 
     * @return bool Returns true if the task is done, false otherwise.
     */
    public function isTaskDone(): bool{
        return $this->done;
    }
}

?>