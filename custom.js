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
    showSection("studentTable");
}

function update_student() {
    showSection("updateStudent");
}

function delete_student() {
    showSection("deleteStudent");
}

function deleteRow(id) {
    $.ajax({
        url: 'delete_action.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            if(response == 1) {
                $('#row_' + id).remove();
            } else {
                alert('Failed to delete the row.');
            }
        }
    });
}