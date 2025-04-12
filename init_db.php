<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ems";

// Connect to MySQL server
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Check if database exists
$dbExists = $conn->query("SHOW DATABASES LIKE '$dbname'")->num_rows > 0;

if (!$dbExists) {
    createDbAndTables($conn);
} else {
    // Select the DB
    $conn->select_db($dbname);

    // Check if tables exist
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

// Update stored passwords with hashed versions
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE name = ?");

$hashedPasswords = [
    ["shibly", password_hash("123", PASSWORD_BCRYPT)],
    ["Rayhan", password_hash("123", PASSWORD_BCRYPT)]
];

foreach ($hashedPasswords as $user) {
    $stmt->bind_param("ss", $user[1], $user[0]);
    $stmt->execute();
}

$stmt->close();
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
