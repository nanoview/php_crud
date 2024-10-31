<?php
ob_start();
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the current student details using prepared statement
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" stands for integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit();
    }

    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use prepared statements to update the student
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE students SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param( $first_name, $last_name, $email, $phone, $id);

    if ($stmt->execute()) {
        // Redirect after a successful update
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating student: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
ob_end_flush(); // End output buffering and send the output to the browser
?>

<h1>Update Student Details</h1>

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