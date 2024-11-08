<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Student Management</title>
</head>
<body>

<div class="myContainer">
    <div class="box">
        <button class="button" onclick="loadForm('studentForm', 'includes/student_form.php')">Add Student</button>
    </div>
    <div class="box">
        <button class="button" onclick="loadForm('studentTable', 'includes/view_students.php')">View Students</button>
    </div>
    <div class="box">
        <button class="button" onclick="loadForm('updateStudent', 'includes/updater.php')">Update Student</button>
    </div>
    <div class="box">
        <button class="button" onclick="loadForm('deleteStudent', 'includes/delete_students.php')">Delete Student</button>
    </div>
</div>

<!-- Sections to be populated with AJAX content -->
<div id="studentForm" class="form-container" style="display: none;"></div>
<div id="studentTable" class="form-container" style="display: none;"></div>
<div id="updateStudent" class="form-container" style="display: none;"></div>
<div id="deleteStudent" class="form-container" style="display: none;"></div>

<?php include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
