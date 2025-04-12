<?php
require 'task_controllers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addTask($_POST['name']);
    header("Location: manage_tasks.php");
    exit();
}
?>
