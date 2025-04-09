<?php
// employees.php - Data Storage (Array-based)
$all_users = json_decode(file_get_contents('users/users_data.json'), true) ?? [];
?>
