<?php
header('Content-Type: application/json');
// Include DB connection (will exit with 500 on failure per db_connect.php)
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Basic validation
$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$last_name  = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$email      = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone      = isset($_POST['phone']) ? trim($_POST['phone']) : '';

if ($first_name === '' || $last_name === '' || $email === '' || $phone === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Enforce max 5 students (existing behavior)
$count_result = $conn->query("SELECT COUNT(*) AS total FROM students");
if (!$count_result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to check existing students.']);
    exit;
}
$row = $count_result->fetch_assoc();
$total_students = (int)($row['total'] ?? 0);

if ($total_students > 4) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'You can add a maximum of 5 students.']);
    exit;
}

// Insert using prepared statement
$stmt = $conn->prepare('INSERT INTO students (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)');
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
    exit;
}

$stmt->bind_param('ssss', $first_name, $last_name, $email, $phone);
$ok = $stmt->execute();

if ($ok) {
    echo json_encode(['success' => true, 'message' => 'New student added successfully.']);
} else {
    // Duplicate email likely triggers constraint error; return 409 with specific message
    if ($conn->errno === 1062) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'Email already exists.']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to add student.']);
    }
}

$stmt->close();
$conn->close();


