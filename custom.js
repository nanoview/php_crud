function hideAllSections() {
  var sections = document.getElementsByClassName("form-container");
  for (var i = 0; i < sections.length; i++) {
    sections[i].style.display = "none";
  }
}

function showSection(sectionId) {
  hideAllSections(); // Hide all sections
  var formContainer = document.getElementById(sectionId);
  formContainer.style.display = "block"; // Show the selected section
}

function showForm() {
  showSection("studentForm");
}

function view_students() {
    $.ajax({
        url: 'view_students.php',
        type: 'GET',
        success: function(data) {
            $('#studentTable').html(data);  // Update table with fresh data
            showSection("studentTable");    // Ensure the section is visible
        }
    });
}

/*
function update_student() {
  $.ajax({
    url:'update_students.php',
    type: 'GET',
    success: function(data){
      $('#updateStudent').html(data);
      showSection("updateStudent");
    }
  })
}
*/

/* New function for updater.php for interactive editing*/
function update_student() {
  $.ajax({
    url:'updater.php',
    type: 'GET',
    success: function(data){
      $('#updateStudent').html(data);
      showSection("updateStudent");
    }
  })
}

//function delete_student() {
  //showSection("deleteStudent");

  function delete_students() {
    $.ajax({
        url: 'delete_students.php',
        type: 'GET',
        success: function(data) {
            console.log(data); // Log the response to the console
            $('#deleteStudent').html(data);  // Update section with new content
            showSection("deleteStudent");     // Ensure the section is visible
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + status + ": " + error); // Log any AJAX errors
        }
    });
}


function deleteRow(id) {
  $.ajax({
      url: 'delete_action.php',
      type: 'GET',
      data: { id: id },
      success: function(response) {
          if (response == 1) {
              // Remove the row from the DOM
              $('#row_' + id).remove();
              
              // Refresh the student list to reflect the deletion
              delete_students();
          } else {
              alert('Failed to delete the row.');
          }
      }
  });
}

/*
function loadUpdateForm(id) {
  $.ajax({
      url: 'update_action.php',
      type: 'GET',
      data: { id: id },
      success: function(data) {
          $('#updateStudent').html(data); // Display the update form in the designated section
          showSection("updateStudent"); // Show the update form section
      }
  });
}
*/

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
    url: "update_action.php",
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
