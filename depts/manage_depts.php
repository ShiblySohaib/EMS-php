<!-- index.php - Main Page -->
<?php
require_once 'controllers.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Unauthorized access!";
    exit;
}

// Handle dept add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dept_name'])) {
    $msg = addDept(trim($_POST['dept_name']));
    echo "<script>alert('$msg'); window.location.href='manage_depts.php';</script>";
    exit();
}


// Handle dept delete
if (isset($_GET['delete']) && isset($_GET['dept_name'])) {
    deleteDept($_GET['dept_name']);
    header("Location: manage_depts.php");
    exit();
}

$depts = getDepts();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dept Management</title>
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
    <h1>Employee Management System</h1>
    <div style="text-align: left; ">
        <a href="../dashboard.php" style="text-align: left; background-color:#006081;">< Back to Dashboard</a>
    </div>
    <h3>Add Dept</h3>
    <form action="manage_depts.php" method="POST">
        <input type="text" name="dept_name" placeholder="Name" required>
        <button type="submit">Add Dept</button>
    </form>
    
    <h3>Dept List</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        <?php foreach ($depts as $index => $dept) { ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $dept['name']; ?></td>
                <td>
                    <a href='edit_dept.php?dept_name=<?php echo urlencode($dept['name']); ?>'>Edit</a>
                    <a href='manage_depts.php?delete=true&dept_name=<?php echo urlencode($dept['name']); ?>' class="delete">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
