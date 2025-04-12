<?php
session_start();
require 'auth_controllers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $password = $_POST['password'];

    $user = authenticate($id, $password);

    if ($user) {
        $_SESSION['role'] = $user['role'];
        $_SESSION['id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid ID or password'); window.location.href='index.php';</script>";
        exit();
    }
}
?>
