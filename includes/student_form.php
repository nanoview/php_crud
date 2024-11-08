
 <h1 style="color: fuchsia">Add student in the form below.</h1>

<div class="form">
    <form  id="addStudentForm" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>

        <input type="submit" value="Add Student" onclick="submitAddStudentForm(event)">
    </form>
    </div>
