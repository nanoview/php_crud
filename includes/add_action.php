<?php
// Include database connection
include 'db_connect.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and process the form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Insert the student data into the database
    $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $phone);

    if ($stmt->execute()) {
        // Return success response
        echo "New student added successfully.";
    } else {
        // Return error message
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

