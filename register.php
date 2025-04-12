<?php
session_start();
require 'auth_controllers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Default role assigned
    $role = 'employee';

    registerUser($name, $password, $role);

    echo "<script>
            alert('Registration successful!');
            window.location.href = 'index.php';
         </script>";
}
?>
