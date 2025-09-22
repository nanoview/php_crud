

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
          // If the response contains a table, wrap it for horizontal scroll on mobile
          const $html = $('<div>').html(response);
          $html.find('table').each(function(){
            $(this).wrap('<div class="table-responsive"></div>');
          });
          $('#' + containerId).html($html.html());
      showMessage('Loaded content successfully.', 'success');
      },
      error: function(xhr, status, error) {
      const msg = xhr && xhr.responseText ? xhr.responseText : (error || 'Unknown error');
      $('#' + containerId).html('<p>Error loading content: ' + msg + '</p>');
      showMessage('Error loading content: ' + msg, 'error');
      }
  });
}
function submitAddStudentForm(event) {
  event.preventDefault(); // Prevent the form from submitting traditionally

  $.ajax({
      url: 'includes/add_action.php',
      type: 'POST',
      data: $('#addStudentForm').serialize(),
      dataType: 'json',
      success: function(resp) {
        if (resp && resp.success) {
          showMessage(resp.message || 'Student added successfully.', 'success');
          $('#addStudentForm')[0].reset();
          loadForm('studentForm', 'includes/student_form.php');
        } else {
          showMessage((resp && resp.message) ? resp.message : 'Submission failed', 'error');
        }
      },
      error: function(xhr, status, error) {
        let msg = 'Unknown error';
        try { const j = JSON.parse(xhr.responseText); if (j && j.message) msg = j.message; } catch(e) { msg = xhr.responseText || error || msg; }
        console.error('Submission failed: ' + status + ': ' + msg);
        showMessage('Submission failed: ' + msg, 'error');
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
    const msg = xhr && xhr.responseText ? xhr.responseText : (error || 'Unknown error');
    console.error("AJAX Error: " + status + ": " + msg);
    showMessage('Delete failed: ' + msg, 'error');
  });
}

function reloadStudentList() {
  $.get('includes/delete_students.php', function(response) {
    $('#deleteStudent').html(response); // Replace the table content dynamically
  }).fail(function(xhr, status, error) {
    const msg = xhr && xhr.responseText ? xhr.responseText : (error || 'Unknown error');
    console.error("AJAX Error: " + status + ": " + msg);
    showMessage('Reload list failed: ' + msg, 'error');
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
        showMessage('Record updated successfully!', 'success');
      } else {
        alert("Update failed!");
        showMessage('Update failed', 'error');
      }
    },
    error: function(xhr, status, error) {
      const msg = xhr && xhr.responseText ? xhr.responseText : (error || 'Unknown error');
      alert("An error occurred while updating.");
      showMessage('Update error: ' + msg, 'error');
    }
  });
}

function cancelEdit(id) {
  // Hide edit mode, show view mode
  $(`#row-${id} .edit-mode`).addClass('hidden').hide();
  $(`#row-${id} .view-mode`).show();
}

// Global message helper
function showMessage(text, type) {
  const bar = $('#globalMessage');
  if (!bar.length) return;
  bar.removeClass('hidden success error info');
  const css = type === 'error' ? 'error' : (type === 'info' ? 'info' : 'success');
  bar.addClass(css).text(text).fadeIn(150);

  // Auto-hide after 4 seconds
  clearTimeout(window.__msgTimer);
  window.__msgTimer = setTimeout(() => {
    bar.fadeOut(200, function(){ $(this).addClass('hidden').show(); });
  }, 4000);
}

// On page load, check DB health and notify globally
$(function(){
  $.ajax({
    url: 'includes/health.php',
    method: 'GET',
    dataType: 'json'
  }).done(function(data){
    if (data && data.status === 'ok') {
      showMessage('Connected to database', 'success');
    } else {
      showMessage('Database issue detected', 'error');
    }
  }).fail(function(xhr){
    const msg = xhr && xhr.responseText ? xhr.responseText : 'DB health check failed';
    showMessage(msg, 'error');
  });
});
