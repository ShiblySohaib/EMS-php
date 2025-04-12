<?php
require 'user_controllers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateUser($_POST['user_id'], $_POST['name'], $_POST['role']);
    header("Location: manage_users.php");
    exit();
}
?>
