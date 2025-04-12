<?php
$mysqli = new mysqli("localhost", "root", "", "ems");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function getUsers() {
    global $mysqli;
    $result = $mysqli->query("SELECT * FROM users");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addUser($name, $password, $role) {
    global $mysqli;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $mysqli->prepare("INSERT INTO users (name, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $hashed_password, $role);
    $stmt->execute();
    $stmt->close();
}

function deleteUser($user_id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

function updateUser($user_id, $name, $role) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE users SET name = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $name, $role, $user_id);
    $stmt->execute();
    $stmt->close();
}
?>
