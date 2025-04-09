<?php
// users.php - Data Storage (Array-based)
$users = json_decode(file_get_contents('users_data.json'), true) ?? [];
function saveuserData($users) {
    file_put_contents('users_data.json', json_encode($users, JSON_PRETTY_PRINT));
}
?>
