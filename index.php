<?php 
    /**
     * Task Test for FCM
     * This project serves as a simple task management interface for testing purposes.
     * It allows users to add, delete, and mark tasks as done.
     * The tasks are stored in a MySQL database and managed through a TasksController.
     * 
     * @author Raúl Ribeiro
     * @version 1.0
     * @date 07/06/2025
     */

    date_default_timezone_set("Europe/Lisbon"); 
    require_once('controllers/TasksController.php');
?>

<html>
    <head>
        <title>Task Test | FCM | by Raúl Ribeiro</title>
        <link rel="stylesheet" type="text/css" href="assets/styles.scss" />
    </head>
    <body>
        <div class="header">
            <h1>Task Test for FCM</h1>
            <h2>by Raúl Ribeiro</h2>
        </div>
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Days Left</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $tasksController = new TasksController();
                        $tasks = $tasksController?->getAllTasks();

                        foreach ($tasks as $task) { ?>
                            <tr class="<?= !$task?->isTaskDone() ? "not-done" : "done" ?>">
                                <td class="actions">
                                    <div>
                                        <form action="./controllers/TasksRequestsController.php" method="post">
                                            <input type="hidden" name="action" value="markAsDone">
                                            <input type="hidden" name="id" value="<?=$task?->getId()?>">
                                            <input type="submit" class="<?= !$task?->isTaskDone() ? "not-done" : "done" ?>" value="<?= $task?->isTaskDone() ? "🗹" : "🗷" ?>">
                                        </form>
                                    </div>
                                </td>
                                <td><?=htmlspecialchars($task?->getTitle())?></td>
                                <td><?=htmlspecialchars($task?->getDescription())?></td>
                                <td><?=$task?->getDueDate()->format('d/m/Y H:i:s')?></td>
                                <td class="<?= $task?->getDaysLeft() <= 0 ? 'overdue' : '' ?>">
                                    <?= $task?->getDaysLeft() > 0 ? $task?->getDaysLeft() : "Overdue" ?>
                                </td>
                                <td class="actions">
                                    <form action="./controllers/TasksRequestsController.php" method="post">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?=$task?->getId()?>">
                                        <input type="submit" class="delete" value="🗑" onclick="return confirm('Are you sure you want to delete this task?');">
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                    ?>
                    <form action="./controllers/TasksRequestsController.php" method="post">
                        <input type="hidden" name="action" value="add">
                        <tr>
                            <td>✚</td>
                            <td class="field">
                                <input type="text" name="title" placeholder="Task Title" required>
                            </td>
                            <td class="field">
                                <input type="text" name="description" placeholder="Task Description" required>
                            </td>
                            <td class="field">
                                <input type="datetime-local" name="duedate" required>
                            </td>
                            <td colSpan="2" class="actions">
                                <input type="submit" class="submit" value="Add Task">
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
        </div>
    </body>
</html>