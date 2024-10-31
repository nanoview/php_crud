<?php
ob_start();
if (headers_sent($file, $line)) {
    die("Headers already sent in $file on line $line");
}
// Start session if it’s not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//ob_start();
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
                <td>" . $row['id'] . "</td>
                <td>" . $row['first_name'] . "</td>
                <td>" . $row['last_name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td>" . $row['created_at'] . "</td>
                 <td>
                    <a href='update_action_student.php?id=" . $row['id'] . "' class='action_link'>Update</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 students found.";
}

$conn->close();
ob_flush();
