<?php
require 'user_controllers.php';

if (isset($_GET['user_id'])) {
    deleteUser($_GET['user_id']);
    header("Location: manage_users.php");
    exit();
}
?>
