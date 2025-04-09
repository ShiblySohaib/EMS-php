<!-- delete.php - Delete user -->
<?php
include 'users.php';
array_splice($users, $_GET['no'], 1);
saveuserData($users);
header("Location: manage_users.php");
?>
