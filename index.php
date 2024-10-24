<?php include 'header.php'; ?>



<div class="mycontainer">
    <div class="box">
        <button class="button" onclick="showForm()">Add student</button>
    </div>

    <div class="box">
        <button class="button" onclick="view_students()">View students</button>
    </div>

    <div class="box">
        <button class="button" onclick="update_student()">Update student</button>
    </div>

    <div class="box">
        <button class="button" onclick="delete_student()">Delete student</button>
    </div>
</div>

<div id="studentForm" class="form-container" style="display: none;">
    <?php include 'add_student.php'; ?>
</div>

<div id="studentTable" class="form-container" style="display: none;">
    <?php include 'view_students.php'; ?>
</div>

<div id="updateStudent" class="form-container" style="display: none;">
    <?php include 'update_students.php'; ?>
</div>

<div id="deleteStudent" class="form-container" style="display: none;">
    <?php include 'delete_students.php'; ?>
</div>

<div class="tbox">
    <h2>Display success or error messages</h2>


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

<?php include 'footer.php'; ?>