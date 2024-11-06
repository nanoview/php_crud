<?php
session_start();

// Include database connection
include 'db_connect.php';

$success_msg = '';
$error_msg = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check the number of rows in the students table
    $count_result = $conn->query("SELECT COUNT(*) AS total FROM students");
    $row = $count_result->fetch_assoc();
    $total_students = $row['total'];

    if ($total_students < 10) {
        // Proceed with data insertion
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Insert student data into the database
        $sql = "INSERT INTO students (first_name, last_name, email, phone) 
                VALUES ('$first_name', '$last_name', '$email', '$phone')";

        if ($conn->query($sql) === TRUE) {
            // Store success message in session and redirect
            $_SESSION['success_msg'] = "New student added successfully.";
            header("Location: index.php");  // Redirect to the same page
            exit();  // Stop further script execution after redirect
        } else {
            $error_msg = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $error_msg = "You can add a maximum of 10 students.";
    }
}

// Check if a success message is available after redirect
if (isset($_SESSION['success_msg'])) {
    $success_msg = $_SESSION['success_msg'];
    unset($_SESSION['success_msg']);  // Clear the message after displaying
}
?>
 <h1 style="color: fuchsia">Add student in the form below.</h1>


   

    <!-- Display success or error message -->
    <?php if ($success_msg) echo "<p style='color: green;'>$success_msg</p>"; ?>
    <?php if ($error_msg) echo "<p style='color: red;'>$error_msg</p>"; ?>
<div class="form">
    <form  action="" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>

        <input type="submit" value="Add Student">
    </form>
    </div>
