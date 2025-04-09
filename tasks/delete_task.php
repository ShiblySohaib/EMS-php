<!-- delete.php - Delete task -->
<?php
include 'tasks.php';
array_splice($tasks, $_GET['no'], 1);
savetaskData($tasks);
header("Location: manage_tasks.php");
?>
