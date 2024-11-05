<?php

ob_start();


include 'db_connect.php';

$sql = "SELECT id, first_name, last_name, email, phone, created_at FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Update Students List</h1>";
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
        <td><a href='#' onclick='loadUpdateForm(" . htmlspecialchars($row['id']) . ")' class='action_link'>Update</a></td>
      </tr>";
    }
    echo "</table>";
} else {
    echo "<p>0 students found.</p>";
}

// Close the database connection
$conn->close();
//ob_end_flush();
