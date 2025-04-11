<?php
$mysqli = new mysqli("localhost", "root", "", "ems");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function getDepts() {
    global $mysqli;
    $result = $mysqli->query("SELECT name FROM depts");
    return $result->fetch_all(MYSQLI_ASSOC);
}


function addDept($name) {
    global $mysqli;

    // Check if dept already exists
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM depts WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        return "Department already exists.";
    }

    // Insert new dept
    $stmt = $mysqli->prepare("INSERT INTO depts (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->close();

    return "Department added successfully.";
}



function deleteDept($dept_name) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM depts WHERE name = ?");
    $stmt->bind_param("s", $dept_name);
    $stmt->execute();
    $stmt->close();
}


function editDept($old_name, $new_name) {
    global $mysqli;

    // Check if new name already exists
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM depts WHERE name = ?");
    $stmt->bind_param("s", $new_name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        return "Department name already exists.";
    }

    // Update department name
    $stmt = $mysqli->prepare("UPDATE depts SET name = ? WHERE name = ?");
    $stmt->bind_param("ss", $new_name, $old_name);
    $stmt->execute();
    $stmt->close();

    return "Department updated successfully.";
}
?>
