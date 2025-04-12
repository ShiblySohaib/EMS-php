<?php
require 'user_controllers.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Unauthorized access!";
    exit();
}

$users = getUsers();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['password'], $_POST['role'])) {
    addUser($_POST['name'], $_POST['password'], $_POST['role']);
    echo "<script>alert('User added successfully!'); window.location.href='manage_users.php';</script>";
    exit();
}

if (isset($_GET['delete']) && isset($_GET['user_id'])) {
    deleteUser($_GET['user_id']);
    header("Location: manage_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #f8f9fa;
        }
        h1, h3 { color: #333; }
        form {
            width: 30%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            margin-top: 15px;
            padding: 10px;
            background: #006081;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover { background: #006081; }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
            text-align: center;
        }
        th {
            background: #006081;
            color: white;
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
        a:hover {
            opacity: 0.8;
        }
        h1 {
            background-color:#006081;
            color: #f8f9fa;
            padding: 10px 0px;
        }
    </style>
</head>

<body>
    <h1>Employee Management System</h1>
    <div style="text-align: left; ">
        <a href="../dashboard.php" style="text-align: left; background-color:#006081;">< Back to Dashboard</a>
    </div>

    <h3>Add User</h3>
    <form action="manage_users.php" method="POST">
        <input type="text" name="name" placeholder="User Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="supervisor">Supervisor</option>
            <option value="employee">Employee</option>
        </select>
        <button type="submit">Add User</button>
    </form>

    <h3>User List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <a href='edit_user.php?user_id=<?php echo $user['user_id']; ?>'>Edit</a>
                    <a href='manage_users.php?delete=true&user_id=<?php echo $user['user_id']; ?>' class="delete">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>