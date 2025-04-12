<?php
require 'user_controllers.php';

$user_id = $_GET['user_id'] ?? '';
$user = null;

if ($user_id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateUser($_POST['user_id'], $_POST['name'], $_POST['role']);
    echo "<script>alert('User updated successfully!'); window.location.href='manage_users.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
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

        input,
        select {
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
    <h1>Edit User Info</h1>
    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="text" name="name" placeholder="User Name" value="<?php echo $user['name']; ?>" required>
        <select name="role" required>
            <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="supervisor" <?= ($user['role'] == 'supervisor') ? 'selected' : ''; ?>>Supervisor</option>
            <option value="employee" <?= ($user['role'] == 'employee') ? 'selected' : ''; ?>>Employee</option>
        </select>
        <button type="submit">Update</button>
    </form>
</body>

</html>