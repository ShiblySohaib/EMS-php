<!-- index.php - Main Page -->
<?php
$tasks = json_decode(file_get_contents('tasks_data.json'), true) ?? [];
function savetaskData($tasks) {
    file_put_contents('tasks_data.json', json_encode($tasks, JSON_PRETTY_PRINT));
}
session_start();
if (!isset($_SESSION['role'])) {
    echo "Unauthorized access!";
    exit;
}
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>task Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #f8f9fa;
        }
        h1, h3 {
            color: #333;
        }
        form {
            width: 30%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        input {
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
        }
        button:hover {
            background: #006081;
        }
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
        h1{
            background-color:#006081;
            color: #f8f9fa;
            padding: 10px 0px;
        }
    </style>
</head>
<body>
    <h1>employee Management System</h1>
    <div style="text-align: left; ">
        <a href="../dashboard.php" style="text-align: left; background-color:#006081;">< Back to Dashboard</a>
    </div>
    <?php if ($role === "admin") { ?>
        <h3>Add task</h3>
        <form action="add_task.php" method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="id" placeholder="task ID" required>
            <button type="submit">Add task</button>
        </form>
    <?php } ?>
    
    <h3>task List</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>ID</th>
            <th>Action</th>
        </tr>
        <?php foreach ($tasks as $index => $task) { ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $task['name']; ?></td>
                <td><?php echo $task['id']; ?></td>
                <td>
                    <a href='edit_task.php?no=<?php echo $index; ?>'>Edit</a>
                    <a href='delete_task.php?no=<?php echo $index; ?>' class="delete">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
