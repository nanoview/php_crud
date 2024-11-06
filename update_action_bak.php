<?php
include 'db_connect.php';

// Check if student ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch the student details
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        exit("Student not found.");
    }
    $stmt->close();
}

// Handle the update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE students SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $id);

    if ($stmt->execute()) {
        echo "Student updated successfully.";
    } else {
        echo "Error updating student: " . $stmt->error;
    }

    $stmt->close();
    exit;
}
$conn->close();
?>

<!-- Update form -->
<form id="updateForm" method="POST" onsubmit="submitUpdateForm(event, <?php echo $id; ?>)">
    <!-- Form fields here -->
</form>
