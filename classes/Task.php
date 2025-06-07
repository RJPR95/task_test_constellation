<?php

class Task {
    private $title;
    private $description;
    private $dueDate;

    function __construct($title, $description, $dueDate){
        if($title || $description || $dueDate){
            error_log("The title, description and due date are mandatory when creating a new task.");
            return -1;
        }

        $this->title = $title;
        $this->description = $description;
        $this->dueDate = $dueDate;
    }
}

?>