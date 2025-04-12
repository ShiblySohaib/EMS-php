<?php
require 'task_controllers.php';

$task_id = $_GET['task_id'] ?? '';
$task = null;

if ($task_id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM tasks WHERE task_id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $task = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateTask($_POST['task_id'], $_POST['name']);
    echo "<script>alert('Task updated successfully!'); window.location.href='manage_tasks.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f9fa;
        }

        h1 {
            background-color: #006081;
            color: #f8f9fa;
            padding: 10px;
        }

        form {
            width: 30%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            background: #004d66;
        }
    </style>
</head>

<body>
    <h1>Edit Task Info</h1>
    <form method="POST">
        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
        <input type="text" name="name" placeholder="Task Name" value="<?php echo $task['name']; ?>" required>
        <button type="submit">Update</button>
    </form>
</body>

</html>