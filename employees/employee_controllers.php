<?php
$mysqli = new mysqli("localhost", "root", "", "ems");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function getAllUserTasks() {
    global $mysqli;

    $query = "
        SELECT 
            ut.user_id,
            u.name AS user_name,
            ut.task_id,
            t.name AS task_name,
            ut.dept_name
        FROM user_tasks ut
        JOIN users u ON ut.user_id = u.user_id
        JOIN tasks t ON ut.task_id = t.task_id
    ";

    $result = $mysqli->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}


function getUserTasks($user_id) {
    global $mysqli;

    $stmt = $mysqli->prepare("
        SELECT 
            ut.user_id,
            u.name AS user_name,
            ut.task_id,
            t.name AS task_name,
            ut.dept_name
        FROM user_tasks ut
        JOIN users u ON ut.user_id = u.user_id
        JOIN tasks t ON ut.task_id = t.task_id
        WHERE ut.user_id = ?
    ");
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


function getEmployee($user_id) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("SELECT user_id, name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


function getAllUserIds() {
    global $mysqli;

    $query = "SELECT user_id FROM users";
    $result = $mysqli->query($query);
    
    return $result->fetch_all(MYSQLI_ASSOC);
}




function updateEmployee($old_user_id, $new_user_id, $name, $dept, $tasks) {
    global $mysqli;

    $updateUserQuery = "UPDATE users SET user_id = ?, name = ? WHERE user_id = ?";
    $stmt = $mysqli->prepare($updateUserQuery);
    $stmt->bind_param("isi", $new_user_id, $name, $old_user_id);
    $stmt->execute();

    $deleteTasksQuery = "DELETE FROM user_tasks WHERE user_id = ?";
    $stmt = $mysqli->prepare($deleteTasksQuery);
    $stmt->bind_param("i", $old_user_id);
    $stmt->execute();

    foreach ($tasks as $task_id) {
        $insertTaskQuery = "INSERT INTO user_tasks (user_id, task_id, dept_name) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($insertTaskQuery);
        $stmt->bind_param("iis", $new_user_id, $task_id, $dept);
        $stmt->execute();
    }

    return true;
}


function deleteEmployee($user_id) {
    global $mysqli;

    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}



function registerEmployee($name, $password, $role) {
    global $mysqli;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Secure password hashing

    $stmt = $mysqli->prepare("INSERT INTO users (name, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $hashed_password, $role);
    $stmt->execute();
    $stmt->close();
}
?>
