<?php
require 'dept_controllers.php';

$old_name = $_GET['dept_name'] ?? '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_name = $_POST['old_name'];
    $new_name = $_POST['new_name'];
    $message = editDept($old_name, $new_name);
    $old_name = $new_name;

    if ($message === "Department updated successfully.") {
        echo "<script>alert('$message'); window.location.href='manage_depts.php';</script>";
        exit;
    } else {
        echo "<script>alert('$message');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit dept</title>
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
            background: #004d66;
        }
        h1 {
            background-color: #006081;
            color: #f8f9fa;
            padding: 10px 0px;
        }
    </style>
</head>
<body>
    <h1>Edit dept Info</h1>
    <form method="POST">
        <input type="hidden" name="old_name" value="<?php echo htmlspecialchars($old_name); ?>">
        <div class="container">
            <input type="text" name="new_name" placeholder="Name" value="<?php echo htmlspecialchars($old_name); ?>" required>
        </div>
        <button type="submit">Update</button>
    </form>
</body>
</html>
