<?php
$servername = "localhost";  // Replace with your server host (if not localhost)
$username = "root";         // Replace with your DB username
$password = "";             // Replace with your DB password
$dbname = "students_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
