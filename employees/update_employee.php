<!-- update.php - Update employee -->
<?php
session_start();
if (!isset($_SESSION['role'])) {
    echo "Unauthorized access!";
    exit;
}
$role = $_SESSION['role'];

include 'employees.php';
$no = $_POST['no'];
$employees[$no] = [
    'name' => $_POST['name'],
    'id' => $_POST['id'],
    'dept' => $_POST['dept'], 
    'tasks' => isset($_POST['tasks']) ? $_POST['tasks'] : []
];

saveemployeeData($employees);

if($role == 'employee') header("Location: ../dashboard.php");
else header("Location: manage_employees.php");
?>
