<!-- add.php - Insert dept -->
<?php
include 'depts.php';
$depts[] = ['name' => $_POST['name']];
savedeptData($depts);
header("Location: manage_depts.php");
?>
