<!-- update.php - Update user -->
<?php
session_start();
if (!isset($_SESSION['role'])) {
    echo "Unauthorized access!";
    exit;
}
$role = $_SESSION['role'];

include 'users.php';
$no = $_POST['no'];
$users[$no] = [
    'name' => $_POST['name'],
    'id' => $_POST['id'],
    'dept' => $_POST['dept'], 
    'tasks' => isset($_POST['tasks']) ? $_POST['tasks'] : []
];

saveuserData($users);

if($role == 'user') header("Location: ../dashboard.php");
else header("Location: manage_users.php");
?>
