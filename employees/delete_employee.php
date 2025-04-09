<!-- delete.php - Delete employee -->
<?php
include 'employees.php';
array_splice($employees, $_GET['no'], 1);
saveemployeeData($employees);
header("Location: manage_employees.php");
?>
