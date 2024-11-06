<?php
include 'db_connect.php';

// Fetch all student records
$result = $conn->query("SELECT * FROM students");
?>

<h1 style="color:fuchsia">Update Student Records</h1>
<table id="students">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="studentTable"></tbody>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr id="row-<?php echo $row['id']; ?>">
            <td><?php echo $row['id']; ?></td>
            <td>
                <span class="view-mode" data-field="first_name"><?php echo $row['first_name']; ?></span>
                <input class="edit-mode hidden" type="text" data-id="<?php echo $row['id']; ?>" data-field="first_name" value="<?php echo $row['first_name']; ?>">
            </td>
            <td>
                <span class="view-mode" data-field="last_name"><?php echo $row['last_name']; ?></span>
                <input class="edit-mode hidden" type="text" data-id="<?php echo $row['id']; ?>" data-field="last_name" value="<?php echo $row['last_name']; ?>">
            </td>
            <td>
                <span class="view-mode" data-field="email"><?php echo $row['email']; ?></span>
                <input class="edit-mode hidden" type="email" data-id="<?php echo $row['id']; ?>" data-field="email" value="<?php echo $row['email']; ?>">
            </td>
            <td>
                <span class="view-mode" data-field="phone"><?php echo $row['phone']; ?></span>
                <input class="edit-mode hidden" type="text" data-id="<?php echo $row['id']; ?>" data-field="phone" value="<?php echo $row['phone']; ?>">
            </td>
            <td>
                <span class="view-mode" data-field="created_at"><?php echo $row['created_at']; ?></span>
                <input class="edit-mode hidden" type="text" data-id="<?php echo $row['id']; ?>" data-field="created_at" value="<?php echo $row['created_at']; ?>" readonly>
            </td>
            <td>
                <button onclick="enableEdit(<?php echo $row['id']; ?>)">Edit</button>
                <button class="edit-mode hidden" onclick="saveEdit(<?php echo $row['id']; ?>)">Save</button>
                <button class="edit-mode hidden" onclick="cancelEdit(<?php echo $row['id']; ?>)">Cancel</button>
            </td>
        </tr>
    <?php } ?>

</table>
