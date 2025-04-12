<?php 
require_once 'employee_controllers.php';
require_once '..\depts\dept_controllers.php';
require_once '..\tasks\task_controllers.php';
require_once '..\users\user_controllers.php';
session_start();

if (!isset($_SESSION['role'])) {
    echo "Unauthorized access!";
    exit;
}

$role = $_SESSION['role'];
if ($role == 'employee') {
    echo "Unauthorized access!";
    exit;
}

$depts = getDepts(); 
$tasks = getTasks(); 

$search = $_GET['search'] ?? '';
$users = [];

if ($search) {
    global $mysqli;
    $stmt = $mysqli->prepare("
        SELECT DISTINCT u.*
        FROM users u
        LEFT JOIN user_tasks ut ON u.user_id = ut.user_id
        WHERE u.user_id LIKE CONCAT('%', ?, '%') 
           OR u.name LIKE CONCAT('%', ?, '%') 
           OR ut.dept_name LIKE CONCAT('%', ?, '%')
    ");
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $users = getUsers(); 
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Management</title>
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
        .task-choice {
            font-size: small;
            text-align: left;
            padding: 5px;
        }
        .task-choice input {
            width: auto;
        }
        hr {
            border: none;
            height: 1px;
            color: #333;
            background-color: #333;
            margin-left:-10px;
            margin-right:-10px;
        }
        .search-bar {
            width: 80%;
            margin: 0 auto 50px;
        }
        .search-bar input {
            padding: 10px;
            width: 75%;
        }
        .search-bar button {
            width: auto;
        }
        .clear-btn {
            background: #6c757d;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            display: inline-block;
        }
        .clear-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <h1>Employee Registration Management System</h1>
    <div style="text-align: left; ">
        <a href="../dashboard.php" style="text-align: left; background-color:#006081;">< Back to Dashboard</a>
    </div>

    <h3>Search Employee</h3>
    <div class="search-bar">
        <form method="GET">
            <input type="text" name="search" placeholder="Search by ID or Name or Dept" value="<?= htmlspecialchars($search) ?>">
            <br>
            <button type="submit">Search</button>
        </form>
    </div>

    <?php if ($search): ?>
        <a href="manage_employees.php" class="clear-btn">Clear Search</a>
    <?php endif; ?>

    <h3>Employee List</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>ID</th>
            <th>Dept</th>
            <th>Tasks</th>
            <th>Action</th>
        </tr>
        <?php 
        $i = 1;
        foreach ($users as $user): 
            $user_id = $user['user_id'];
            $user_name = $user['name'];
            $dept_name = '';

            $userTasks = getUserTasks($user_id);
            $task_names = [];

            if (!empty($userTasks)) {
                $dept_name = $userTasks[0]['dept_name'] ?? '';
                foreach ($userTasks as $task) {
                    $task_names[] = $task['task_name'];
                }
            }
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($user_name) ?></td>
            <td><?= htmlspecialchars($user_id) ?></td>
            <td><?= htmlspecialchars($dept_name) ?></td>
            <td class="tasks">
                <?php if (empty($task_names)): ?>
                    <p>No current tasks</p>
                <?php else: ?>
                    <?php foreach ($task_names as $index => $task): ?>
                        <div><?= htmlspecialchars($task) ?></div>
                        <?php if ($index < count($task_names) - 1): ?>
                            <hr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </td>
            <td>
                <a href='edit_employee.php?user_id=<?= $user_id ?>'>Edit</a>
                <a href='delete_employee.php?user_id=<?= $user_id ?>' class="delete">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
