<?php
include 'db_connect.php';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check the number of rows in the students table
    $count_result = $conn->query("SELECT COUNT(*) AS total FROM students");
    $row = $count_result->fetch_assoc();
    $total_students = $row['total'];

    if ($total_students <=4) {
        // Proceed with data insertion
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Insert student data into the database
        $sql = "INSERT INTO students (first_name, last_name, email, phone) 
                VALUES ('$first_name', '$last_name', '$email', '$phone')";

        if ($conn->query($sql) === TRUE) {
            // Return success response
        echo "New student added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "You can add a maximum of 5 students.";
    }
}


