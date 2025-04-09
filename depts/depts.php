<?php
// depts.php - Data Storage (Array-based)
$depts = json_decode(file_get_contents('depts_data.json'), true) ?? [];
function savedeptData($depts) {
    file_put_contents('depts_data.json', json_encode($depts, JSON_PRETTY_PRINT));
}
?>
