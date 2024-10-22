<?php
// Start session at the beginning of the script to handle messages
session_start();

// Include database connection
include 'db_connect.php';

$success_msg = '';
$error_msg = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
}

// Check if a success message is available after redirect
if (isset($_SESSION['success_msg'])) {
    $success_msg = $_SESSION['success_msg'];
    unset($_SESSION['success_msg']);  // Clear the message after displaying
}
?>





<div class="ft">

<form action="" method="POST">
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
<br><br><br><br>
<div class="tbox"><h2>Display success or error messages</h2>


<?php if (!empty($success_msg)): ?>
    <!-- Display boxc when success message is present -->
    <div class="boxc tbox">
        <p style="color: green;"><?php echo htmlspecialchars($success_msg); ?></p>
    </div>
<?php else: ?>
    <!-- Display boxb when success message is absent -->
    <div class="boxb tbox">
        <p>No messages available.</p>
    </div>
<?php endif; ?>
</div>