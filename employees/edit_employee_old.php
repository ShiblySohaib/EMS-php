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

$user_id = $_GET['user_id'];
$employee = getEmployee($user_id);

$depts = getDepts();
$tasks = getTasks();
$allUserIds = getAllUserIds();
$userTasksData = getUserTasks($user_id);
$employeeTaskNames = array_column($userTasksData, 'task_name');
$employeeDept = $userTasksData[0]['dept_name'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
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
        }
        button:hover {
            background: #006081;
        }
        a {
            padding: 5px 10px;
            text-decoration: none;
            background: #28a745;
            color: white;
            border-radius: 5px;
            margin-right: 5px;
        }
        a.delete { background: #dc3545; }
        a:hover { opacity: 0.8; }
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
        .task-choice input { width: auto; }
    </style>
    <script>
        function validateUserId() {
            var userId = document.getElementById('user_id').value;
            var valid = true;
            var message = '';

            var oldUserId = "<?= $employee['user_id'] ?>";
            var existingUserIds = <?= json_encode(array_column($allUserIds, 'user_id')); ?>;

            // Remove the current user's ID from the list
            existingUserIds = existingUserIds.filter(id => id !== oldUserId);

            if (!Number.isInteger(parseInt(userId))) {
                message = 'User ID must be a valid integer!';
                valid = false;
            } else if (existingUserIds.includes(userId)) {
                message = 'User ID already exists!';
                valid = false;
            }

            if (!valid) {
                alert(message);
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h1>Edit Employee Info</h1>
    <form action="update_employee.php" method="POST" onsubmit="return validateUserId()">

        <!-- Hidden old user ID -->
        <input type="hidden" name="old_user_id" value="<?= $employee['user_id'] ?>">

        <!-- Editable user ID -->
        <input type="text" name="user_id" id="user_id" value="<?= $employee['user_id'] ?>" required>

        <!-- Name -->
        <input type="text" name="name" placeholder="Name" value="<?= $employee['name']; ?>" required>

        <!-- Department Select -->
        <select name="dept" required <?= $role !== 'admin' ? 'disabled' : '' ?>>
            <option value="" readonly>Select Dept</option>
            <?php foreach ($depts as $dept): ?>
                <option value="<?= $dept['name'] ?>" <?= $employeeDept == $dept['name'] ? 'selected' : ''; ?>>
                    <?= $dept['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Hidden dept input if not admin -->
        <?php if ($role !== 'admin'): ?>
            <input type="hidden" name="dept" value="<?= $employeeDept ?>">
        <?php endif; ?>

        <!-- Task Checklist -->
        <div class="task-choice">
            <label>Choose Tasks:</label><br>
            <?php foreach ($tasks as $task): ?>
                <input 
                    type="checkbox" 
                    name="tasks[]" 
                    value="<?= $task['task_id'] ?>" 
                    <?= in_array($task['name'], $employeeTaskNames) ? 'checked' : ''; ?>>
                <?= htmlspecialchars($task['name']) ?><br>
            <?php endforeach; ?>
        </div>

        <!-- Update Button -->
        <button type="submit">Update</button>
    </form>
</body>
</html>