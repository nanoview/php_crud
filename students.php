<?php
// Start session to handle messages
session_start();

// Include database connection
include 'db_connect.php';

$success_msg = '';
$error_msg = '';

// Handle Update request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // SQL query to update the student
    $sql = "UPDATE students SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone = '$phone' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_msg'] = "Student updated successfully.";
        header("Location: students.php");
        exit();
    } else {
        $error_msg = "Error updating student: " . $conn->error;
    }
}

// Handle Delete request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM students WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_msg'] = "Student deleted successfully.";
        //header("Location: students.php");
        header("Location: index.php");
        exit();
    } else {
        $error_msg = "Error deleting student: " . $conn->error;
    }
}

// Display success message after redirect
if (isset($_SESSION['success_msg'])) {
    $success_msg = $_SESSION['success_msg'];
    unset($_SESSION['success_msg']);  // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
</head>
<body>

<h1>Manage Students</h1>

<!-- Display success or error messages -->
<?php
if (!empty($success_msg)) {
    echo "<p style='color: green;'>$success_msg</p>";
}
if (!empty($error_msg)) {
    echo "<p style='color: red;'>$error_msg</p>";
}
?>

<!-- View and Update Students Inline Table -->
<h2>Students List</h2>
<form action="students.php" method="POST">
    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php
        $sql = "SELECT id, first_name, last_name, email, phone, created_at FROM students";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>" . $row['id'] . "</td>
                    <td><input type='text' name='first_name' value='" . $row['first_name'] . "' required></td>
                    <td><input type='text' name='last_name' value='" . $row['last_name'] . "' required></td>
                    <td><input type='email' name='email' value='" . $row['email'] . "' required></td>
                    <td><input type='text' name='phone' value='" . $row['phone'] . "' required></td>
                    <td>" . $row['created_at'] . "</td>
                    <td>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='submit' name='update_student' value='Update'>
                        <a href='students.php?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No students found.</td></tr>";
        }
        ?>
    </table>
</form>

</body>
</html>

<?php
$conn->close();
?>
