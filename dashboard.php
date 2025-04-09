<?php
session_start();
if (!isset($_SESSION['role'])) {
    echo "Unauthorized access!";
    exit;
}
$role = $_SESSION['role'];
$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #f8f9fa;
        }
        h1 {
            background-color: #006081;
            color: #f8f9fa;
            padding: 10px 0;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background: #006081;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .button-container a:hover {
            opacity: 0.8;
        }
        .role-display {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 10px;
            color: #555;
        }
        a {
            padding: 5px 10px;
            text-decoration: none;
            background: #28a745;
            color: white;
            border-radius: 5px;
            margin-right: 5px;
        }
        a.delete {
            background: #dc3545;
        }
    </style>
</head>
<body>
    <div class="role-display">
        <span>Logged in as: <strong><?php echo $role; ?></strong></span>
        <a class="delete" href="index.php" style="text-align: left;">Log Out</a>
    </div>
    <h1>Dashboard</h1>
    
    <div class="button-container">
        <?php if ($role === "admin") { ?>
            <a href="users/manage_users.php">Manage Users</a>
            <a href="employees/manage_employees.php">Manage employees</a>
            <a href="tasks/manage_tasks.php">Manage tasks</a>
            <a href="depts/manage_depts.php">Manage depts</a>
        <?php } ?>
        <?php if ($role === "supervisor") { ?>
            <a href="employees/manage_employees.php">Manage employees</a>
            <a href="tasks/manage_tasks.php">Manage tasks</a>
        <?php } ?>
        <?php 
        if ($role === "employee") {
            $employees = json_decode(file_get_contents('employees/employees_data.json'), true) ?? [];
            $no = null;
            
            foreach ($employees as $index => $employee) {
                if ($employee['id'] === $id) {
                    $no = $index;
                    break;
                }
            }
            
            if ($no !== null) {
                echo '<a href="/employees/edit_employee.php?no=' . $no . '">Assign tasks</a>';
            } else {
                echo $no;
            }
        }
        ?>
    </div>
</body>
</html>
