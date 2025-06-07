<?php

/**
 * Class that describes a task.
 */

class Task {
    private int $id = -1;
    private string $setDate;
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

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string{
        return $this->title;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function getDueDate(): DateTime{
        return new DateTime($this->dueDate);
    }

    public function getDaysLeft(): int{
        return (new DateTime())->diff($this->getDueDate())->days;
    }

    public function setIsDone(bool $isDone): void {
        $this->done = $isDone;
    }

    public function isTaskDone(): bool{
        return $this->done;
    }
}

?>