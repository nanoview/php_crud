<?php
// Database connection
include 'db_connect.php';

if (isset($_POST['id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['created_at'])) {
    $id = intval($_POST['id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = intval($_POST['phone']);
    //$created_at = intval($_POST['created_at']);

    // Prepare and execute update query
    $sql = "UPDATE students SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "success"; // return success string
    } else {
        echo "error"; // return error string
    }
} else {
    echo "error"; // return error string if inputs are invalid
}

$conn->close();
