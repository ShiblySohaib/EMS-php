<?php
session_start();
if (!isset($_SESSION['role'])) {
    echo "Unauthorized access!";
    exit();
}
$role = $_SESSION['role'];
$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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

        .logout {
            padding: 5px 10px;
            text-decoration: none;
            background: #dc3545;
            color: white;
            border-radius: 5px;
        }

        .logout:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="role-display">
        <span>Logged in as: <strong><?php echo $role; ?></strong></span>
        <a class="logout" href="logout.php">Log Out</a>
    </div>
    <h1>Dashboard</h1>

    <div class="button-container">
        <?php if ($role === "admin") { ?>
            <a href="users/manage_users.php">Manage Users</a>
            <a href="employees/manage_employees.php">Manage Employees</a>
            <a href="tasks/manage_tasks.php">Manage Tasks</a>
            <a href="depts/manage_depts.php">Manage Departments</a>
        <?php } elseif ($role === "supervisor") { ?>
            <a href="employees/manage_employees.php">Manage Employees</a>
            <a href="tasks/manage_tasks.php">Manage Tasks</a>
        <?php } elseif ($role === "employee") {
            require_once 'users/user_controllers.php';
            global $mysqli;

            $stmt = $mysqli->prepare("SELECT user_id FROM users WHERE user_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo '<a href="employees/edit_employee.php?user_id=' . $id . '">Assign Tasks</a>';
            } else {
                echo "<p>User ID not found.</p>";
            }
            $stmt->close();
        } ?>
    </div>
</body>

</html>