<!-- add.php - Insert task -->
<?php
include 'tasks.php';
$tasks[] = ['name' => $_POST['name'], 'id' => $_POST['id']];
savetaskData($tasks);
header("Location: manage_tasks.php");
?>
