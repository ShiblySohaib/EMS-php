<?php
$mysqli = new mysqli("localhost", "root", "", "ems");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function authenticate($id, $password) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT user_id, name, password, role FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($user_id, $name, $hashed_password, $role);
    $stmt->fetch();
    $stmt->close();

    if ($user_id && password_verify($password, $hashed_password)) {
        return ['user_id' => $user_id, 'name' => $name, 'role' => $role];
    }
    return false;
}

function registerUser($name, $password, $role) {
    global $mysqli;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Secure password hashing

    $stmt = $mysqli->prepare("INSERT INTO users (name, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $hashed_password, $role);
    $stmt->execute();
    $stmt->close();
}

?>
