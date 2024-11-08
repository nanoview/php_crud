

function loadForm(containerId, page) {
  // Hide all containers before displaying the selected one
  $('.form-container').hide();

  // Show loading indicator
  $('#' + containerId).html('<p>Loading...</p>').show();

  // Load the content of the specified page
  $.ajax({
      url: page,
      type: 'GET',
      success: function(response) {
          $('#' + containerId).html(response);
      },
      error: function(xhr, status, error) {
          $('#' + containerId).html('<p>Error loading content: ' + error + '</p>');
      }
  });
}
function submitAddStudentForm(event) {
  event.preventDefault(); // Prevent the form from submitting traditionally

  $.ajax({
      url: 'includes/add_action.php', // PHP file that handles the form submission
      type: 'POST',
      data: $('#addStudentForm').serialize(), // Serialize the form data
      success: function(response) {
          alert(response); // Show a success message (you can customize this)
          $('#addStudentForm')[0].reset(); // Reset the form

          // Optionally, you can reload the form content dynamically
          loadForm('studentForm', 'includes/student_form.php'); // Reload or update content
      },
      error: function(xhr, status, error) {
          console.error("Submission failed: " + status + ": " + error);
      }
  });
}


function deleteRow(id) {
  $.get('includes/delete_action.php', { id: id }, function(response) {
    if (response == 1) {
      $('#row_' + id).fadeOut(300, function() {
        $(this).remove();
      });
      reloadStudentList();
    } else {
      alert('Failed to delete the row.');
    }
  }).fail(function(xhr, status, error) {
    console.error("AJAX Error: " + status + ": " + error);
  });
}

function reloadStudentList() {
  $.get('includes/delete_students.php', function(response) {
    $('#deleteStudent').html(response); // Replace the table content dynamically
  }).fail(function(xhr, status, error) {
    console.error("AJAX Error: " + status + ": " + error);
  });
}

function enableEdit(id) {
  // Switch to edit mode by toggling hidden class
  $(`#row-${id} .view-mode`).hide();
  $(`#row-${id} .edit-mode`).removeClass('hidden').show();

  // Populate the input fields with current values
  const firstName = $(`#row-${id} span[data-field="first_name"]`).text();
  const lastName = $(`#row-${id} span[data-field="last_name"]`).text();
  const email = $(`#row-${id} span[data-field="email"]`).text();
  const phone = $(`#row-${id} span[data-field="phone"]`).text();
  const createdAt = $(`#row-${id} span[data-field="created_at"]`).text();

  // Set values of input fields
  $(`#row-${id} input[data-field="first_name"]`).val(firstName);
  $(`#row-${id} input[data-field="last_name"]`).val(lastName);
  $(`#row-${id} input[data-field="email"]`).val(email);
  $(`#row-${id} input[data-field="phone"]`).val(phone);
  $(`#row-${id} input[data-field="created_at"]`).val(createdAt);
}

function saveEdit(id) {
  const newFirstName = $(`#row-${id} input[data-field="first_name"]`).val();
  const newLastName = $(`#row-${id} input[data-field="last_name"]`).val();
  const newEmail = $(`#row-${id} input[data-field="email"]`).val();
  const newPhone = $(`#row-${id} input[data-field="phone"]`).val();
  const newCreatedAt = $(`#row-${id} input[data-field="created_at"]`).val();

  // Validation
  if (!newFirstName || !newLastName || !newEmail || !newPhone || !newCreatedAt) {
    alert("All fields must be filled out!");
    return;
  }

  $.ajax({
    url: "includes/update_action.php",
    type: "POST",
    data: { 
      id: id, 
      first_name: newFirstName, 
      last_name: newLastName, 
      email: newEmail, 
      phone: newPhone, 
      created_at: newCreatedAt
    },
    success: function(response) {
      if (response === "success") {
        // Update view mode with new data
        $(`#row-${id} span[data-field="first_name"]`).text(newFirstName);
        $(`#row-${id} span[data-field="last_name"]`).text(newLastName);
        $(`#row-${id} span[data-field="email"]`).text(newEmail);
        $(`#row-${id} span[data-field="phone"]`).text(newPhone);
        $(`#row-${id} span[data-field="created_at"]`).text(newCreatedAt);

        // Hide edit mode, show view mode
        $(`#row-${id} .edit-mode`).addClass('hidden').hide();
        $(`#row-${id} .view-mode`).show();

        alert("Record updated successfully!");
      } else {
        alert("Update failed!");
      }
    },
    error: function() {
      alert("An error occurred while updating.");
    }
  });
}

function cancelEdit(id) {
  // Hide edit mode, show view mode
  $(`#row-${id} .edit-mode`).addClass('hidden').hide();
  $(`#row-${id} .view-mode`).show();
}
