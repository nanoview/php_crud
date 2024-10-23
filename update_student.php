<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the current student details
    $sql = "SELECT * FROM students WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // SQL query to update the student
    $sql = "UPDATE students SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone = '$phone' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Student updated successfully.";
        // Redirect back to view page after update
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating student: couldn't find any row to update" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
</head>
<body>

<h1>Update Student Details</h1>

<form action="" method="POST">
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo $student['first_name']; ?>" required><br>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo $student['last_name']; ?>" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $student['email']; ?>" required><br>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" value="<?php echo $student['phone']; ?>" required><br>

    <input type="submit" value="Update Student">
</form>

</body>
</html>
