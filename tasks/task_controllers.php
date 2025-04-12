<?php
$mysqli = new mysqli("localhost", "root", "", "ems");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function getTasks() {
    global $mysqli;
    $result = $mysqli->query("SELECT * FROM tasks");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addTask($name) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO tasks (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->close();
}

function deleteTask($task_id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM tasks WHERE task_id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();
}

function updateTask($task_id, $name) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE tasks SET name = ? WHERE task_id = ?");
    $stmt->bind_param("si", $name, $task_id);
    $stmt->execute();
    $stmt->close();
}
?>
