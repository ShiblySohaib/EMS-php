<?php
require 'task_controllers.php';

if (isset($_GET['task_id'])) {
    deleteTask($_GET['task_id']);
    header("Location: manage_tasks.php");
    exit();
}
?>
