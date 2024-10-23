<?php
session_start(); // Start the session to use session variables
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" indicates the type is integer

    if ($stmt->execute() === TRUE) {
        // Set a success message in the session
        $_SESSION['message'] = "Student deleted successfully.";
    } else {
        // Set an error message in the session if the deletion fails
        $_SESSION['message'] = "Error deleting student: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
    
    // Redirect back to the view page after deletion
    header("Location: index.php");
    exit();
} else {
    // Set an invalid request message if no ID is provided
    $_SESSION['message'] = "Invalid request.";
    header("Location: index.php");
    exit();
}

// Close the database connection
$conn->close();

session_start(); // Start the session to access session variables
include 'db_connect.php';

// Display the message if set
if (isset($_SESSION['message'])) {
    echo "<div class='message'>{$_SESSION['message']}</div>";
    unset($_SESSION['message']); // Clear the message after displaying
}

// Fetch the students list
$sql = "SELECT id, first_name, last_name, email, phone, created_at FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Students List</h1>";
    echo '<table id="students">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>';
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['first_name']."</td>
                <td>".$row['last_name']."</td>
                <td>".$row['email']."</td>
                <td>".$row['phone']."</td>
                <td>".$row['created_at']."</td>
                <td>
                    <a href='delete_student.php?id=".$row['id']."' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 students found.";
}

// Close the database connection
$conn->close();
?>
