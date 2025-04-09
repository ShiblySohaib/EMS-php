<!-- add.php - Insert employee -->
<?php
include 'employees.php';
$employees[] = [
    'name' => $_POST['name'],
    'id' => $_POST['id'],
    'dept' => $_POST['dept'], 
    'tasks' => isset($_POST['tasks']) ? $_POST['tasks'] : []
];

saveemployeeData($employees);
header("Location: manage_employees.php");
?>
