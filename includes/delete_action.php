<?php

ob_start();

// Include database connection
include 'db_connect.php';

// Check if an ID has been provided for deletion
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" means the parameter is an integer

    if ($stmt->execute()) {
        echo 1; // Success response
    } else {
        echo 0; // Failure response
    }

    $stmt->close();
} else {
    // No ID provided, return failure response
    echo 0; // Indicate that the deletion failed due to invalid request
}

$conn->close();
