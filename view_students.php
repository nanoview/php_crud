<?php

ob_start(); // Start a single output buffer

include 'db_connect.php'; // Ensure this file has no output at all

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
            </tr>';
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['first_name']) . "</td>
                <td>" . htmlspecialchars($row['last_name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['phone']) . "</td>
                <td>" . htmlspecialchars($row['created_at']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 students found.";
}

$conn->close();

//ob_end_flush(); // Flush the single buffer and output content

