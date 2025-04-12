<?php
require_once 'employee_controllers.php';
session_start();

if (!isset($_SESSION['role'])) {
    echo "Unauthorized access!";
    exit;
}

$role = $_SESSION['role'];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_user_id = $_POST['old_user_id'];
    $new_user_id = $_POST['user_id']; 
    $name = $_POST['name']; 
    $dept = $_POST['dept']; 
    $tasks = $_POST['tasks'] ?? [];

    updateEmployee($old_user_id, $new_user_id, $name, $dept, $tasks);
    if ($role == 'employee')  header("Location: ../dashboard.php");
    else  header("Location: manage_employees.php");
    exit;
} else {
    echo "Invalid request method!";
    exit;
}
