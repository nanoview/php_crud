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
