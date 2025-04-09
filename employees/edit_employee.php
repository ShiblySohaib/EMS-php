<?php 
include 'employees.php';
$no = $_GET['no'];
$employee = $employees[$no];
$depts = json_decode(file_get_contents('../depts/depts_data.json'), true) ?? [];
$tasks = json_decode(file_get_contents('../tasks/tasks_data.json'), true) ?? [];
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
    <title>Edit employee</title>
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
        .task-choice{
            font-size: small;
            text-align: left;
            padding: 5px;
        }
        .task-choice input{
            width: auto;
        }
        .tasks{
            text-align: left;
            padding-left: 3em;
        }
    </style>
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update this employee?");
        }
    </script>
</head>
<body>
    <h1>Edit employee Info</h1>
    <form action="update_employee.php" method="POST" onsubmit="return confirmUpdate()">
        <input type="hidden" name="no" value="<?php echo $no; ?>">
        <input type="text" name="name" placeholder="Name" value="<?php echo $employee['name']; ?>"  required <?php if ($role == 'employee') echo "readonly"?>>
        <input type="text" name="id" placeholder="employee ID" value="<?php echo $employee['id']; ?>" required  readonly>
        <select name="dept" required  <?php if ($role == 'employee') echo "readonly"?>>
            <option value="" readonly>Select dept</option>
            <?php foreach ($depts as $dept): ?>
                <option value="<?= $dept['name'] ?>" 
                <?php echo ($employee['dept'] == $dept['name']) ? 'selected' : ''; ?>>
                    <?= $dept['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>


        <div class="task-choice">
            <label>Choose tasks:</label><br>
            <?php foreach ($tasks as $task): ?>
                <input type="checkbox" name="tasks[]" value="<?= $task['name'] ?>" 
                <?php echo (in_array($task['name'], $employee['tasks'])) ? 'checked' : ''; ?>> 
                <?= $task['name'] ?><br>
            <?php endforeach; ?>
        </div>

        <button type="submit">Update</button>
    </form>
</body>
</html>
