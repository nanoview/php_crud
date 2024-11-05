<?php
include 'db_connect.php';

// Fetch all student records
$result = $conn->query("SELECT * FROM students_del");
?>

<h2>Student Records</h2>
<table id="students">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="studentTable"></tbody>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr id="row-<?php echo $row['id']; ?>">
            <td><?php echo $row['id']; ?></td>
            <td>
                <span class="view-mode" data-field="name"><?php echo $row['name']; ?></span>
                <input class="edit-mode hidden" type="text" data-id="<?php echo $row['id']; ?>" data-field="name" value="<?php echo $row['name']; ?>">
            </td>
            <td>
                <span class="view-mode" data-field="email"><?php echo $row['email']; ?></span>
                <input class="edit-mode hidden" type="text" data-id="<?php echo $row['id']; ?>" data-field="email" value="<?php echo $row['email']; ?>">
            </td>
            <td>
                <span class="view-mode" data-field="age"><?php echo $row['age']; ?></span>
                <input class="edit-mode hidden" type="number" data-id="<?php echo $row['id']; ?>" data-field="age" value="<?php echo $row['age']; ?>">
            </td>

            <td>
                <button onclick="enableEdit(<?php echo $row['id']; ?>)">Edit</button>
                <button class="edit-mode hidden" onclick="saveEdit(<?php echo $row['id']; ?>)">Save</button>
                <button class="edit-mode hidden" onclick="cancelEdit(<?php echo $row['id']; ?>)">Cancel</button>
            </td>
        </tr>
    <?php } ?>

</table>

<!-- JavaScript and AJAX for interactive editing -->