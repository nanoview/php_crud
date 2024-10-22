<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL query to delete the student
    $sql = "DELETE FROM students WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Student deleted successfully.";
    } else {
        echo "Error deleting student: " . $conn->error;
    }

    // Redirect back to the view page after deletion
    header("Location: view_students.php");
    exit();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
