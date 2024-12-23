<?php
ob_start(); // Start output buffering
include 'db_connect.php'; // Ensure this file does not output anything before this point

// Start session if it’s not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$sql = "SELECT id, first_name, last_name, email, phone, created_at FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1 style='color:fuchsia'>Delete Students List</h1>";
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
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['first_name']) . "</td>
                <td>" . htmlspecialchars($row['last_name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['phone']) . "</td>
                <td>" . htmlspecialchars($row['created_at']) . "</td>
                <td>
                    <a href=\"javascript:void(0);\" onclick=\"deleteRow(" . (int)$row['id'] . ");\" class=\"action_link\">Delete</a>
                </td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "0 students found.";
}

$conn->close();
