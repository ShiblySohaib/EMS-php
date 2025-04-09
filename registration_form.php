<!-- index.php - Main Page -->
<?php include 'login_data.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>employee Management</title>
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
        a{
            color: #006081;
            text-decoration: none;
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
    <h1>employee Registration Management System</h1>
    <h3>Register</h3>
    <form action="register.php" method="POST">
        <input type="text" name="id" placeholder="user ID" required>
        <select name="role" placeholder="Role" required>
            <option value="" readonly selected>Select Role</option>
            <?php
            $roles = ['admin', 'supervisor', 'employee'];
            foreach ($roles as $role): ?>
                <option value="<?= $role?>"><?= $role ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="name" placeholder="Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
