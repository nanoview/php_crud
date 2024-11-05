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

function submitUpdateForm(event, id) {
  event.preventDefault(); // Prevent normal form submission

  $.ajax({
      url: 'update_action.php',
      type: 'POST',
      data: $('#updateForm').serialize(), // Send form data
      success: function(response) {
          alert(response); // Alert success message or error
          update_student(); // Call function to refresh the student list
      }
  });
}

function enableEdit(id) {
  $(`#row-${id} .view-mode`).hide();
  $(`#row-${id} .edit-mode`).removeClass('hidden');
}

function saveEdit(id) {
  const newName = $(`#row-${id} input[data-field="name"]`).val();
  const newEmail = $(`#row-${id} input[data-field="email"]`).val();
  const newAge = $(`#row-${id} input[data-field="age"]`).val();

  $.ajax({
      url: "update.php",
      type: "POST",
      data: { id: id, name: newName, email: newEmail, age: newAge },
      success: function(response) {
          if (response === "success") {
              $(`#row-${id} span[data-field="name"]`).text(newName);
              $(`#row-${id} span[data-field="email"]`).text(newEmail);
              $(`#row-${id} span[data-field="age"]`).text(newAge);

              $(`#row-${id} .edit-mode`).addClass('hidden');
              $(`#row-${id} .view-mode`).show();

              alert("Record updated successfully!");
          } else {
              alert("Update failed!");
          }
      }
  });
}

function cancelEdit(id) {
  $(`#row-${id} .edit-mode`).addClass('hidden');
  $(`#row-${id} .view-mode`).show();
}