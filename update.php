<?php
// Database connection
include 'db_connect.php';

// Check if all required POST data is received
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['age'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $age = intval($_POST['age']);

    // Update the record in the database
    $sql = "UPDATE students_del SET name='$name', email='$email', age=$age WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}

$conn->close();
