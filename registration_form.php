<?php
require 'auth_controllers.php';
require_once 'depts/dept_controllers.php';

global $mysqli;

// Get the next available user_id
$result = $mysqli->query("SELECT MAX(user_id) AS max_id FROM users");
$row = $result->fetch_assoc();
$next_user_id = $row['max_id'] + 1;

// Get departments
$depts = getDepts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employee Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f9fa;
        }

        h1 {
            background-color: #006081;
            color: #f8f9fa;
            padding: 10px 0px;
        }

        form {
            width: 30%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        input, select {
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

    <script>
        function validateForm() {
            const name = document.getElementById("name").value.trim();
            const password = document.getElementById("password").value.trim();

            // Validate name (only letters, max 50 characters)
            const nameRegex = /^[A-Za-z]{1,50}$/;
            if (!nameRegex.test(name)) {
                alert("Name should only contain letters and must be at most 50 characters long.");
                return false;
            }

            // Validate password (only numbers)
            const passwordRegex = /^[0-9]+$/;
            if (!passwordRegex.test(password)) {
                alert("Password should only contain numbers.");
                return false;
            }

            return true;
        }
    </script>

</head>

<body>
    <h1>Employee Registration</h1>
    <h3>Register</h3>
    <form action="register.php" method="POST" onsubmit="return validateForm()">
        <label>User ID (Auto-Generated):</label>
        <input type="text" value="<?php echo $next_user_id; ?>" readonly>

        <input type="text" name="name" id="name" placeholder="Name (letters only, max 50)" required>

        <input type="password" name="password" id="password" placeholder="Password (numbers only)" required>

        <button type="submit">Register</button>
    </form>
</body>

</html>
