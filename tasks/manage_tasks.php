<?php
require 'task_controllers.php';

session_start();
if (!isset($_SESSION['role'])) {
    echo "Unauthorized access!";
    exit();
}

$tasks = getTasks();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    addTask(trim($_POST['name']));
    echo "<script>alert('Task added successfully!'); window.location.href='manage_tasks.php';</script>";
    exit();
}

if (isset($_GET['delete']) && isset($_GET['task_id'])) {
    deleteTask($_GET['task_id']);
    header("Location: manage_tasks.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Task Management</title>
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
    <h1>Task Management System</h1>
    <div style="text-align: left;">
        <a href="../dashboard.php" style="background-color:#006081;">← Back to Dashboard</a>
    </div>

    <h3>Add Task</h3>
    <form action="manage_tasks.php" method="POST">
        <input type="text" name="name" placeholder="Task Name" required>
        <button type="submit">Add Task</button>
    </form>

    <h3>Task List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        <?php foreach ($tasks as $task) { ?>
            <tr>
                <td><?php echo $task['task_id']; ?></td>
                <td><?php echo $task['name']; ?></td>
                <td>
                    <a href='edit_task.php?task_id=<?php echo $task['task_id']; ?>'>Edit</a>
                    <a href='manage_tasks.php?delete=true&task_id=<?php echo $task['task_id']; ?>' class="delete">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>