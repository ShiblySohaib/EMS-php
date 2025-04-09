<?php
// employees.php - Data Storage (Array-based)
$employees = json_decode(file_get_contents('employees_data.json'), true) ?? [];
function saveemployeeData($employees) {
    file_put_contents('employees_data.json', json_encode($employees, JSON_PRETTY_PRINT));
}
?>
