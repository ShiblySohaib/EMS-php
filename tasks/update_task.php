<!-- update.php - Update task -->
<?php
include 'tasks.php';
$no = $_POST['no'];
$tasks[$no] = ['name' => $_POST['name'], 'id' => $_POST['id']];
savetaskData($tasks);
header("Location: manage_tasks.php");
?>
