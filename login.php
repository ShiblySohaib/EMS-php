<?php
session_start();
include 'login_data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $password = $_POST['password'];

    function authenticate($id, $password, $users) {
        foreach ($users as $user) {
            if ($user['id'] === $id && $user['password'] == $password) {
                return $user['role'];
            }
        }
        return false;
    }

    $role = authenticate($id, $password, $all_users);

    if ($role) {
        $_SESSION['role'] = $role;
        $_SESSION['id'] = $_POST['id'];
    } else {
        echo "<script>alert('Invalid id or password'); window.location.href='index.php';</script>";
        exit;
    }

    header("Location: dashboard.php");
    exit;
}
?>
