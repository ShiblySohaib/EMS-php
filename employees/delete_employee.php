<?php
require_once 'employee_controllers.php';
$user_id = intval($_GET['user_id']);
deleteEmployee($user_id);
header("Location: manage_employees.php");
exit;
?>
