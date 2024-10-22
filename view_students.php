<?php
include 'db_connect.php';

$sql = "SELECT id, first_name, last_name, email, phone, created_at FROM students";
$result = $conn->query($sql);

echo '<div class = "ft">';
if ($result->num_rows > 0) {
    echo "<h1>Students List</h1>";
    echo '<table id="customers">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>';
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['first_name']."</td>
                <td>".$row['last_name']."</td>
                <td>".$row['email']."</td>
                <td>".$row['phone']."</td>
                <td>".$row['created_at']."</td>
                 <td>
                    <a href='update_student.php?id=".$row['id']."'>Update</a> | 
                    <a href='delete_student.php?id=".$row['id']."' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
    echo '</div>';
} else {
    echo "0 students found.";
}

$conn->close();
?>
