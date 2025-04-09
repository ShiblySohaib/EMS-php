<?php
include 'tasks.php';
$no = $_GET['no'];
$task = $tasks[$no];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #f4f4f4;
        }
        h2 {
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
        h1{
            background-color:#006081;
            color: #f8f9fa;
            padding: 10px 0px;
        }
    </style>
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update this task?");
        }
    </script>
</head>
<body>
    <h1>Edit task Info</h1>
    <form action="update_task.php" method="POST" onsubmit="return confirmUpdate()">
        <input type="hidden" name="no" value="<?php echo $no; ?>">
        <div class="container">
            <input type="text" name="name" placeholder="Name" value="<?php echo $task['name']; ?>" required>
        </div>
        <div class="container">
            <input type="text" name="id" placeholder="task ID" value="<?php echo $task['id']; ?>" required>
        </div>
        <button type="submit">Update</button>
    </form>
</body>
</html>
