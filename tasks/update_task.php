<?php
require 'task_controllers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateTask($_POST['task_id'], $_POST['name']);
    header("Location: manage_tasks.php");
    exit();
}
?>
