<!-- update.php - Update dept -->
<?php
include 'depts.php';
$no = $_POST['no'];
$depts[$no] = ['name' => $_POST['name'], 'id' => $_POST['id']];
savedeptData($depts);
header("Location: manage_depts.php");
?>
