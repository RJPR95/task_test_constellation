<?php 
    date_default_timezone_set("Europe/Lisbon"); 
    require_once('controllers/TasksController.php');
?>

<html>
    <head>
        <title>Task Test | FCM</title>
    </head>
    <body>
        <h1>Task Test for FCM</h1>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Days Left</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $tasksController = new TasksController();
                    $tasks = $tasksController->getAllTasks();

                    foreach ($tasks as $task) { ?>
                        <tr>
                            <td>
                                <form action="./controllers/TasksRequestsController.php" method="post">
                                    <input type="hidden" name="action" value="markAsDone">
                                    <input type="hidden" name="id" value="<?=$task->getId()?>">
                                    <input type="submit" value="<?= $task?->isTaskDone() ? "🗹" : "🗷" ?>">
                                </form>
                            </td>
                            <td><?=htmlspecialchars($task?->getTitle())?></td>
                            <td><?=htmlspecialchars($task?->getDescription())?></td>
                            <td><?=$task?->getDueDate()->format('d/m/Y H:i:s')?></td>
                            <td class="<?= $task?->getDaysLeft() <= 0 ? 'overdue' : '' ?>">
                                <?= $task?->getDaysLeft() > 0 ? $task?->getDaysLeft() : "Overdue" ?>
                            </td>
                            <td>

                                <form action="./controllers/TasksRequestsController.php" method="post">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?=$task->getId()?>">
                                    <input type="submit" value="🗑" onclick="return confirm('Are you sure you want to delete this task?');">
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                ?>
                <form action="./controllers/TasksRequestsController.php" method="post">
                    <input type="hidden" name="action" value="add">
                    <tr>
                        <td>
                            <input type="text" name="title" placeholder="Task Title" required>
                        </td>
                        <td>
                            <input type="text" name="description" placeholder="Task Description" required>
                        </td>
                        <td>
                            <input type="datetime-local" name="duedate" required>
                        </td>
                        <td>
                            <input type="submit" value="Add Task">
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </body>
</html>