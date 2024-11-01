<?php
ob_clean();
ob_start();

include 'db_connect.php'; // Ensure this file has no output

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if student ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current student details using a prepared statement
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" for integer type
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the student was found
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        // Exit if student not found
        exit("Student not found.");
    }

    $stmt->close();
} else {
    // Exit if no student ID is provided
    exit("Invalid request.");
}

// Handle form submission to update the student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update student record using a prepared statement
    $stmt = $conn->prepare("UPDATE students SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $id); // "ssssi" for string and integer types

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect to the index page after a successful update
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating student: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close(); // Close the database connection
ob_end_flush(); // Flush the buffer and send output to the browser
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Student Details</title>
</head>
<body>
    <h1>Update Student Details</h1>

    <!-- Update form for the student details -->
    <form action="" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required><br>

        <input type="submit" value="Update Student">
    </form>
</body>
</html>
