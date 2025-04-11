<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ems";

// Connect to MySQL server (no DB selected)
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Check if database exists
$dbExists = $conn->query("SHOW DATABASES LIKE '$dbname'")->num_rows > 0;

if (!$dbExists) {
    createDbAndTables($conn);
} else {
    // Now safely select the DB
    $conn->select_db($dbname);

    // Check if all required tables exist
    $requiredTables = ['users', 'tasks', 'depts', 'user_tasks'];
    $existingTables = [];

    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_array()) {
        $existingTables[] = $row[0];
    }

    $missing = array_diff($requiredTables, $existingTables);

    if (!empty($missing)) {
        createDbAndTables($conn);
    }
}

$conn->close();

// Function to create DB and tables
function createDbAndTables($conn) {
    $sql = file_get_contents("ems.sql");
    if ($conn->multi_query($sql)) {
        while ($conn->more_results() && $conn->next_result()) {}
    } else {
        die("Error creating database or tables: " . $conn->error);
    }
}
?>
