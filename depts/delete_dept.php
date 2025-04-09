<!-- delete.php - Delete dept -->
<?php
include 'depts.php';
array_splice($depts, $_GET['no'], 1);
savedeptData($depts);
header("Location: manage_depts.php");
?>
