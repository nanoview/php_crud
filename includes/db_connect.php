<?php
// Load environment variables from .env file
function loadEnv($file) {
    if (!file_exists($file)) {
        return;
    }
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Skip comments
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
        }
    }
}

// Load .env file
loadEnv(__DIR__ . '/../.env');

// Database configuration from environment variables
$serverName = $_ENV['DB_HOST'] ?? 'localhost';
$username = $_ENV['DB_USERNAME'] ?? '';
$password = $_ENV['DB_PASSWORD'] ?? '';
$dbname = $_ENV['DB_NAME'] ?? 'arif_student_db';
$port = intval($_ENV['DB_PORT'] ?? 3306);
$serverName = "localhost";  // DB host or IP (force TCP; use VPS private IP if DB is remote)
$username = "arif_student_db"; // DB user matching your grants
$password = "FW5kG7DqW5Vh";     // DB password
$dbname   = "arif_student_db"; // DB name
$port     = 3306;                  // MariaDB/MySQL port

// Create connection (explicit port enforces TCP)
$conn = @new mysqli($serverName, $username, $password, $dbname, $port);

// Set charset early for consistent encoding
if ($conn && !$conn->connect_errno) {
	$conn->set_charset('utf8mb4');
}

// Fail fast with clear diagnostics for AJAX callers
if ($conn->connect_errno) {
	http_response_code(500);
	// Log-friendly minimal output (avoid leaking credentials)
	echo "Database connection failed. Please try again later.";
	// Optionally log details to server logs
	// error_log('DB connect error (' . $conn->connect_errno . '): ' . $conn->connect_error);
	exit;
}