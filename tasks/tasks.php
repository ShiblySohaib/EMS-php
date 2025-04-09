<?php
// tasks.php - Data Storage (Array-based)
$tasks = json_decode(file_get_contents('tasks_data.json'), true) ?? [];
function savetaskData($tasks) {
    file_put_contents('tasks_data.json', json_encode($tasks, JSON_PRETTY_PRINT));
}
?>
