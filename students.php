<?php
// Start session to handle messages
session_start();

// Include database connection
include 'db_connect.php';

$success_msg = '';
$error_msg = '';

// Handle Delete request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM students WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_msg'] = "Student deleted successfully.";
        header("Location: students.php");
        exit();
    } else {
        $error_msg = "Error deleting student: " . $conn->error;
    }
}

// Handle Update request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE students SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone = '$phone' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_msg'] = "Student updated successfully.";
        header("Location: students.php");
        exit();
    } else {
        $error_msg = "Error updating student: " . $conn->error;
    }
}

// Fetch data for a specific student (if updating)
$student_to_update = null;
if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student_to_update = $result->fetch_assoc();
    } else {
        $error_msg = "Student not found.";
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

<!-- View Students Table -->
<h2>Students List</h2>
<?php
$sql = "SELECT id, first_name, last_name, email, phone, created_at FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['first_name']."</td>
                <td>".$row['last_name']."</td>
                <td>".$row['email']."</td>
                <td>".$row['phone']."</td>
                <td>".$row['created_at']."</td>
                <td>
                    <a href='students.php?action=update&id=".$row['id']."'>Update</a> | 
                    <a href='students.php?action=delete&id=".$row['id']."' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No students found.";
}
?>

<!-- Update Student Form -->
<?php if ($student_to_update): ?>
    <h2>Update Student</h2>
    <form action="students.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $student_to_update['id']; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $student_to_update['first_name']; ?>" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $student_to_update['last_name']; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $student_to_update['email']; ?>" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $student_to_update['phone']; ?>" required><br>

        <input type="submit" name="update_student" value="Update Student">
    </form>
<?php endif; ?>

</body>
</html>
