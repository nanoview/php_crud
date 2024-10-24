<?php
// Start the session at the beginning
session_start();

// Include database connection
include 'db_connect.php';

// Check if an ID has been provided for deletion
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" means the parameter is an integer

    if ($stmt->execute()) {
        // Redirect back to the student list after deletion
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting student: " . $conn->error;
    }

    $stmt->close();
} else {
    // Redirect if no id is provided
    header("Location: index.php");
    exit();
}

$conn->close();
?>
